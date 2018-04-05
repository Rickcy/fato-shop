<?php
/**
 * Created by PhpStorm.
 * User: marvel
 * Date: 07.12.17
 * Time: 18:36
 */

use yii\bootstrap\Html;
app\assets\MenuAsset::register($this);
if($id == 1){
    $this->title = 'Верхнее меню';
}
else{
    $this->title = 'Нижнее меню';
}

?>
<div class="container">
    <?= Html::a(Yii::t('app', 'Вернуться'), ['edit-main-page'],['class' =>  'btn create-btn btn-md btn-default']) ?>
<?php if ($id == 1):?>
    <h4>Верхнее меню</h4>
    <hr>
<?php else:;?>
    <h4>Нижнее меню</h4>
    <hr>
<?php endif;?>
    <div class="btn-group" id="menu">
        <?php foreach ($pages as $page):?>
            <?php if ($page->level_menu == $id || $page->level_menu == 3):?>
                <div _csrf="<?=Yii::$app->request->getCsrfToken()?>" menu-id ="<?=$id?>" page-id="<?=$page->id?>" class="btn btn-success"><?=$page->name?></div>
             <?php endif;?>
        <?php endforeach;?>

        <?php foreach ($cats as $cat):?>
            <?php if ($cat->level_menu == $id || $cat->level_menu == 3):?>
                <div _csrf="<?=Yii::$app->request->getCsrfToken()?>" menu-id ="<?=$id?>" cat-id ="<?=$cat->id?>" class="btn btn-success"><?=$cat->name?></div>
            <?php endif;?>
        <?php endforeach;?>

    </div>
    <hr>
    <div class="row">
        <div class="col-sm-12">
            <h4>Страницы</h4>
            <div id="pages" class="btn-group">
                <?php foreach ($pages as $page):?>
                <div _csrf="<?=Yii::$app->request->getCsrfToken()?>" menu-id ="<?=$id?>" page-id="<?=$page->id?>" class="btn btn-default"><?=$page->name?></div>
                <?php endforeach;?>
            </div>
        </div>

    </div>
    <hr>
    <div class="row">
        <div class="col-sm-12">
            <h4>Категории</h4>
            <div class="btn-group" id="cats">
                <?php foreach ($cats as $cat):?>
                <div _csrf="<?=Yii::$app->request->getCsrfToken()?>" menu-id ="<?=$id?>" cat-id ="<?=$cat->id?>" class="btn btn-default"><?=$cat->name?></div>
                <?php endforeach;?>
            </div>
        </div>

    </div>
</div>
