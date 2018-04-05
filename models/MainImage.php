<?php

namespace app\models;

use Yii;
use yii\helpers\BaseFileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "main_image".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $url
 * @property boolean $is_main
 */
class MainImage extends \yii\db\ActiveRecord
{

    /**
     * @var $photoFile UploadedFile
     */
    public $photoFile;




    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'main_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url'], 'required'],
            [['is_main'], 'boolean'],
            [['url'], 'string'],
            [['url'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'url' => 'Url',
            'is_main' => 'Is Main',
        ];
    }

    public function uploadImage($id){


        if(!is_dir(Yii::getAlias('@uploadDir').'/photo_item')){
            BaseFileHelper::createDirectory(Yii::getAlias('@uploadDir').'/photo_item/',0777);
        }
        if(!is_dir(Yii::getAlias('@uploadDir').'/photo_item/'.$id.'/')){
            BaseFileHelper::createDirectory(Yii::getAlias('@uploadDir').'/photo_item/'.$id.'/',0777);
        }

        $url = Yii::$app->security->generateRandomString(10).'.'.$this->photoFile->extension;
        $this->photoFile->saveAs(Yii::getAlias('@uploadDir').'/photo_item/'.$id.'/'.$url);
        chmod(Yii::getAlias('@uploadDir').'/photo_item/'.$id.'/'.$url,0777);
        return '/photo_item/'.$id.'/'.$url;
    }

}
