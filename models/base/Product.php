<?php

/**
 * This class is generated using the package carono/codegen
 */

namespace app\models\base;

use app\models\MainImage;
use app\models\PropertiesProduct;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseFileHelper;

/**
 * This is the base-model class for table "product".
 *
 * @property integer $id
 * @property string $name
 * @property string $article
 * @property string $description
 * @property string $accounting_id
 * @property integer $group_id
 * @property integer $catalog_id
 * @property boolean $is_active
 * @property string $created_at
 * @property string $updated_at
 * @property \app\models\MainImage[] productImages
 * @property \app\models\MainImage mainImage
 * @property \app\models\Offer $offer
 * @property \app\models\Catalog $catalog
 * @property \app\models\Group $group
 * @property \app\models\PropertiesProduct $prop
 * @property \app\models\PvProductImage[] $pvProductImages
 * @property \app\models\FileUpload[] $images
 * @property \app\models\PvProductProperty[] $pvProductProperties
 * @property \app\models\Property[] $properties
 * @property \app\models\PvProductRequisite[] $pvProductRequisites
 * @property \app\models\Requisite[] $requisites
 */
class Product extends ActiveRecord
{

    public $new_price;

    public $main;

    public $photos;

    public function saveGoodsPhoto(){
        if($this->photos[0]){

            $imagesPaths = explode(',',$this->photos[0]);

            foreach ($imagesPaths as $path){
                $photo = new MainImage();
                $photo->product_id = $this->id;
                if($this->main == $path){
                    $photo->is_main = true;
                }
                else{
                    $photo->is_main = false;
                }
                $photo->url = $path;

                $photo->save();
            }
        }
        else{
            if($this->main){
                $image = MainImage::find()->where(['product_id'=>$this->id,'is_main'=>true])->one();
                if($image){
                    $image->is_main = false;
                    $image->save();
                }
                $image = MainImage::find()->where(['product_id'=>$this->id,'url'=>$this->main])->one();
                if($image){
                    $image->is_main = true;
                    $image->save();
                }
            }
            else{
                $image = MainImage::find()->where(['product_id'=>$this->id,'is_main'=>true])->one();
                if($image){
                    $image->is_main = false;
                    $image->save();
                }
            }

        }

    }

