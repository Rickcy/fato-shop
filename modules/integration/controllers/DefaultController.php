<?php

namespace app\modules\integration\controllers;

use app\behaviors\BomBehavior;
use app\helpers\ByteHelper;
use app\models\DefaultLog;
use app\models\Group;
use app\modules\integration\IntegrationModule;
use app\modules\integration\interfaces\DocumentInterface;
use app\modules\integration\interfaces\GroupInterface;
use app\modules\integration\interfaces\OfferInterface;
use app\modules\integration\interfaces\ProductInterface;
use Yii;
use yii\db\ActiveRecord;

use yii\filters\auth\HttpBasicAuth;
use yii\filters\Cors;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;
use yii\web\Controller;
use Zenwalker\CommerceML\CommerceML;
use Zenwalker\CommerceML\Model\Offer;
use Zenwalker\CommerceML\Model\Product;

/**
 * * @property IntegrationModule module
 * Default controller for the `integration` module
 */
class DefaultController extends Controller
{
    public $enableCsrfValidation = false;
    private $_ids;

    public function behaviors()
    {
        $behaviors = [];


        if (\Yii::$app->user->isGuest) {
            if ($this->module->auth) {
                $auth = $this->module->auth;
            } else {
                $auth = [$this->module, 'auth'];
            }

            $behaviors = [
                'authenticator' => [
                    'class' => HttpBasicAuth::className(),
                    'auth' => $auth
                ],
                'bom' => [
                    'class' => BomBehavior::className(),
                    'only' => ['query'],
                ],
                'corsFilter' => [
                    'class' => Cors::className(),
                    'cors' => [],
                    'actions' => [
                        'index' => [
                            'Origin' => ['*'],
                            'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                            'Access-Control-Request-Headers' => ['*'],
                            'Access-Control-Allow-Credentials' => true,
                            'Access-Control-Max-Age' => 86400,
                            'Access-Control-Expose-Headers' => ['*'],
                        ],
                        'init' => [
                            'Origin' => ['*'],
                            'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                            'Access-Control-Request-Headers' => ['*'],
                            'Access-Control-Allow-Credentials' => true,
                            'Access-Control-Max-Age' => 86400,
                            'Access-Control-Expose-Headers' => ['*'],
                        ],
                        'file' => [
                            'Origin' => ['*'],
                            'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                            'Access-Control-Request-Headers' => ['*'],
                            'Access-Control-Allow-Credentials' => true,
                            'Access-Control-Max-Age' => 86400,
                            'Access-Control-Expose-Headers' => ['*'],
                        ],
                        'import' => [
                            'Origin' => ['*'],
                            'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                            'Access-Control-Request-Headers' => ['*'],
                            'Access-Control-Allow-Credentials' => true,
                            'Access-Control-Max-Age' => 86400,
                            'Access-Control-Expose-Headers' => ['*'],
                        ],
                        'checkauth' => [
                            'Origin' => ['*'],
                            'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                            'Access-Control-Request-Headers' => ['*'],
                            'Access-Control-Allow-Credentials' => true,
                            'Access-Control-Max-Age' => 86400,
                            'Access-Control-Expose-Headers' => ['*'],
                        ],
                        'success' => [
                            'Origin' => ['*'],
                            'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                            'Access-Control-Request-Headers' => ['*'],
                            'Access-Control-Allow-Credentials' => true,
                            'Access-Control-Max-Age' => 86400,
                            'Access-Control-Expose-Headers' => ['*'],
                        ],
                    ],
                ],
            ];
        }
        return $behaviors;
    }

    public function beforeAction($action) {
        Yii::$app->response->cookies->remove("_csrf");
        Yii::$app->response->cookies->remove("_identity");


        return parent::beforeAction($action);
    }




    /**
     * @param \yii\base\Action $action
     * @param mixed $result
     * @return mixed|string
     */
    public function afterAction($action, $result)
    {
        Yii::$app->response->cookies->remove("_csrf");
        Yii::$app->response->cookies->remove("_identity");
        Yii::$app->response->headers->set('uid', Yii::$app->user->getId());
        parent::afterAction($action, $result);
        if (is_bool($result)) {
            return $result ? "success" : "failure";
        } elseif (is_array($result)) {
            $r = [];
            foreach ($result as $key => $value) {
                $r[] = is_int($key) ? $value : $key . '=' . $value;
            }
            return join("\n", $r);
        } else {
            return parent::afterAction($action, $result);
        }
    }



    public function actionIndex(){

        $log = new DefaultLog();
        $log->name = 'checkauth-index';
        $log->crtime = date('Y-m-d H:i:s');
        $log->save();

        $this->module->getTmpDir();

        if (Yii::$app->user->isGuest) {
            return false;
        } else {
            return [
                "success\n",
                "PHPSESSID\n",
                Yii::$app->session->getId(),
            ];
        }
    }


    /**
     * @return float|int
     */
    protected function getFileLimit()
    {
        $limit = ByteHelper::maximum_upload_size();
        if (!($limit % 2)) {
            $limit--;
        }
        return $limit;
    }



