<?php
/**
 * Created by PhpStorm.
 * User: marvel
 * Date: 05.12.17
 * Time: 14:55
 */

namespace app\assets;


use yii\web\AssetBundle;

class YandexMaps extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/yandex-maps.js'
    ];

}