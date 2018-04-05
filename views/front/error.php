<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="container container-main">


    <div class="alert alert-danger">
        <?php if ($message ==='Page not found.'):?>
            Страница не найдена
        <?php else:?>
        <?= nl2br(Html::encode($message)) ?>
        <?php endif;?>
    </div>



</div>
