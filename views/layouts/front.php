<?php
/**
 * Created by PhpStorm.
 * User: marvel
 * Date: 01.12.17
 * Time: 17:21
 */

use app\assets\FrontAsset;
use app\models\Category;
use app\models\Pages;
use yii\bootstrap\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

FrontAsset::register($this);
$categories = \app\models\Group::find()->all();
$pages = Pages::find()->all();
$main = Pages::findOne(['name'=>'Главная','slug'=>'/']);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
<?php $this->beginBody() ?>

<nav  class="navbar-default navbar-static-top navbar">
    <div class="container">
        <div class="navbar-header">

        </div>
        <div >
            <ul  class="navbar-nav navbar-left nav" style="width: 100%;">
                <?php foreach ($categories as $cat):?>
                 <?php if ($cat->level_menu == 1 || $cat->level_menu == 3):?>
                <li class="hidden-xs menu-link">
                    <a href="/kategorii/<?=$cat->slug?>"><?=$cat->name?></a>
                </li>
                    <?php endif;?>
                <?php endforeach;?>
                <?php foreach ($pages as $page):?>
                    <?php if ($page->level_menu == 1 || $page->level_menu == 3):?>

                <li class="menu-link">
                    <a href="/<?=$page->slug?>"><?=$page->name?></a>
                </li>
                 <?php endif;?>
                <?php endforeach;?>
                <?php if(!Yii::$app->user->isGuest):?>
                    <li class="menu-link">
                        <a href="/admin/index">Личный Кабинет</a>
                    </li>


                <?php endif;?>
                <li class="menu-social-link">
                    <a href="#" >
                        <span class="fa-stack fa-lg">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-odnoklassniki fa-stack-1x fa-inverse"></i>
                        </span>
                    </a>
                </li>
                <li class="menu-social-link">
                    <a href="#" >
                        <span class="fa-stack fa-lg">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-vk fa-stack-1x fa-inverse"></i>
                        </span>
                    </a>
                </li>

            </ul>
            <ul  class="navbar-nav navbar-right nav">

            </ul>
        </div>
    </div>
</nav>


<?php if($main):?>
    <?php if(!$main->content):?>

        <nav  class="nav navbar" style="background-color: white!important">
            <div class="container">
                <div class="col-sm-3 col-xs-6" style="margin-bottom: 2rem"><a href="/"><img class="logo" src="/images/logo.png" alt="Логотип"></a></div>
                <div class="visible-xs col-xs-6">
                <div id="catalog-block" class="visible-xs" style="width: 87%;min-width: 175px!important;margin-top: 0.7rem">
                    <li class="dropdown  visible-xs">
                        <a id="drop1" href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: white;background-color: transparent">
                            <i class="fa fa-align-justify" aria-hidden="true" style="margin-right: 1rem;margin-left: 1rem"></i>Каталог
                        </a>
                        <ul class="dropdown-menu menu-cat" style="width: 113.9%!important;">
                            <?php foreach ($categories as $category):?>
                                <?php if ($category->is_active):?>
                                <li><a href="/kategorii/<?=$category->slug?>"><?=$category->name?></a></li>
                                 <?php endif;?>
                            <?php endforeach;?>

                        </ul>
                    </li>
                </div>
                </div>
                <div class="col-sm-3 col-xs-12">
                    <div class="row">
                        <div class="col-sm-5 col-xs-4 col-xs-offset-1 col-sm-offset-0"><img src="/images/icon-tel.png" alt="телефон"></div>
                        <div class="col-sm-7 col-xs-7 name-col">+7 (3852) <b>35-99-98 </b>единая справочная</div>
                    </div>
                </div>
                <div class="col-sm-3 col-xs-12">
                    <div class="row">
                        <div class="col-sm-5 col-xs-4 col-xs-offset-1 col-sm-offset-0"><img src="/images/icon-house.png" alt="адрес"></div>
                        <div class="col-sm-7 col-xs-7 name-col"><a href="/kontakty" class="col_under">Адреса магазинов</a></div>
                    </div>
                </div>
                <div class="col-sm-3 col-xs-12">
                    <div class="row">
                        <div class="col-sm-5 col-xs-4 col-xs-offset-1 col-sm-offset-0"><img src="/images/icon-basket.png" alt="корзина"></div>
                        <div class="col-sm-7 col-xs-7 name-col"><a class="col_under" href="#"><b>Корзина</b></a></div>
                    </div>
                </div>
            </div>
        </nav>
    <?php else:;?>
        <?=$main->content?>
    <?php endif;?>
<?php else:;?>

    <nav  class="nav navbar" style="background-color: white!important">
        <div class="container">
            <div class="col-sm-3"><a href="/"><img  class="logo" src="/images/logo.png" alt="Логотип"></a></div>
            <div class="col-sm-3">
                <div class="row">
                    <div class="col-sm-4"><img src="/images/icon-tel.png" alt="телефон"></div>
                    <div class="col-sm-8 name-col">+7 (3852) <b>35-99-98 </b><br>единая справочная</div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="row">
                    <div class="col-sm-4"><img src="/images/icon-house.png" alt="адрес"></div>
                    <div class="col-sm-8 name-col"><a href="/kontakty" class="col_under">Адреса <br> магазинов</a></div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="row">
                    <div class="col-sm-4"><img src="/images/icon-basket.png" alt="корзина"></div>
                    <div class="col-sm-8 name-col"><a class="col_under" href="#"><b>Корзина</b></a></div>
                </div>
            </div>
        </div>
    </nav>
<?php endif;?>

