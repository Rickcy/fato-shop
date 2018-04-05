<?php
/**
 * Created by PhpStorm.
 * User: marvel
 * Date: 01.12.17
 * Time: 17:21
 */


use app\assets\AdminAsset;
use app\models\Category;
use yii\bootstrap\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

AdminAsset::register($this);
$categories = Category::find()->all();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="navbar navbar-inverse navbar-static-top">
    <div class="container">
        <div class="adjust-nav">
            <a class="navbar-brand" href="/">
                <img src="/images/logo-2.png">

            </a>

            <span class="logout-spn">
                  <a href="/admin/logout" >Выйти</a>
                </span>
        </div>
    </div>
</div>

<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
