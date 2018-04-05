<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="login-page">
    <div class="slider-block">
    <div class="form">

        <?php $form = ActiveForm::begin(['class' => 'register-form']); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true,'placeholder'=>'Логин'])->label('') ?>

        <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'Пароль'])->label('') ?>



        <div class="form-group">
            <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    </div>
</div>
