<?php
/**
 * Created by PhpStorm.
 * User: marvel
 * Date: 07.12.17
 * Time: 14:42
 */

use yii\bootstrap\Html;
$this->title = 'Страницы';
?>
<div class="container">
    <div class="buttons">
        <?= Html::a(Yii::t('app', 'Назад'), ['index'],['class' =>  'btn create-btn btn-md btn-default']) ?>
        <?= Html::a(Yii::t('app', '+ Добавить страницу'), ['create-page'], ['class' => 'btn btn-success']) ?>
    </div>

    <div class="table-responsive" style="margin-top: 3rem">
        <table border="0" class="table table-striped">
            <thead class="thead-main">
            <tr>


                <td>ID</td>

                <td>Название</td>


                <td>Адрес</td>
                <td>Title</td>

                <td>Действие</td>

            </tr>
            </thead>
            <tbody>
            <tr>


                <td></td>

                <td>Главная</td>


                <td></td>
                <td></td>

                <td> <?= Html::a('', ['edit-main-page'], ['class'=>'glyphicon glyphicon-edit status'])?></td>

            </tr>


            <?php
            $i=0;

            foreach ($pages as $page):?>
                <tr class=<?=$i%2 == 0 ? 'even' : 'odd'?>>

                    <td >
                        <?= $page->id ?>

                    </td>

                    <td class="page-<?=$page->id?>">
                        <?= Html::a($page->name, ['show', 'id' => $page->id]) ?>

                    </td>
                    <td>
                        <?= $page->slug ?>
                    </td>
                    <td>
                        <?= $page->title ?>
                    </td>


                        <td>   <?= Html::a('', ['delete-page', 'id' => $page->id], ['class'=>'glyphicon glyphicon-trash status','data' => [
                                'confirm' => Yii::t('app', 'Вы действительно хотите удалить страницу?'),
                                'method' => 'post',
                            ],])?></td>




                </tr>
                <?php
                $i++;
            endforeach;?>
            </tbody>
        </table>
    </div>
</div>