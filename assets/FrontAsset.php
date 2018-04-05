<?php
/**
 * Created by PhpStorm.
 * User: marvel
 * Date: 01.12.17
 * Time: 17:46
 */

namespace app\assets;


use yii\web\AssetBundle;

class FrontAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/front.css',
        'css/font-awesome.min.css',
        'https://fonts.googleapis.com/css?family=Roboto+Slab',
    ];
    public $js = [
        'js/front.js'
    ];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}