<?php
/**
 * Created by PhpStorm.
 * User: marvel
 * Date: 08.12.17
 * Time: 15:54
 */

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
$this->title = 'Редактирование главной страницы';

?>
<div class="container">
    <div class="buttons">
        <?= Html::a(Yii::t('app', 'Назад'), ['stranicy'],['class' =>  'btn create-btn btn-md btn-default']) ?>
    </div>

<div class="table-responsive" style="margin-top: 3rem">
<table border="0" class="table table-striped">
    <tbody>
    <tr>

        <td>Верхнее меню</td>
        <td></td>
        <td></td>
        <td>   <?= Html::a('', ['edit-menu', 'id' => 1], ['class'=>'glyphicon glyphicon-edit status'])?></td>
    </tr>
    <tr>

        <td>Нижнее меню</td>
        <td></td>
        <td></td>
        <td>   <?= Html::a('', ['edit-menu', 'id' => 2], ['class'=>'glyphicon glyphicon-edit status'])?></td>
    </tr>
    </tbody>
</table>
</div>

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal'], 'fieldConfig' => [
        'template' => '<div class="col-sm-12">{input}</div><div class="row"><div class="col-sm-5 ">{error}</div></div>',
    ]]); ?>



    <?= $form->field($model, 'name')->hiddenInput(['value'=>'Главная'])->label('')?>
    <?= $form->field($model, 'slug')->hiddenInput(['value'=>'/'])->label('')?>
    <?= $form->field($model, 'title')->textInput(['placeholder'=>'Title страницы'])->label('')?>
    <?= $form->field($model, 'description')->textInput(['placeholder'=>'Описание страницы'])->label('')?>
    <?= $form->field($model, 'keywords')->textInput(['placeholder'=>'Ключевые слова'])->label('')?>
    <div class="col-sm-12">Под-меню</div>
    <?= $form->field($model, 'content')->widget(CKEditor::className(), [
        'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
            'preset' => 'standart',

            'inline' => false,
        ]),
    ])->label('')?>
    <div class="col-sm-12">Слайдер</div>
    <?= $form->field($model, 'content_2')->widget(CKEditor::className(), [
        'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
            'preset' => 'standart',

            'inline' => false,
        ]),
    ])->label('')?>
    <div class="col-sm-12">Баннеры</div>
    <?= $form->field($model, 'baners')->widget(CKEditor::className(), [
        'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
            'preset' => 'standart',

            'inline' => false,
        ]),
    ])->label('')?>

    <hr>
    <div class="col-sm-12">
        <div class="form-group text-left">
            <?= Html::submitButton( Yii::t('app', 'Сохранить страницу') , ['class' =>  'btn create-btn btn-md btn-success' ]) ?>
            <?= Html::a(Yii::t('app', 'Вернуться'), ['stranicy'],['class' =>  'btn create-btn btn-md btn-default']) ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
