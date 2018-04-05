<?php
/**
 * Created by PhpStorm.
 * User: marvel
 * Date: 04.12.17
 * Time: 18:51
 */
/* @var $this \yii\web\View */
/**
 * @var $cat \app\models\Group
 * @var $good \app\models\Product
 */
$this->title = $cat->name;
$this->registerMetaTag(['name' => 'description', 'content' => $cat->description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $cat->keywords]);

?>
<div class="container container-main">
    <h3 class="text-center"><b style="color: #ff4800;text-transform: uppercase"><?=$cat->name?></b></h3>
    <div class="text-center main-name-div">
        Сортировать по
        <select class="form-control" style="display: inline;width:auto "  name="price" id="price">
            <option value="1">цена</option>
            <option value="2">форма</option>
            <option value="3">кол-во мест</option>
        </select>
    </div>

    <div class="row" style="margin-top: 2rem">

        <?php foreach ($goods as $good):?>

                <div class="col-sm-3 text-center">
                    <div class="wrap-block-good">
                        <div class="group-name">
                            <?=$good->group->name?>
                        </div>
                        <?php if($good->offer->is_active):?>
                        <a class="head-name" href="/tovar/<?=$good->group->slug?>/<?=$good->slug?>"><?=$good->name?></a>
                        <?php else:;?>
                            <span class="head-name" ><?=$good->name?></span>
                        <?php endif;?>
                        <div class="img-good">
                            <?php if(count($good->productImages)):?>
                                <?php foreach ($good->productImages as $image):?>
                                    <?php if ($image->is_main):?>
                                        <img src="<?=$image->url?>"  alt="">
                                    <?php endif;?>
                                <?php endforeach;?>
                            <?php else:;?>
                                <img src="/images/good-1.png"  alt="">
                            <?php endif;;?>
                        </div>
                        <div class="color-good">
                            <a class="col_under" href="#">другие расцветки</a>
                        </div>
                        <div class="row" style="margin-top: 2rem">
                            <div class="col-xs-4"><div class="circle-block fa fa-shopping-basket fa-inverse"></div></div>
             <?php if($good->offer->is_active):?>
            <?php if(count($good->offer->prices) > 1):?>
                            <div class="col-xs-4 text-center">
                                <div class="old-price"><?=max($good->offer->prices[0]->value,$good->offer->prices[1]->value)?> ₽</div>
                            </div>

                            <div class="col-xs-4 text-left" style="padding-left: 0"><div class="new-price"><?=min($good->offer->prices[0]->value,$good->offer->prices[1]->value)?> ₽</div></div>
                <?php else:?>
                <div class="col-xs-4 text-center">
                </div>

                <div class="col-xs-4 text-left" style="padding-left: 0"><div class="new-price"><?=$good->offer->prices[0]->value?> ₽</div></div>
                <?php endif;?>
                <?php else:;?>
                 <div class="col-xs-8 text-center">
                     Нет на складе
                 </div>
                <?php endif;?>
                        </div>
                    </div>
                </div>




        <?php endforeach;?>


    </div>
</div>
