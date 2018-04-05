<?php
/**
 * Created by PhpStorm.
 * User: marvel
 * Date: 08.12.17
 * Time: 15:13
 */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;

if ($model->name){
    $this->title = $model->name;
}
else{
    $this->title = 'Добавить категорию';
}
?>

<div class="container">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal'], 'fieldConfig' => [
        'template' => '<div class="col-sm-12">{input}</div><div class="col-sm-12"><div class="col-sm-5 ">{error}</div></div>',
    ]]); ?>



    <?= $form->field($model, 'name')->textInput(['placeholder'=>'Название категории'])->label('')?>
    <?= $form->field($model, 'slug')->textInput(['placeholder'=>'Адрес категории'])->label('')?>
    <?= $form->field($model, 'title')->textInput(['placeholder'=>'Title категории'])->label('')?>
    <?= $form->field($model, 'description')->textInput(['placeholder'=>'Описание категории'])->label('')?>
    <?= $form->field($model, 'keywords')->textInput(['placeholder'=>'Ключевые слова'])->label('')?>

    <?php $items = ArrayHelper::map($all_cat,'id','name');
    $params = [
        'prompt' => 'Выбирите родителькую категорию'
    ];
    echo $form->field($model, 'parent_id')->dropDownList($items,$params)->label('')?>



    <hr>
        <div class="col-sm-12">
            <div class="form-group text-left">
                <?= Html::submitButton( Yii::t('app', 'Сохранить категорию') , ['class' =>  'btn create-btn btn-md btn-success' ]) ?>
                <?= Html::a(Yii::t('app', 'Отмена'), ['kategorii'],['class' =>  'btn create-btn btn-md btn-default']) ?>
            </div>
        </div>


    <?php ActiveForm::end(); ?>
</div>
