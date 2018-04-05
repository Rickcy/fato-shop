<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "default_log".
 *
 * @property integer $id
 * @property string $name
 * @property string $crtime
 */
class DefaultLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'default_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['crtime'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'crtime' => 'Crtime',
        ];
    }
}
