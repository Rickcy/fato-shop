<?php

namespace app\modules\integration;
use app\models\DefaultLog;
use app\models\User;
use app\modules\integration\interfaces\DocumentInterface;
use app\modules\integration\interfaces\GroupInterface;
use app\modules\integration\interfaces\OfferInterface;
use app\modules\integration\interfaces\PartnerInterface;
use app\modules\integration\interfaces\ProductInterface;
use app\modules\integration\interfaces\WarehouseInterface;
use yii\base\Module;
use yii\helpers\FileHelper;

/**
 * integration module definition class
 */
class IntegrationModule extends Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\integration\controllers';



    /**
     * @var ProductInterface
     */
    public $productClass;
    /**
     * @var OfferInterface
     */
    public $offerClass;
    /**
     * @var DocumentInterface
     */
    public $documentClass;
    /**
     * @var GroupInterface
     */
    public $groupClass;
    /**
     * @var PartnerInterface
     */
    public $partnerClass;
    /**
     * @var WarehouseInterface
     */
    public $warehouseClass;



    /**
     * Обмен документами
     *
     * @var bool
     */
    public $exchangeDocuments = false;
    /**
     * Режим отладки - сохраняем xml файлы в runtime
     *
     * @var bool
     */
    public $debug = true;
    /**
     * При обмене используем архиватор, если расширения нет, то зачение не учитывается
     *
     * @var bool
     */
    public $useZip = true;
    public $tmpDir = '@runtime/1c_exchange';
    /**
     * При сохранении товара, используем валидацию или нет
     *
     * @var bool
     */
    public $validateModelOnSave = false;
    public $timeLimit = 1800;
    public $bootstrapUrlRule = true;
    public $auth;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }


    /**
     * @param null $part
     * @return string
     */
    public function getTmpDir($part = null)
    {
        $dir = \Yii::getAlias($this->tmpDir);
        if (!is_dir($dir)) {
            FileHelper::createDirectory($dir, 0777, true);
        }
        return $dir . ($part ? DIRECTORY_SEPARATOR . trim($part, '/\\') : '');
    }

    public function auth($login, $password)
    {

        $user = User::findByUsername($login);
        if ($user && $user->validatePassword($password)) {
            return $user;
        } else {
            return null;
        }
    }
}
