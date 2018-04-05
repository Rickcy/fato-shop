<?php
/**
 * Created by PhpStorm.
 * User: marvel
 * Date: 08.12.17
 * Time: 14:44
 */
?>
<?php if($isCat):?>
<div _csrf="<?=Yii::$app->request->getCsrfToken()?>" menu-id ="<?=$id?>" cat-id ="<?=$cat->id?>" class="btn btn-success"><?=$cat->name?></div>
<?php else:?>
<div _csrf="<?=Yii::$app->request->getCsrfToken()?>" menu-id ="<?=$id?>" page-id="<?=$page->id?>" class="btn btn-success"><?=$page->name?></div>
<?php endif;?>