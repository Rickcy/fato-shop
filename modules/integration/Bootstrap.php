<?php
/**
 * Created by PhpStorm.
 * User: marvel
 * Date: 11.12.17
 * Time: 23:38
 */

namespace app\modules\integration;


use app\helpers\ModuleHelper;
use app\modules\integration\UrlRule;
use yii\base\Application;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        if ($id = ModuleHelper::getModuleNameByClass()) {
            if (\Yii::$app->getModule($id)->bootstrapUrlRule) {
                \Yii::$app->urlManager->addRules([new UrlRule]);
            }
        }
    }
}