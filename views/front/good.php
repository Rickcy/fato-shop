<?php
/**
 * Created by PhpStorm.
 * User: marvel
 * Date: 05.12.17
 * Time: 15:59
 */

/**
 * @var $good \app\models\base\Product
 * @var $imgae \app\models\base\FileUpload
 */

$this->title = $good->name;
?>
<div class="container container-main">
    <div class="row" style="margin-top: 5rem;margin-bottom: 5rem">
        <div class="col-sm-7" style="margin-bottom: 150px;">





            <div class="slider">

                <?php $i = 1;
                $images = array_merge($good->images,$good->productImages);
                if(count($images)):?>
                    <?php foreach ($images as $image):?>
                        <?php if(isset($image->name)):?>
                            <input type="radio" name="slide_switch" id="id<?=$i?>" <?=$i == 1?"checked":""?>/>
                            <label for="id<?=$i?>">
                                <img src="/files/<?=$image->name.'.'.$image->extension?>" width="100"/>
                            </label>
                            <img style="height: 100%;" src="/files/<?=$image->name.'.'.$image->extension?>"/>
                        <?php else:;?>
                            <input type="radio" name="slide_switch" id="id<?=$i?>" <?=$i == 1?"checked":""?>/>
                            <label for="id<?=$i?>">
                                <img src="<?=$image->url?>" width="100"/>
                            </label>
                            <img style="height: 100%;" src="<?=$image->url?>"/>
                        <?php endif;;?>
                        <?php $i++; endforeach;?>
                <?php else:;?>
                    <input type="radio" name="slide_switch" id="id2" checked="checked"/>
                    <label for="id2">
                        <img src="/images/good-main.png" width="100"/>
                    </label>
                    <img src="/images/good-main.png" width="100%"/>
                <?php endif;?>



            </div>


        </div>
        <div class="col-sm-5" style="float: left">
            <div class="row">
                <div class="col-sm-12">
                    <span style="font-size: 2.3rem;color: #3157d2"><?=$good->name?></span>

                    <?php if(count($good->offer->prices) > 1):?>
                        <div>
                            <span style="float: right;color:#ff4800;font-size: 2.3rem;"><?=min($good->offer->prices[0]->value,$good->offer->prices[1]->value)?> ₽</span>
                            <span style="font-size: 1.7rem;padding-right: 3rem;padding-top: 0.5rem;text-decoration: line-through;float: right"><?=max($good->offer->prices[0]->value,$good->offer->prices[1]->value)?> ₽</span>
                        </div>

                    <?php else:?>
                        <div>
                            <span style="float: right;color:#ff4800;font-size: 2.3rem;"><?=$good->offer->prices[0]->value?> ₽</span>
                        </div>
                    <?php endif;?>
                </div>
            </div>

            <div class="row" >
                <div class="col-sm-10" style="margin-top: 1rem;margin-bottom: 1rem">
                    <div class="description" style="margin-top: 2rem">
                        <?=$good->description?>
<!--                        Легко превращается в двуспальную кровать.-->
<!--                        Отделение под сиденьем для хранения постельного белья и т.п.-->
<!--                        Наполнитель подушек сиденья из пенополиуретана и полиэстерного волокна обеспечивает особый комфорт.-->
                    </div>
                </div>
            </div>
            <div class="row" >
                <div class="col-sm-12" style="margin-top: 1rem;margin-bottom: 1rem">
                    <button type="button" class="btn btn-add pull-right"><b style="font-size: 1.5rem;font-weight: 900">+ ДОБАВИТЬ В КОРЗИНУ</b></button>
                </div>
            </div>
            <div class="row" >
                <div class="col-sm-12" style="margin-top: 1rem;margin-bottom: 1rem">
                    <b>Расцветки</b>
                    <div style="margin-top: 1rem;margin-bottom: 1rem">
                        <div style="cursor: pointer;margin-right: 1rem;float: left;width: 40px;height: 40px;border-radius: 50%;background-color: green"></div>
                        <div style="cursor: pointer;margin-right: 1rem;float: left;width: 40px;height: 40px;border-radius: 50%;background-color: blue"></div>
                    </div>
                </div>
            </div>

            <div class="row" >
                <div class="col-sm-6" style="margin-top: 1rem;margin-bottom: 1rem">
                    <b>Размеры</b>
                    <div style="margin: 1rem 0">
                        <?=$good->prop->dimensions?>

                    </div>
                </div>
                <div class="col-sm-6" style="margin-top: 1rem;margin-bottom: 1rem">
                    <div >
                    </div>
                </div>
            </div>
        </div>
    </div>

        <h3 class="text-center main-name-div" ><b style="color: #ff4800">ПОХОЖИЕ ТОВАРЫ</b></h3>

    <div class="row" style="margin-top: 2rem">

        <?php foreach ($goods as $good):?>
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
                        <div class="col-xs-3 text-center">
                            <!--                            <div class="old-price"></div>-->
                        </div>

                        <div class="col-xs-5 text-left" style="padding-left: 0"><div class="new-price"><?=$good->offer->getMainPrice()->value?> ₽</div></div>
                    </div>
                </div>
            </div>



        <?php endforeach;?>
    </div>
</div>
