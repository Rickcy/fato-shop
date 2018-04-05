<?php
/**
 * Created by PhpStorm.
 * User: marvel
 * Date: 06.12.17
 * Time: 18:19
 */

/**
 * @var $cat \app\models\base\Group
 */
use yii\bootstrap\Html;
$this->title = 'Категории';
?>
<div class="container">
    <div class="buttons">
        <?= Html::a(Yii::t('app', 'Вернуться'), ['index'],['class' =>  'btn create-btn btn-md btn-default']) ?>
        <?= Html::a(Yii::t('app', '+ Добавить категорию'), ['create-kategorii'], ['class' => 'btn btn-success']) ?>
    </div>

    <div class="table-responsive" style="margin-top: 3rem">
        <table border="0" class="table table-striped">
            <thead class="thead-main">
            <tr>


                <td>ID</td>

                <td>Название</td>
                <td>Адрес</td>
                <td>Активность</td>
                <td>Кол-во товаров</td>


            </tr>
            </thead>
            <tbody>

            <?php
            $i=0;

            foreach ($cats as $cat):?>
                <tr class=<?=$i%2 == 0 ? 'even' : 'odd'?>>

                    <td >
                        <?= $cat->id ?>

                    </td>

                    <td class="cat-<?=$cat->id?>">
                        <?= Html::a($cat->name, ['show-cat', 'id' => $cat->id]) ?>

                    </td>
                    <td>
                        <?= $cat->slug ?>
                    </td>
                    <td id="gridRow<?=$cat->id?>ps">
                        <?=$this->render("status",['status'=>$cat->is_active==1?true:false,'statusClass'=>'publicStatus','iconFalse'=>'glyphicon-lock'])?>
                    </td>
                    <td>
                        <?= $cat['count_product'] ? $cat['count_product'] : 0  ?>
                    </td>






                </tr>
                <?php
                $i++;
            endforeach;?>
            </tbody>
        </table>
    </div>
</div>
