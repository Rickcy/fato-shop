<?php
/**
 * Created by PhpStorm.
 * User: marvel
 * Date: 06.12.17
 * Time: 18:15
 */

/* @var $good \app\models\Product **/

use yii\bootstrap\Html;
$this->title = 'Товары';
?>
<div class="container">


    <div class="buttons">
        <?= Html::a(Yii::t('app', 'Назад'), ['index'],['class' =>  'btn create-btn btn-md btn-default']) ?>
        <?/**= Html::a(Yii::t('app', '+ Добавить товар'), ['create-tovar'], ['class' => 'btn btn-success']) **/?>
    </div>



<div class="table-responsive" style="margin-top: 3rem">



    <table border="0" class="table table-striped text-center">
        <thead class="thead-main">
        <tr>


            <td>ID</td>
            <td>Название товара</td>
            <td>Кол-во на складе</td>
            <td>Товар на складе</td>


        </tr>
        </thead>
        <tbody>

        <?php
        $i=0;

        foreach ($goods as $good):?>
            <tr class=<?=$i%2 == 0 ? 'even' : 'odd'?>>

                <td >
                    <?= $good->id ?>

                </td>

                <td class="text-left good-<?=$good->id?>">
                    <?php if($good->offer->is_active):?>
                    <?= Html::a($good->name, ['tovar', 'id' => $good->id]) ?>
                    <?php else:?>
                        <?=$good->name?>
                    <?php endif;?>
                </td>


                <td>
                    <?=$good->offer->remnant? rtrim($good->offer->remnant,'.000') : 0 ?>
                </td>

                <td>
                    <?=$good->offer->is_active ? 'Есть' : 'Нет'?>
                </td>





            </tr>
            <?php
            $i++;
        endforeach;?>
        </tbody>
    </table>
    <?php echo \yii\widgets\LinkPager::widget([
        'pagination' => $dataProvider->pagination
    ]) ?>
</div>
</div>