<nav class="nav navbar-static-top navbar navbar-block" style="margin-bottom: 0!important;box-shadow: grey 0px 1px 7px 0px;">
    <div class="container">
    <div id="catalog-block" class="hidden-xs">
        <li class="dropdown  hidden-xs">
            <a id="drop1" href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: white;background-color: transparent">
                <i class="fa fa-align-justify" aria-hidden="true" style="margin-right: 1rem;margin-left: 1rem"></i>Каталог
            </a>
            <ul class="dropdown-menu menu-cat">
                <?php foreach ($categories as $category):?>
                    <?php if ($category->is_active):?>
                    <li><a href="/kategorii/<?=$category->slug?>"><?=$category->name?></a></li>
                    <?php endif;?>
                <?php endforeach;?>

            </ul>
        </li>
    </div>
        <div class="wrap-search-block">
            <input id="search-block" type="text" placeholder="Поиск">
            <button class="icon-search-btn" style="background-color: transparent;border: transparent"><img src="/images/icon-search.png" alt="поиск"></button>
        </div>
    </div>

</nav>



    <?= $content ?>
<div class="container" style="padding-right: 1.5rem">

    <?php if($main):?>
    <?php if(!$main->baners):?>
            <div class="col-sm-6 text-center">
                <img src="/images/baner-1.png" width="99%" alt="банер-1">
            </div>
            <div class="col-sm-6 text-center">
                <img src="/images/baner-2.png" width="99%" alt="банер-2">
            </div>
        <?php else:;?>
            <?=$main->baners?>
        <?php endif;?>
    <?php else:;?>
        <div class="col-sm-6 text-center">
            <img src="/images/baner-1.png" width="99%" alt="банер-1">
        </div>
        <div class="col-sm-6 text-center">
            <img src="/images/baner-2.png" width="99%" alt="банер-2">
        </div>
    <?php endif;?>


</div>

<footer class="footer" >
    <div class="container" style="padding: 0 3rem;">
        <div class="wrap-in-footer">
            <div class="row">
                <div class="col-sm-2">
                    <img src="/images/logo-2.png" style="float: left" alt="логотип-2">
                </div>
                <div class="col-sm-8">

                    <ul class="footer-list" >
                        <?php
                        $categories = Category::find()->limit(2)->all();
                        foreach ($categories as $cat):?>
                            <?php if ($cat->level_menu == 2 ||$cat->level_menu == 3 ):?>
                                <li >
                                    <a class="col_under"  href="/kategorii/<?=$cat->slug?>"><?=$cat->name?></a>
                                </li>
                            <?php endif;?>
                        <?php endforeach;?>
                        <?php
                        $pages = Pages::find()->limit(2)->all();
                        foreach ($pages as $page):?>
                            <?php if ($page->level_menu == 2 || $page->level_menu == 3):?>
                                <li>
                                    <a class="col_under"  href="/<?=$page->slug?>"><?=$page->name?></a>
                                </li>
                            <?php endif;?>
                        <?php endforeach;?>
                    </ul>
                    <ul class="footer-list" >
                        <?php
                        $categories = Category::find()->limit(2)->offset(2)->all();
                        foreach ($categories as $cat):?>
                            <?php if ($cat->level_menu == 2 ||$cat->level_menu == 3 ):?>
                                <li >
                                    <a class="col_under"  href="/kategorii/<?=$cat->slug?>"><?=$cat->name?></a>
                                </li>
                            <?php endif;?>
                        <?php endforeach;?>
                        <?php
                        $pages = Pages::find()->limit(2)->offset(2)->all();
                        foreach ($pages as $page):?>
                            <?php if ($page->level_menu == 2 || $page->level_menu == 3):?>
                                <li>
                                    <a class="col_under"  href="/<?=$page->slug?>"><?=$page->name?></a>
                                </li>
                            <?php endif;?>
                        <?php endforeach;?>
                    </ul>
                    <ul class="footer-list" >
                        <?php
                        $categories = Category::find()->limit(2)->offset(4)->all();
                        foreach ($categories as $cat):?>
                            <?php if ($cat->level_menu == 2 ||$cat->level_menu == 3 ):?>
                                <li >
                                    <a class="col_under"  href="/kategorii/<?=$cat->slug?>"><?=$cat->name?></a>
                                </li>
                            <?php endif;?>
                        <?php endforeach;?>
                        <?php
                        $pages = Pages::find()->limit(2)->offset(4)->all();
                        foreach ($pages as $page):?>
                            <?php if ($page->level_menu == 2 || $page->level_menu == 3):?>
                                <li>
                                    <a class="col_under"  href="/<?=$page->slug?>"><?=$page->name?></a>
                                </li>
                            <?php endif;?>
                        <?php endforeach;?>
                    </ul>
                    <ul class="footer-list" >
                        <?php
                        $categories = Category::find()->limit(2)->offset(6)->all();
                        foreach ($categories as $cat):?>
                            <?php if ($cat->level_menu == 2 ||$cat->level_menu == 3 ):?>
                                <li >
                                    <a class="col_under"  href="/kategorii/<?=$cat->slug?>"><?=$cat->name?></a>
                                </li>
                            <?php endif;?>
                        <?php endforeach;?>
                        <?php
                        $pages = Pages::find()->limit(2)->offset(6)->all();
                        foreach ($pages as $page):?>
                            <?php if ($page->level_menu == 2 || $page->level_menu == 3):?>
                                <li>
                                    <a class="col_under"  href="/<?=$page->slug?>"><?=$page->name?></a>
                                </li>
                            <?php endif;?>
                        <?php endforeach;?>
                    </ul>
                </div>
                <div class="col-sm-2">
                    <img src="/images/creators.png" style="float: right" alt="создатели">
                </div>
            </div>



        </div>
    </div>
</footer>

<?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
