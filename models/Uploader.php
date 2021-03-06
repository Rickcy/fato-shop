<?php

namespace app\models;

use Yii;
use yii\base\Component;
use yii\base\Security;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * Class FileUpload
 *
 * @package app\models
 * @property string $fullName
 */
class Uploader extends Component
{
    /**
     * @var FileUploadTrait
     */
    public $modelClass;
    public $data;
    public $file;
    public $name;
    public $slug;
    public $uid;
    public $delete = true;
    public $folder;

    protected $fileName;
    protected $filePath;

    /**
     * @param $name
     * @return $this
     */
    public function name($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param $data
     * @return $this
     */
    public function data($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @param $path
     * @return $this
     */
    public function folder($path)
    {
        $this->folder = $path;
        return $this;
    }

    /**
     * @param bool $deleteOnFinish
     * @return $this
     */
    public function delete($deleteOnFinish = true)
    {
        $this->delete = $deleteOnFinish;
        return $this;
    }

    /**
     * @return null|string
     */
    protected function getSession()
    {
        if (isset(Yii::$app->session)) {
            Yii::$app->session->open();
            $session = Yii::$app->session->getIsActive() ? Yii::$app->session->getId() : null;
            Yii::$app->session->close();
        } else {
            $session = null;
        }
        return $session;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->name ?: $this->fileName;
    }

    /**
     * @return string
     */
    protected function getFileNameWithOutExtension()
    {
        return basename($this->getFileName(), '.' . $this->getFileExtension());
    }

    /**
     * @return string
     */
    protected function getMimeType()
    {
        return FileHelper::getMimeType($this->filePath);
    }

    /**
     * @return mixed|string
     */
    protected function getFileExtension()
    {
        if (!$extension = strtolower(pathinfo($this->fileName, PATHINFO_EXTENSION))) {
            $extension = ArrayHelper::getValue(FileHelper::getExtensionsByMimeType($this->getMimeType()), 0);
        }
        return $extension;
    }

    /**
     * @return int|null|string
     */
    public function getUserId()
    {
        if (isset(Yii::$app->user)) {
            $userId = Yii::$app->user->getId();
        } else {
            $userId = null;
        }
        return $userId;
    }

    /**
     * @param $source
     * @param $destination
     * @throws \Exception
     */
    public function copy($source, $destination)
    {
        if (is_uploaded_file($source)) {
            if (!move_uploaded_file($source, $destination)) {
                throw new \Exception('Unknown upload error');
            }
        } elseif ($this->delete ? !rename($source, $destination) : !copy($source, $destination)) {
            throw new \Exception('Failed to write file to disk');
        }
    }

    /**
     * @return string
     */
    public function getUid()
    {
        return $this->uid = $this->uid ?: $this->formUid();
    }

    /**
     * @return string
     */
    public function getNewFileAlias()
    {
        return self::formAliasPath($this->getUid(), $this->folder);
    }

    /**
     * @param ActiveRecord $model
     * @param $attributes
     */
    public function loadAttributes($model, $attributes)
    {
        $model->setAttributes($attributes);
    }

    public function formAttributes()
    {
        $this->processFilePath($this->file);
        return [
            'session' => $this->getSession(),
            'name' => $this->getFileNameWithOutExtension(),
            'extension' => $this->getFileExtension(),
            'user_id' => $this->getUserId(),
            'uid' => $this->getUid(),
            'data' => !is_null($this->data) ? json_encode($this->data) : null,
            'mime_type' => $this->getMimeType(),
            'md5' => md5_file($this->filePath),
            'folder' => self::formAliasPath($this->getUid(), $this->folder),
            'slug' => $this->slug,
            'size' => filesize($this->filePath)
        ];
    }

    /**
     * @return FileUploadTrait|null
     * @throws \Exception
     */
    public function process()
    {
        /**
         * @var FileUploadTrait $model
         */
        $model = new $this->modelClass();
        $this->loadAttributes($model, $this->formAttributes());
        $newFilePath = $model->getRealFilePath();
        if (!is_dir($realFolder = dirname($newFilePath))) {
            mkdir($realFolder, 0777, true);
        }
        if (!file_exists($this->filePath)) {
            throw new \Exception('File not loaded or not exist');
        }
        $this->copy($this->filePath, $newFilePath);
        if ($model->save()) {
            return $model;
        } else {
            $model->deleteFile();
            return null;
        }
    }

    /**
     * @param $file
     */
    protected function processFilePath($file)
    {
        if (strpos($file, 'http') === 0) {
            $tmp = Yii::getAlias('@runtime') . DIRECTORY_SEPARATOR . uniqid("fu");
            file_put_contents($tmp, file_get_contents($file));
            $this->filePath = $tmp;
            $this->fileName = basename($file);
        } elseif (is_string($file)) {
            $this->filePath = Yii::getAlias($file);
            $this->fileName = basename($this->filePath);
        } elseif ($file instanceof UploadedFile) {
            $this->filePath = $file->tempName;
            $this->fileName = $file->name;
        }
    }

    /**
     * @param $slug
     * @return $this
     */
    public function slug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return string
     */
    protected function generateUid()
    {
        $sec = new Security();
        return md5($sec->generateRandomString(64));
    }

    /**
     * @return string
     */
    protected function formUid()
    {
        $class = $this->modelClass;
        do {
            $uPath = $this->generateUid();
        } while ($class::find()->where(["uid" => $uPath])->exists());
        return $uPath;
    }

    /**
     * @param $path
     * @param null $aliasPrefix
     * @return string
     */
    public static function formAliasPath($path, $aliasPrefix = null)
    {
        $p = [$aliasPrefix];
        for ($i = 0; $i < 3; $i++) {
            $p[] = $path[$i];
        }
        return join('/', $p);
    }
}