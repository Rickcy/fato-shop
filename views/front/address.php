<?php
/**
 * Created by PhpStorm.
 * User: marvel
 * Date: 01.12.17
 * Time: 17:35
 */

use app\assets\YandexMaps;

/* @var $this \yii\web\View */
$this->title = 'Адреса магазинов';
$this->registerJsFile('https://api-maps.yandex.ru/2.1/?lang=ru_RU');
YandexMaps::register($this)
?>
<div class="container container-main">


    <div id="map" style="width: 100%;height: 500px"></div>
    <div class="row">
        <div class="col-sm-3">
            <div class="list-main">Барнаул</div>
            <div class="list-style">
            <ul >
                <li>Космонавтов проспект, 8/2</li>
                <li>Космонавтов проспект, 6в</li>
                <li>Антона Петрова, 196</li>
                <li>Попова, 70</li>
                <li>Северо-Западная, 6</li>
                <li>Космонавтов проспект, 6г</li>
                <li>Пионеров, 13а</li>
                <li>Ленина проспект, 2Б</li>
                <li>Мало-Олонская, 28</li>
            </ul>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="list-main">Новоалтайск</div>
            <div class="list-style">
            <ul >
                <li>Октябрьская, 14/1</li>
                <li>Гагарина, 24</li>
                <li>7-й микрорайон, 2</li>

            </ul>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="list-main">Бийск</div>
            <div class="list-style">
            <ul >
                <li>Александра Матросова, 30 к2</li>
                <li>Петра Мерлина, 27</li>
                <li>3 Интернационала переулок, 10а</li>
                <li>Советская, 7/2</li>
            </ul>
            </div>
        </div>
    </div>
</div>