    public function actionInit()
    {
        $log = new DefaultLog();
        $log->name = 'init - '.class_exists('ZipArchive') && $this->module->useZip ? 'yes ' : 'no '.' file-limit  - '.$this->getFileLimit();
        $log->crtime = date('Y-m-d H:i:s');
        $log->save();

        return [
            "zip" => class_exists('ZipArchive') && $this->module->useZip ? "yes" : "no",
            "file_limit" => $this->getFileLimit(),
        ];
    }



    public function init()
    {
        set_time_limit($this->module->timeLimit);
        parent::init();
    }



    public function actionFile($type, $filename)
    {
        $log = new DefaultLog();
        $log->name = 'file - '.$filename;
        $log->crtime = date('Y-m-d H:i:s');
        $log->save();

        $body = Yii::$app->request->getRawBody();
        $filePath = $this->module->getTmpDir() . DIRECTORY_SEPARATOR . $filename;
        if (!self::getData('archive') && pathinfo($filePath, PATHINFO_EXTENSION) == 'zip') {
            self::setData('archive', $filePath);
        }
        file_put_contents($filePath, $body, FILE_APPEND);
        return true;
    }






    /**
     * @param $type
     * @param $filename
     * @return bool
     */
    public function actionImport($type, $filename)
    {



        $log = new DefaultLog();
        $log->name = 'import - type : '.$type.' filename - '.$filename;
        $log->crtime = date('Y-m-d H:i:s');
        $log->save();

        if (($archive = self::getData('archive')) && file_exists($archive)) {

            $log = new DefaultLog();
            $log->name = 'archive exist';
            $log->crtime = date('Y-m-d H:i:s');
            $log->save();

            $zip = new \ZipArchive();
            $zip->open($archive);

            $log = new DefaultLog();
            $log->name = 'archive open';
            $log->crtime = date('Y-m-d H:i:s');
            $log->save();

            $zip->extractTo(dirname($archive));

            $log = new DefaultLog();
            $log->name = 'archive extract';
            $log->crtime = date('Y-m-d H:i:s');
            $log->save();

            $zip->close();
            @unlink($archive);
        }

        $file = $this->module->getTmpDir() . DIRECTORY_SEPARATOR . $filename;

        if ($type == 'catalog') {
            if (strpos($file, 'offer') !== false) {
                $this->parsingOffer($file);
            } elseif (strpos($file, 'import') !== false) {
                $this->parsingImport($file);
            }
        } elseif ($type == 'sale' && strpos($file, 'order') !== false) {
            $this->parsingOrder($file);
        }
        if (!$this->module->debug) {
            $this->clearTmp();
        }
        return true;
    }




    /**
     * @param $type
     * @return array|bool
     */
    public function actionCheckauth($type)
    {

        $log = new DefaultLog();
        $log->name = 'checkauth';
        $log->crtime = date('Y-m-d H:i:s');
        $log->save();

        $this->module->getTmpDir();
        if (Yii::$app->user->isGuest) {
            return false;
        } else {
            return [
                "success\n",
                "PHPSESSID\n",
                Yii::$app->session->getId(),
            ];
        }

    }




    /**
     * @param $file
     */
    public function parsingOrder($file)
    {

        $log = new DefaultLog();
        $log->name = 'parsing order';
        $log->crtime = date('Y-m-d H:i:s');
        $log->save();


        /**
         * @var DocumentInterface $documentModel
         */
        $commerce = new CommerceML();
        $commerce->addXmls(false, false, $file);
        $documentClass = $this->module->documentClass;
        foreach ($commerce->order->documents as $document) {
            if ($documentModel = $documentClass::findOne((string)$document->Номер)) {
                $documentModel->setRaw1cData($commerce, $document);
            }
        }
    }


    /**
     * @param $file
     */
    public function parsingImport($file)
    {
        $log = new DefaultLog();
        $log->name = 'parsing import';
        $log->crtime = date('Y-m-d H:i:s');
        $log->save();

        $this->_ids = [];
        $commerce = new CommerceML();
        $commerce->loadImportXml($file);

        if ($groupClass = $this->getGroupClass()) {
            $groupClass::createTree1c($commerce->classifier->getGroups());
        }
        $productClass = $this->getProductClass();
        $productClass::createProperties1c($commerce->classifier->getProperties());
        foreach ($commerce->catalog->getProducts() as $product) {
            if (!$model = $productClass::createModel1c($product)) {
                Yii::error("Модель продукта не найдена, проверьте реализацию $productClass::createModel1c", 'exchange1c');
                continue;
            }
            $this->parseProduct($model, $product);
            $this->_ids[] = $model->getPrimaryKey();
            $model = null;
            unset($model);
            unset($product);
            gc_collect_cycles();
            $this->generationSlugGroup();
        }
    }


    /**
     * @return object|ActiveRecord
     */
    protected function createProductModel($data)
    {
        $class = $this->getProductClass();
        if ($model = $class::createModel1c($data)) {
            return $model;
        } else {
            return Yii::createObject(['class' => $class]);
        }
    }





