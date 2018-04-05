<?php
/**
 * Created by PhpStorm.
 * User: marvel
 * Date: 06.12.17
 * Time: 16:38
 */

namespace app\assets;


use yii\web\AssetBundle;

class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/login.css',
    ];
    public $js = [
        'js/login.js',
    ];
}