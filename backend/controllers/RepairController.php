<?php

namespace backend\controllers;

use Yii;
use common\models\repair;
use common\models\client;
use common\models\brands;
use common\models\equipaments;
use common\models\models;
use common\models\stores;
use common\models\repairtype;
use common\models\inventory;
use common\models\equipbrand;
use common\models\accessories;
use common\models\repairaccessory;

use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\base\Exception;

/**
 * RepairController implements the CRUD actions for repair model.
 */
class RepairController extends Controller
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],            
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all repair models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => repair::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single repair model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new repair model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        /*START MODELS*/
        $modelRepair = new repair();
        $modelClient = new client();
        $modelStores = new stores();
        $modelBrands = new brands();
        $modelEquip = new equipaments();
        $modelModels = new models();
        $modelTypes = new repairtype();
        $modelInv = new inventory();
        $modelAccess = new accessories();
        $modelRepairAccess = new repairaccessory();
        $modelEquipBrand = new equipbrand();

        //$modelAccess->id_accessories = array(2);

        //print_r(repairtype::find()->joinwith('status'));
        //facebook_posts::find()->joinwith('fans')->joinWith(['comments', 'comments.fan'])->all();


        /*GET EXISTING DATA*/
        $allStores=ArrayHelper::map(stores::find()->asArray()->orderBy('storeDesc ASC')->all(), 'id_store', 'storeDesc');
        //$allStores = stores::find()->asArray()->orderBy('storeDesc ASC')->all();

        $allBrands = ArrayHelper::map(brands::find()->asArray()->orderBy('brandName ASC')->all(), 'id_brand', 'brandName');        

        $allEquip = ArrayHelper::map(equipaments::find()->asArray()->orderBy('equipDesc ASC')->all(), 'id_equip', 'equipDesc');        

        $allModels = ArrayHelper::map(models::find()->asArray()->orderBy('modelName ASC')->all(), 'id_model', 'modelName'); 

        $allTypes = ArrayHelper::map(repairtype::find()->asArray()->orderBy('typeDesc ASC')->all(), 'id_type', 'typeDesc');

        //$allAccess = ArrayHelper::map(accessories::find()->where('accessType != :id', [':id' => '2'])->asArray()->orderBy('accessDesc ASC')->all(), 'id_accessories', 'accessDesc');
        $allAccess = ArrayHelper::map(accessories::find()->asArray()->orderBy('accessDesc ASC')->all(), 'id_accessories', 'accessDesc');


        /*LOGIC PROCESS*/
        //if it is canceled
        if (isset($_POST['cancelar'])){
            $this->redirect(['index']);
        }else if (isset($_POST['submit'])){
            
            //try saving
           /* if ($modelRepair->load(Yii::$app->request->post()) && $modelRepair->save()) {
                //return $this->redirect(['view', 'id' => $modelRepair->id_repair]);

            //if didn't save
            } else {
                
            }*/

             

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                $errorStatus = false;

                if ($modelClient->load(Yii::$app->request->post()) && $modelClient->save()) {

                    $modelRepair->client_id = Yii::$app->db->getLastInsertID();                    
                    
                } else {
                    $errorStatus = true;
                }

                if ($modelEquip->load(Yii::$app->request->post()) && !$modelEquip->validate()) {
                    
                    // throw new Exception('Unable to save record.');
                }

                if ($modelBrands->load(Yii::$app->request->post()) && !$modelBrands->validate()) {
                    
                    // throw new Exception('Unable to save record.');         
                }  

                if ($modelModels->load(Yii::$app->request->post()) && !$modelModels->validate()) {
                    
                    // throw new Exception('Unable to save record.');     
                } 

                if ($modelInv->load(Yii::$app->request->post()) && !$modelInv->validate()) {
                    $errorStatus = true;
                    // throw new Exception('Unable to save record.');
                }

                if (!$errorStatus){
                        echo "a";
                    //ADD INVENTORY
                    $modelInv->id_inve=NULL;
                    $modelInv->isNewRecord=TRUE;
                    $modelInv->equip_id = $modelEquip->id_equip;
                    $modelInv->brand_id = $modelBrands->id_brand;
                    $modelInv->model_id = $modelModels->id_model;
                    $modelInv->inveSN = $modelInv->inveSN;
                    $modelInv->save();

                    $modelRepair->inve_id = Yii::$app->db->getLastInsertID();
                }
 

                $transaction->commit();

                

                //return $this->redirect(['view', 'id' => $model->name]);

            } catch(Exception $e) {
                $transaction->rollback();
            }

            //normal form representation
            return $this->render('create', [
                'modelRepair' => $modelRepair,
                'modelClient' => $modelClient,
                'allStores' => $allStores,
                'allBrands' => $allBrands,
                'allEquip' => $allEquip,
                'allModels' => $allModels,
                'allTypes' => $allTypes,
                'allAccess' => $allAccess,
                'modelStores' => $modelStores,
                'modelBrands' => $modelBrands,
                'modelEquip' => $modelEquip,
                'modelModels' => $modelModels,
                'modelTypes' => $modelTypes,
                'modelInv' => $modelInv,
                'modelAccess' => $modelAccess,
                'modelRepairAccess' => $modelRepairAccess
            ]);
        }else{
            return $this->render('create', [
                'modelRepair' => $modelRepair,
                'modelClient' => $modelClient,
                'allStores' => $allStores,
                'allBrands' => $allBrands,
                'allEquip' => $allEquip,
                'allModels' => $allModels,
                'allTypes' => $allTypes,
                'allAccess' => $allAccess,
                'modelStores' => $modelStores,
                'modelBrands' => $modelBrands,
                'modelEquip' => $modelEquip,
                'modelModels' => $modelModels,
                'modelTypes' => $modelTypes,
                'modelInv' => $modelInv,
                'modelAccess' => $modelAccess,
                'modelRepairAccess' => $modelRepairAccess
            ]);
        }
       

        
    }

    /**
     * Get all brands from given equipment
     * @return [json] [all brands of that equipment]
     */
    public function actionGetbrands(){
        $brands = ArrayHelper::map(brands::find()->joinwith('equipBrands','equipBrands.brand_id')->where(['equip_id' => $_POST['id']])->all(), 'id_brand', 'brandName');
        return json_encode($brands);
    }

    public function actionGetmodels(){
        $models = ArrayHelper::map(models::find()->joinwith('brand')->where(['brand_id' => $_POST['brandId'],'equip_id' => $_POST['equipId']])->all(), 'id_model', 'modelName');
        return json_encode($models);
    }

    /**
     * Updates an existing repair model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_repair]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing repair model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the repair model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return repair the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = repair::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Executes logout
     * @return [type] [description]
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(Yii::$app->urlManager->createUrl(['site/login']));
    }

    /**
     * Checks if the current route matches with given routes
     * @param array $routes
     * @return bool
     */
    public function isActive($routes = array())
    {
        return "activeTop";
    }
}
