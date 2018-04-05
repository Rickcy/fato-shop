<?php
/**
 * Created by PhpStorm.
 * User: marvel
 * Date: 15.01.18
 * Time: 14:55
 */

/**
 * @var $model \app\models\base\Product
 */

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
$this->title = $model->name
?>
<div class="container" style="margin-bottom: 4rem">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal '], 'fieldConfig' => [
        'template' => '<div class="col-sm-2">{label}</div><div class="col-sm-10">{input}</div><div class="col-sm-12"><div class="col-sm-2"></div><div class="col-sm-5 ">{error}</div></div>',
    ]]); ?>

    <div class="text-center header-text">Основная информация</div>

    <?= $form->field($model, 'name')->textInput()->label('Название товара')?>

    <?= $form->field($model, 'description')->widget(CKEditor::className(), [
        'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
            'preset' => 'standart',

            'inline' => false,
        ]),
    ])->label('Описание')?>

    <div class="row">
        <?= $form->field($model, 'photos[]')->hiddenInput(['id'=>'imgGoodsInput'])->label('Изображения') ?>
        <div class="col-sm-2"></div>
        <div class="col-sm-8" >
            <?php if (count($model->images) > 0 ):?>
                <?php foreach ($model->images as $image):?>
                    <img src="/files/<?=$image->name.'.'.$image->extension?>" style='max-width: 25%;margin: 10px'/>
                <?php endforeach;?>
            <?php endif;?>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8" id="image-template">
            <?php if($photos !=null):?>
                <?php foreach ($photos as $photo):?>
                    <span style="position: relative;margin: 1rem"><img class="img_good" style='max-width: 25%;margin: 10px;<?=$photo->is_main ?"border: 5px #13ca3c solid":""?>' src="<?=$photo['url']?>" /><span title="<?=$photo->is_main ?"Сделать неосновной":"Сделать основной"?>" class='mainPhotoGood glyphicon glyphicon-<?=$photo->is_main ?"remove":"ok"?>' path='<?=$photo['url']?>' ></span><span title="Удалить фото" class='deletePhotoGood glyphicon glyphicon-remove' path='<?=$photo['url']?>' ></span></span>
                <?php endforeach;?>
            <?php endif;?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <input type="file" accept="image/*,image/jpeg" style="display: block;width: 1px;height: 1px;opacity: 0;" product-id="<?=$model->id?>"  id="imgGoods">
            <button id="upload-btn" type="button" class="btn btn-primary">Загрузить фото</button>
        </div>
    </div>

    <div class="col-xs-10 col-sm-offset-2">
        <div class="row">
            <?php if($model->offer->prices):?>
                <div class="col-sm-6">
                    <?= $form->field($model->offer->prices[0], 'value',['template'=>'<div class="col-sm-12 text-center"><span>{label}</span><span>{input}</span><span ><span class="col-sm-6"></span><span>{error}</span></span></div>'])->textInput()->label('Цена')?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'new_price',['template'=>'<div class="col-sm-12 text-center"><span>{label}</span><span>{input}</span><span ><span class="col-sm-6"></span><span>{error}</span></span></div>'])->textInput()->label('Цена со скидкой')?>
                </div>
            <?php else:;?>
                <div class="col-sm-6">
                    <?= $form->field($model, 'new_price',['template'=>'<div class="col-sm-12 text-center"><span>{label}</span><span>{input}</span><span ><span class="col-sm-6"></span><span>{error}</span></span></div>'])->textInput()->label('Цена')?>
                </div>
            <?php endif;?>
        </div>
    </div>
    <hr>
    <div class="text-center header-text">Дополнительная информация</div>
    <?= $form->field($model->prop, 'dimensions')->widget(CKEditor::className(), [
        'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
            'preset' => 'standart',

            'inline' => false,
        ]),
    ])->label('Размеры')?>



    <?= $form->field($model->prop, 'blueprint_url')->widget(CKEditor::className(), [
        'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
            'preset' => 'basic',

            'inline' => false,
        ]),
    ])->label('Чертеж')?>


    <?= $form->field($model, 'main')->hiddenInput(['id'=>'imgGoodMain','value'=>$model->main])->label('') ?>

    <div class="col-sm-12" style="position: fixed;bottom: 0">

        <div class="form-group text-center">
            <?= Html::submitButton( Yii::t('app', 'Сохранить товар') , ['class' =>  'btn create-btn btn-md btn-success' ]) ?>
            <?= Html::a(Yii::t('app', 'Отмена'), ['tovary'],['class' =>  'btn create-btn btn-md btn-default']) ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>
</div>
