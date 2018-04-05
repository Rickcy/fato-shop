<?php
/**
 * Created by PhpStorm.
 * User: marvel
 * Date: 08.12.17
 * Time: 14:17
 */

namespace app\assets;


use yii\web\AssetBundle;

class MenuAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [];
    public $js = [
        'js/menu.js'
    ];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}