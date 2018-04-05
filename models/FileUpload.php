<?php

namespace app\models;

use app\models\FileUploadTrait;
use Yii;

/**
 * This is the model class for table "file_upload".
 *
 * @property string|array $imageUrl
 */
class FileUpload extends \app\models\base\FileUpload
{
    use FileUploadTrait;





    public function getImageUrl()
    {

        if ($this->fileExist()) {
            return [join('/', ['/files', $this->getFileName()])];
        } else {
            return '/images/product.png';
        }
    }
}
