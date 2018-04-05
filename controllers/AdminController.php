<?php
/**
 * Created by PhpStorm.
 * User: marvel
 * Date: 06.12.17
 * Time: 16:09
 */

namespace app\controllers;


use app\models\Category;
use app\models\Group;
use app\models\LoginForm;
use app\models\MainImage;
use app\models\Pages;
use app\models\Product;
use app\models\PropertiesProduct;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Inflector;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

class AdminController extends Controller
{

    public $layout = 'admin';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','index','tovary','kpategorii','stranicy','edit-menu','create-page','delete-page','delete-cat','add-menu-cat','add-menu-page','create-kategorii','delete-menu'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],

        ];
    }

    public function actionPanel(){
        $this->layout = 'login';

        if (!Yii::$app->user->isGuest) {
            return $this->redirect('/admin');
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect('/admin/index');
        }
        return $this->render('signin', [
            'model' => $model,
        ]);

    }

    public function actionIndex(){

        return $this->render('index');
    }


    public function actionUploadPhoto($id){

        $model = new MainImage();
        if (Yii::$app->request->isAjax){
            $model->photoFile = UploadedFile::getInstancesByName('photoGoodsFile')[0];
            $upl_file = $model->uploadImage($id);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $upl_file;
        }
    }


    public function actionDeletePhotoGood(){

        $path  = Yii::$app->request->post('path');
        $photo = MainImage::findOne(['url'=>$path]);
        if($photo){
            $photo->delete();
        }
        unlink(Yii::getAlias('@uploadDir').$path);
        return true;
    }



    public function actionTovary(){
        $goods = Product::find();
        $dataProvider = new ActiveDataProvider([
            'query'      => $goods,
            'pagination' => [
                'pageSize' => 20,
            ]
        ]);

        $goods->orderBy(['name'=>SORT_ASC]);
        $goods->all();


        return $this->render('goods', [
            'goods' => $dataProvider->models,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionTovar($id){
        $model = Product::findOne($id);
        $model->new_price = min($model->offer->prices[0]->value,$model->offer->prices[1]->value);
        $prop = PropertiesProduct::findOne(['product_id'=>$model->id]);
        $photos = MainImage::findAll(['product_id'=>$model->id]);
        foreach ($photos as $photo){
            if($photo->is_main){
                $model->main = $photo->url;
            }
        }
        $new = true;
        if($model->new_price){
            $new = false;
        }
        if(!$prop){

            $new_prop = new PropertiesProduct();
            $new_prop->product_id = $model->id;
            $new_prop->save();
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            $transaction = \Yii::$app->db->beginTransaction();
            try{
                $prop->load(Yii::$app->request->post());
                $prop->save();
                $model->saveNewPrice($new);

                $model->saveGoodsPhoto();


                $model->save();


                $transaction->commit();
                $this->redirect('/admin/tovary');
            }
            catch (\Exception $exception){
                var_dump($exception);
                $transaction->rollBack();
            }


        }
        return $this->render('good', ['model' => $model, 'photos' => $photos]);
    }

    public function actionKategorii(){
        $cats = $cats = Group::find()->filterWhere(['!=','parent_id',null])->all();

        $sql = 'SELECT group_id ,count(*)FROM product GROUP BY group_id ORDER BY group_id ASC';
        $groups = Group::findBySql($sql)->asArray()->all();

        foreach ($cats as $cat){
            foreach ($groups as $item){
                if($cat->id == $item['group_id']){

                    $cat['count_product'] = $item['count'];
                }
            }
        }

        return $this->render('categories', ['cats' => $cats]);
    }


    public function actionChangeStatus(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        $type = Yii::$app->request->post('type');
        if (Yii::$app->request->isAjax) {
            $group = Group::findOne($id);
            if ($type =='ps') {
                $publicStatus = $group->is_active == false ? $group->is_active = true : $group->is_active = false;
                $group->save();
                return $this->renderAjax('status', ['status' => $publicStatus==1?true:false, 'statusClass' => 'publicStatus', 'iconFalse' => 'glyphicon-lock']);
            }

        }


    }



    public function actionCreateKategorii(){
        $model = new Group();
        $all_cat = Group::find()->all();
        if ($model->load(Yii::$app->request->post()) && $model->validate()){
           if(!$model->slug){
             $model->slug =   Inflector::slug($model->name, '-');
           }
            $model->save();
            $this->redirect('/admin/kategorii');
        }
        return $this->render('create-cat', [
            'model'=>$model,'all_cat'=>$all_cat
        ]);
    }


    public function actionEditMainPage(){
        $model = Pages::findOne(['name'=>'Главная','slug'=>'/']);
        if(!$model){
            $model = new Pages();
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            $model->save();
        }
        return $this->render('edit-main-page', ['model' => $model]);
    }


    public function actionDeleteMenu(){
        $id = Yii::$app->request->post('id');
        $menu = Yii::$app->request->post('menu');
        $wtf = Yii::$app->request->post('wtf');
        if($wtf == 1){
            $list = Pages::findOne($id);
        }
        else{
            $list = Group::findOne($id);
        }

        if($list->level_menu != 3){
            $list->level_menu = null;
        }
        elseif($list->level_menu == 3 && $menu == 1){
            $list->level_menu = 2;
        }
        elseif($list->level_menu == 3 && $menu == 2){
            $list->level_menu = 1;
        }
        $list->save();

    }


    public function actionAddMenuCat(){

        $id = Yii::$app->request->post('id');
        $menu = Yii::$app->request->post('menu');
        $cat = Group::findOne($id);
        if($cat->level_menu != 3  && $cat->level_menu != null){
            $cat->level_menu = 3;
        }
        else{
            $cat->level_menu = $menu;
        }

        $cat->save();

        return $this->renderPartial('part/part', ['isCat'=>true,'cat' => $cat, 'id' => $id, 'page' => null]);

    }

    public function actionAddMenuPage(){

        $id = Yii::$app->request->post('id');
        $menu = Yii::$app->request->post('menu');
        $page = Pages::findOne($id);
        if($page->level_menu != 3  && $page->level_menu != null){
            $page->level_menu = 3;
        }
        else{
            $page->level_menu = $menu;
        }
        $page->save();

        return $this->renderPartial('part/part', ['isCat'=>false,'cat' => null, 'id' => $id, 'page' => $page]);

    }


    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionStranicy(){
        $pages = Pages::find()->andFilterWhere(['!=','name','Главная'])->andFilterWhere(['!=','slug','/'])->all();
        return $this->render('pages', ['pages' => $pages]);
    }


    public function actionShow($id){
        $model = Pages::findOne($id);
        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            if(!$model->slug){
                $model->slug =   Inflector::slug($model->name, '-');
            }
            $model->save();
            $this->redirect('/admin/stranicy');
        }
        return $this->render('create-page', [
            'model'=>$model
        ]);
    }


    public  function actionShowCat($id){
        $model = Group::findOne($id);
        $all_cat = Group::find()->filterWhere(['!=','id',$id])->all();
        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            if(!$model->slug){
                $model->slug =   Inflector::slug($model->name, '-');
            }
            $model->save();
            $this->redirect('/admin/kategorii');
        }
        return $this->render('create-cat', [
            'model'=>$model,'all_cat'=>$all_cat
        ]);
    }

    public function actionEditMenu($id){

        $cats = Group::find()->all();
        $pages = Pages::find()->all();

        return $this->render('edit-menu', [
            'id'=>$id,'cats'=>$cats,'pages'=>$pages
        ]);

    }



    public function actionDeletePage($id){
        $page = Pages::findOne($id);
        $page->delete();
        return $this->redirect('/admin/stranicy');
    }

    public function actionDeleteCat($id){
        $group = Group::findOne($id);
        $group->delete();
        return $this->redirect('/admin/kategorii');
    }

    public function actionCreatePage(){
        $model = new Pages();

        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            if(!$model->slug){
                $model->slug =   Inflector::slug($model->name, '-');
            }
            $model->save();
            $this->redirect('/admin/stranicy');
        }
        return $this->render('create-page', [
            'model'=>$model
        ]);
    }



}