<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "properties_product".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $dimensions
 * @property string $blueprint_url
 */
class PropertiesProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'properties_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id'], 'required'],
            [['product_id'], 'integer'],
            [['dimensions'], 'string'],
            [['blueprint_url'], 'string', 'max' => 255],
            [['product_id'], 'unique'],
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
            'dimensions' => 'Dimensions',
            'blueprint_url' => 'Blueprint Url',
        ];
    }
}
