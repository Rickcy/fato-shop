<?php
/**
 * Created by PhpStorm.
 * User: marvel
 * Date: 06.12.17
 * Time: 17:36
 */

namespace app\assets;


use yii\web\AssetBundle;

class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/admin.css',
        'css/font-awesome.min.css',
        'https://fonts.googleapis.com/css?family=Roboto+Slab',
    ];
    public $js = [
        'js/admin.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}