    /**
     * @param ProductInterface $model
     * @param \Zenwalker\CommerceML\Model\Product $product
     */
    protected function parseProduct($model, $product)
    {
        $model->setRaw1cData($product->owner, $product);
        $this->parseGroups($model, $product);
        $this->parseProperties($model, $product);
        $this->parseRequisites($model, $product);
        $this->generationSlug($model);
        $this->parseImage($model, $product);
        $this->createProp($model);
        unset($group);
    }


    /**
     * @param string $id
     *
     * @return ProductInterface|null
     */
    protected function findProductModelById($id)
    {
        /**
         * @var $class ProductInterface
         */
        $class = $this->getProductClass();
        return $class::find()->andWhere([$class::getIdFieldName1c() => $id])->one();
    }

    /**
     * @param $file
     */
    public function parsingOffer($file)
    {

        $this->_ids = [];
        $commerce = new CommerceML();
        $commerce->loadOffersXml($file);
        if ($offerClass = $this->getOfferClass()) {
            $offerClass::createPriceTypes1c($commerce->offerPackage->getPriceTypes());
        }
        foreach ($commerce->offerPackage->getOffers() as $offer) {
                $product = $this->findProductModelById($offer->getClearId());
                if($product) {
                    $model = $product->getOffer1c($offer);
                    $this->parseProductOffer($model, $offer);
                    $this->_ids[] = $model->getPrimaryKey();
                    unset($model);
                }
        }
    }


    /**
     * @param OfferInterface $model
     * @param Offer $offer
     */
    protected function parseProductOffer($model, $offer)
    {
        $this->parseSpecifications($model, $offer);
        $this->parsePrice($model, $offer);
        $model->{$model::getIdFieldName1c()} = $offer->id;
        $model->save();
        unset($model);
    }



    protected function clearTmp()
    {
        FileHelper::removeDirectory($this->module->getTmpDir());
    }



    /**
     * @param $type
     * @return bool
     */
    public function actionSuccess($type)
    {
        return true;
    }

    /**
     * @param $name
     * @param $value
     */
    protected static function setData($name, $value)
    {
        Yii::$app->session->set($name, $value);
    }

    /**
     * @param $name
     * @param null $default
     * @return mixed
     */
    protected static function getData($name, $default = null)
    {
        return Yii::$app->session->get($name, $default);
    }

    /**
     * @return bool
     */
    protected static function clearData()
    {
        return Yii::$app->session->closeSession();
    }



    /**
     * @param OfferInterface $model
     * @param Offer $offer
     */
    protected function parsePrice($model, $offer)
    {
        foreach ($offer->getPrices() as $price) {
            $model->setPrice1c($price);
        }
    }

    /**
     * @param ProductInterface $model
     * @param Product $product
     * @return bool
     */
    protected function parseImage($model, $product)
    {

        $images = $product->getImages();
        if(count($images)>0 && $images->path) {
            foreach ($images as $image) {
                $path = realpath($this->module->getTmpDir() . DIRECTORY_SEPARATOR . $image->path);
                if (file_exists($path)) {
                    $model->addImage1c($path, $image->caption);
                }
            }
        }
    }


    /**
     * @param ProductInterface $model
     */
    protected function generationSlug($model){
        $model->generationSlug();
    }


    /**
     * @param ProductInterface $model
     */
    protected function createProp($model){
        $model->createProp();
    }

    /**
     * @param ProductInterface $model
     * @param Product $product
     */
    protected function parseGroups($model, $product)
    {
        $group = $product->getGroup();
        $model->setGroup1c($group);
    }

    /**
     * @param ProductInterface $model
     * @param Product $product
     */
    protected function parseRequisites($model, $product)
    {
        $requisites = $product->getRequisites();
        foreach ($requisites as $requisite) {
            $model->setRequisite1c($requisite->name, $requisite->value);
        }
    }

    /**
     * @param OfferInterface $model
     * @param Offer $offer
     */
    protected function parseSpecifications($model, $offer)
    {
        foreach ($offer->getSpecifications() as $specification) {
            $model->setSpecification1c($specification);
        }
    }

    /**
     * @param ProductInterface $model
     * @param Product $product
     */
    protected function parseProperties($model, $product)
    {
        $properties = $product->getProperties();
        if(count($properties) > 0){
            foreach ($properties as $property) {
                $model->setProperty1c($property);
            }
        }

    }

    /**
     * @return OfferInterface
     */
    protected function getOfferClass()
    {
        return $this->module->offerClass;
    }

    /**
     * @return ProductInterface
     */
    protected function getProductClass()
    {
        return $this->module->productClass;
    }

    /**
     * @return DocumentInterface
     */
    protected function getDocumentClass()
    {
        return $this->module->documentClass;
    }

    /**
     * @return GroupInterface
     */
    protected function getGroupClass()
    {
        return $this->module->groupClass;
    }

    private function generationSlugGroup()
    {
        /**
         * @var $group \app\models\Group
         */
        $groups = Group::find()->all();
        foreach ($groups as $group){
            if($group->name){
                $group->slug = Inflector::slug($group->name, '-');
                $group->save();
            }
        }


    }

}
