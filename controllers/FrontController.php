<?php
/**
 * Created by PhpStorm.
 * User: marvel
 * Date: 01.12.17
 * Time: 17:19
 */

namespace app\controllers;

use app\models\base\Product;
use app\models\Pages;
use yii\filters\VerbFilter;
use yii\web\Controller;

class FrontController extends Controller
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


    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex(){
        $goods =  Product::find()->all();
        return $this->render('index', ['goods' => $goods]);
    }

    public function actionBlankContent(){
        $slug = $_GET['slug'];
        $pages = Pages::find()->all();
        $current_page = null;
        foreach ($pages as  $page){
            if($page['slug'] == $slug){
                $current_page = Pages::findOne(['slug'=>$slug]);
            }
        }
        if($current_page){
            return $this->render('blank-content',['page'=>$current_page]);
        }
        else{
            $this->goHome();
        }

    }

    public function actionGood(){
        $slug = $_GET['slug'];
        $good = Product::findOne(['slug'=>$slug]);
        $goods = Product::find()->where(['group_id'=>$good->group_id])->limit(4)->all();
        return $this->render('good',['good'=>$good,'goods'=>$goods]);
    }

}