	protected $_relationClasses = [
		'catalog_id' => 'app\models\Catalog',
		'group_id' => 'app\models\Group',
	];


	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%product}}';
	}


	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
		            [['group_id', 'catalog_id'], 'integer'],
		            [['is_active'], 'boolean'],
		            [['new_price'], 'string'],
		            [['main'], 'string'],
                    [['photos'], 'safe'],
		            [['name'], 'required'],
		            [['name', 'article', 'description', 'accounting_id'], 'string', 'max' => 255],
		            [['accounting_id'], 'unique'],
		            [['catalog_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Catalog::className(), 'targetAttribute' => ['catalog_id' => 'id']],
		            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Group::className(), 'targetAttribute' => ['group_id' => 'id']],
		        ];
	}


	/**
	 * @inheritdoc
	 * @return \app\models\Product|\yii\db\ActiveRecord
	 */
	public static function findOne($condition, $raise = false)
	{
		$model = parent::findOne($condition);
		if (!$model && $raise){
		    throw new \yii\web\HttpException(404, Yii::t('errors', "Model app\\models\\Product not found"));
		}else{
		    return $model;
		}
	}

	public function saveNewPrice($new){

	    if($new){
            $price = new Price();
            $pos      = strripos(".00", $this->new_price);
            if($pos){
                $this->new_price = substr("$this->new_price", 0, -3);
            }
            $price->performance = $this->new_price.'.00 руб. за шт';
            $price->value = $this->new_price;
            $price->currency = 'руб';
            $price->type_id = 1;
            $price->rate = 1;
            $price->save();

            $id_price = $price->id;
            $id_offer = $this->offer->id;
            $pv_offer_pricer = new PvOfferPrice();
            $pv_offer_pricer->price_id = $id_price;
            $pv_offer_pricer->offer_id = $id_offer;
            $pv_offer_pricer->save();
        }
        else{
            $value = min($this->offer->prices[0]->value,$this->offer->prices[1]->value);
            if(!$this->new_price){
                $price = Price::findOne(['value'=>$value]);
                $pv_offer_price = PvOfferPrice::findOne(['price_id'=>$price->id]);
                $pv_offer_price->delete();
                $price->delete();
            }
            else{
                $price = Price::findOne(['value'=>$value]);
                $price->value = $this->new_price;
                $price->performance = $this->new_price.' руб. за шт';
                $price->save();
            }

        }


    }


	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
		    'id' => Yii::t('models', 'ID'),
		    'name' => Yii::t('models', 'Name'),
		    'article' => Yii::t('models', 'Article'),
		    'description' => Yii::t('models', 'Description'),
		    'accounting_id' => Yii::t('models', 'Accounting ID'),
		    'group_id' => Yii::t('models', 'Group ID'),
		    'catalog_id' => Yii::t('models', 'Catalog ID'),
		    'is_active' => Yii::t('models', 'Is Active'),
		    'created_at' => Yii::t('models', 'Created At'),
		    'updated_at' => Yii::t('models', 'Updated At')
		];
	}


	/**
	 * @inheritdoc
	 * @return \app\models\query\ProductQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new \app\models\query\ProductQuery(get_called_class());
	}


	/**
	 * @return \app\models\query\OfferQuery|\yii\db\ActiveQuery
	 */
	public function getOffer()
	{
		return $this->hasOne(\app\models\Offer::className(), ['product_id' => 'id']);
	}


	/**
	 * @return \app\models\query\CatalogQuery|\yii\db\ActiveQuery
	 */
	public function getCatalog()
	{
		return $this->hasOne(\app\models\Catalog::className(), ['id' => 'catalog_id']);
	}


    public function getProductImages()
    {
        return $this->hasMany(\app\models\MainImage::className(), ['product_id'=>'id']);
    }


    public function getMainImage()
    {
        return $this->hasOne(\app\models\MainImage::className(), ['product_id'=>'id','is_main'=>true]);
    }



	/**
	 * @return \app\models\query\GroupQuery|\yii\db\ActiveQuery
	 */
	public function getGroup()
	{
		return $this->hasOne(\app\models\Group::className(), ['id' => 'group_id']);
	}


	/**
	 * @return \app\models\query\PvProductImageQuery|\yii\db\ActiveQuery
	 */
	public function getPvProductImages()
	{
		return $this->hasMany(\app\models\PvProductImage::className(), ['product_id' => 'id']);
	}


	/**
	 * @return \app\models\query\FileUploadQuery|\yii\db\ActiveQuery
	 */
	public function getImages()
	{
		return $this->hasMany(\app\models\FileUpload::className(), ['id' => 'image_id'])->viaTable('pv_product_images', ['product_id' => 'id']);
	}


	/**
	 * @return \app\models\query\PvProductPropertyQuery|\yii\db\ActiveQuery
	 */
	public function getPvProductProperties()
	{
		return $this->hasMany(\app\models\PvProductProperty::className(), ['product_id' => 'id']);
	}


	/**
	 * @return \app\models\query\PropertyQuery|\yii\db\ActiveQuery
	 */
	public function getProperties()
	{
		return $this->hasMany(\app\models\Property::className(), ['id' => 'property_id'])->viaTable('pv_product_properties', ['product_id' => 'id']);
	}


	/**
	 * @return \app\models\query\PvProductRequisiteQuery|\yii\db\ActiveQuery
	 */
	public function getPvProductRequisites()
	{
		return $this->hasMany(\app\models\PvProductRequisite::className(), ['product_id' => 'id']);
	}


	public function getProp(){
	    return $this->hasOne(PropertiesProduct::className(),['product_id' => 'id']);
    }


	/**
	 * @return \app\models\query\RequisiteQuery|\yii\db\ActiveQuery
	 */
	public function getRequisites()
	{
		return $this->hasMany(\app\models\Requisite::className(), ['id' => 'requisite_id'])->viaTable('pv_product_requisite', ['product_id' => 'id']);
	}


	/**
	 * @param string $attribute
	 * @return string|null
	 */
	public function getRelationClass($attribute)
	{
		return ArrayHelper::getValue($this->_relationClasses, $attribute);
	}
}
