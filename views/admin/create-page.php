<?php
/**
 * Created by PhpStorm.
 * User: marvel
 * Date: 07.12.17
 * Time: 14:59
 */

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

if ($model->name){
    $this->title = $model->name;
}
else{
    $this->title = 'Добавить страницу';
}
?>
<div class="container">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal'], 'fieldConfig' => [
        'template' => '<div class="col-sm-12">{input}</div><div class="row"><div class="col-sm-5 ">{error}</div></div>',
    ]]); ?>



    <?= $form->field($model, 'name')->textInput(['placeholder'=>'Название страницы'])->label('')?>
    <?= $form->field($model, 'slug')->textInput(['placeholder'=>'Адрес страницы'])->label('')?>
    <?= $form->field($model, 'title')->textInput(['placeholder'=>'Title страницы'])->label('')?>
    <?= $form->field($model, 'description')->textInput(['placeholder'=>'Описание страницы'])->label('')?>
    <?= $form->field($model, 'keywords')->textInput(['placeholder'=>'Ключевые слова'])->label('')?>
    <?= $form->field($model, 'content')->widget(CKEditor::className(), [
    'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
        'preset' => 'full',

        'inline' => false,
        ]),
    ])->label('')?>

    <hr>
    <div class="col-sm-12">
        <div class="form-group text-left">
            <?= Html::submitButton( Yii::t('app', 'Сохранить страницу') , ['class' =>  'btn create-btn btn-md btn-success' ]) ?>
            <?= Html::a(Yii::t('app', 'Отмена'), ['stranicy'],['class' =>  'btn create-btn btn-md btn-default']) ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>
</div>
