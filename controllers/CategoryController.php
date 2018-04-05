<?php
/**
 * Created by PhpStorm.
 * User: marvel
 * Date: 06.12.17
 * Time: 14:58
 */

namespace app\controllers;


use app\models\Category;
use app\models\Group;
use app\models\Product;
use yii\filters\VerbFilter;
use yii\web\Controller;

class CategoryController extends Controller
{
    public $layout='front';


    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex(){
        $slug = $_GET['slug'];
        $cats = Group::find()->all();
        $current_cat = null;
        foreach ($cats as  $cat){
            if($cat['slug'] == $slug){
               $current_cat = Group::findOne(['slug'=>$slug]);
               $goods = Product::find()->where(['group_id'=>$current_cat->id])->all();
            }
        }
        if($current_cat){
            return $this->render('index',['cat'=>$current_cat,'goods'=>$goods]);
        }
        else{
            $this->goHome();
        }

    }
}