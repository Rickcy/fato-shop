<?php
/**
 *
 * Created by PhpStorm.
 * User: marvel
 * Date: 01.12.17
 * Time: 17:21
 */

use app\models\Pages;

/* @var $this yii\web\View */
$main = Pages::findOne(['name'=>'Главная','slug'=>'/']);
if(isset($main) && $main->title ){
    $this->title = $main->title;
    $this->registerMetaTag(['name' => 'description', 'content' => $main->description]);
    $this->registerMetaTag(['name' => 'keywords', 'content' => $main->keywords]);
}
$this->title = 'Мебель Фато';

?>
<div class="slider-block">
    <div class="container container-main" >

        <?php if($main):?>
            <?php if(!$main->content_2):?>
                <img src="/images/crouch-min.png" width="100%" alt="скидки">
            <?php else:;?>
                <?=$main->content_2?>
            <?php endif;?>
        <?php else:;?>
            <img src="/images/crouch-min.png" width="100%" alt="скидки">
        <?php endif;?>
    </div>
</div>
    <div class="container" style="padding: 0 3rem;">
        <h3 class="text-center main-name-div" ><b>МЕБЕЛЬ ОТ ПРОИЗВОДИТЕЛЯ</b></h3>
        <div class="row" style="padding: 2rem">
            <div class="col-sm-3 col-xs-6 text-center">
                <img src="/images/icon-class.png" alt="качество">
                <div class="text-col-desc">
                    Высокое качество, <br>
                    отработанное годами
                </div>
            </div>

            <div class="col-sm-3 col-xs-6 text-center">
                <img src="/images/icon-good.png" alt="богатый выбор">
                <div class="text-col-desc">
                    Богатый выбор <br>
                    моделей и расцветок
                </div>
            </div>
            <div class="col-sm-3 col-xs-6 text-center">
                <img src="/images/icon-travel.png" alt="бесплатная доставка">
                <div class="text-col-desc">
                    Бесплатная <br>
                    доставка
                </div>
            </div>
            <div class="col-sm-3 col-xs-6 text-center">
                <img src="/images/18.png" alt="гарантия">
                <div class="text-col-desc">
                    Гарантия <br>
                    18 месяцев
                </div>
            </div>
        </div>


        <div class="row hidden-xs hidden-sm" style="position: relative;bottom: 17rem">
            <div  style=" margin-left: 25%;float: left"><img src="/images/circle.png" alt=""></div>
            <div style="margin-left: 47%;float: left"><img src="/images/circle.png" alt=""></div>
        </div>

        <h3 class="text-center main-name-div" ><b style="color: #ff4800">ТЕПЕРЬ ЦЕНА НИЖЕ</b></h3>
        <div class="row" style="margin-top: 2rem">

            <?php foreach ($goods as $good):?>
                <?php if(count($good->offer->prices) > 1):?>
                <div class="col-sm-3 text-center">
                    <div class="wrap-block-good">
                        <div class="group-name">
                            <?=$good->group->name?>
                        </div>

                        <a class="head-name" href="/tovar/<?=$good->group->slug?>/<?=$good->slug?>"><?=$good->name?></a>

                        <div class="img-good">
                            <img src="/images/good-1.png"  alt="">
                        </div>
                        <div class="color-good">
                            <a class="col_under" href="#">другие расцветки</a>
                        </div>
                        <div class="row" style="">
                            <div class="col-xs-4"><div class="circle-block fa fa-shopping-basket fa-inverse"></div></div>
                            <div class="col-xs-4 text-center">
                                                            <div class="old-price"><?=max($good->offer->prices[0]->value,$good->offer->prices[1]->value)?> ₽</div>
                            </div>

                            <div class="col-xs-4 text-left" style="padding-left: 0"><div class="new-price"><?=min($good->offer->prices[0]->value,$good->offer->prices[1]->value)?> ₽</div></div>
                        </div>
                    </div>
                </div>



            <?php endif;?>
            <?php endforeach;?>

        </div>











            <div style="border-top:2px solid #f3f3f3;margin: 2rem 0"></div>
    </div>
