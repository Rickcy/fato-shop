<?php
/* @var $this \yii\web\View */

use app\assets\YandexMaps;

/**
 *
 * Created by PhpStorm.
 * User: marvel
 * Date: 07.12.17
 * Time: 15:36
 */
$this->title = $page->title;
$this->registerJsFile('https://api-maps.yandex.ru/2.1/?lang=ru_RU');
YandexMaps::register($this);
$this->registerMetaTag(['name' => 'description', 'content' => $page->description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $page->keywords]);
?>
<div class="container container-main">
    <?=$page->content?>
</div>
