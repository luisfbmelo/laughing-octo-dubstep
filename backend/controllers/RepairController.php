<?php

namespace backend\controllers;

use Yii;
use common\models\Repair;
use common\models\Client;
use common\models\Brands;
use common\models\Equipaments;
use common\models\Models;
use common\models\Stores;
use common\models\RepairType;
use common\models\Inventory;
use common\models\EquipBrand;
use common\models\Accessories;
use common\models\RepairAccessory;
use common\models\User;
use common\models\Status;

use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\base\Exception;

date_default_timezone_set("Atlantic/Azores");

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
            'sort'=> ['defaultOrder' => ['date_entry'=>SORT_DESC]],
            'pagination' => [
                'pageSize' => 10,
            ],
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
        

        /*GET EXISTING DATA*/
        $allStores=ArrayHelper::map($modelStores->getAllStores(), 'id_store', 'storeDesc');
        //$allStores = stores::find()->asArray()->orderBy('storeDesc ASC')->all();

        $allBrands = ArrayHelper::map($modelBrands->getAllBrands(), 'id_brand', 'brandName');        

        $allEquip = ArrayHelper::map($modelEquip->getAllEquip(), 'id_equip', 'equipDesc');      

        $allModels = ArrayHelper::map($modelModels->getAllModels(), 'id_model', 'modelName'); 

        $allTypes = ArrayHelper::map($modelTypes->getAllTypes(), 'id_type', 'typeDesc');

        //$allAccess = ArrayHelper::map(accessories::find()->where('accessType != :id', [':id' => '2'])->asArray()->orderBy('accessDesc ASC')->all(), 'id_accessories', 'accessDesc');
        $allAccess = ArrayHelper::map($modelAccess->getAllAccess(), 'id_accessories', 'accessDesc');


        /*LOGIC PROCESS*/
        //if it is canceled
        if (isset($_POST['cancelar'])){
            $this->redirect(['index']);
        }else if (isset($_POST['submit'])){
            
            /*WAITING CODING LINES*/
            //$modelAccess->id_accessories = array(2);
            //
            //
            //try saving
           /* if ($modelRepair->load(Yii::$app->request->post()) && $modelRepair->save()) {
                //return $this->redirect(['view', 'id' => $modelRepair->id_repair]);

            //if didn't save
            } else {
                
            }*/

            //


            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                $errorStatus = false;
                $valid = false;
                $validDropdowns = false;
                $isOk = [];

                //validate client
                $valid = $modelClient->load(Yii::$app->request->post()) && $modelClient->validate(['cliName','cliAdress','cliDoorNum','cliPostalCode','cliPostalSuffix','cliConFix','cliConMov1','cliConMov2']);



                //start dropdownlists validation
                //if equip is ok, give only the brands of that equip
                $validDropdowns = $modelEquip->load(Yii::$app->request->post()) && $modelEquip->validate(['id_equip']);
                if ($validDropdowns){
                    $allBrands = ArrayHelper::map($modelBrands->getBrandsOfEquip(Yii::$app->request->post('Equipaments')['id_equip']), 'id_brand', 'brandName');

                    $isOk[0]=true;
                    
                } else{
                    $isOk[0]=false;
                }


                //if brand is ok, give only the models of that brand
                $validDropdowns = $modelBrands->load(Yii::$app->request->post()) && $modelBrands->validate(['id_brand']) && $validDropdowns;
                if ($validDropdowns){
                    $allModels = ArrayHelper::map($modelModels->getModelsOfEqBr(Yii::$app->request->post('Equipaments')['id_equip'],Yii::$app->request->post('Brands')['id_brand']), 'id_model', 'modelName');
                    $isOk[1]=true;
                } else{
                    $isOk[1]=false;
                }

                //continue validate
                $validDropdowns = ($modelModels->load(Yii::$app->request->post()) && $modelModels->validate(['id_model']) && $validDropdowns) ? $isOk[2]=true : $isOk[2]=false;
                
                $valid = $modelInv->load(Yii::$app->request->post()) && $modelInv->validate(['inveSN']) && $valid;

                $valid = $modelTypes->load(Yii::$app->request->post()) && $modelTypes->validate(['id_type']) && $valid;

                $valid = $modelStores->load(Yii::$app->request->post()) && $modelStores->validate(['id_store']) && $valid;

                $valid = $modelRepair->load(Yii::$app->request->post()) && $modelRepair->validate(['repair_desc','priority']) && $valid;

                if ($valid && $validDropdowns){
                    
                    //ADD INVENTORY
                    $invArray = [
                        'id_inve' => NULL,
                        'isNewRecord' => TRUE,
                        'equip_id' => $modelEquip->id_equip,
                        'brand_id' => $modelBrands->id_brand,
                        'model_id' => $modelModels->id_model,
                        'inveSN' =>$modelInv->inveSN

                    ];
                    //add to model
                    $invId = $modelRepair->addModelData($modelInv,$invArray);

                    //ADD CLIENT
                    if (Yii::$app->request->post('clientDataHidden')=="new"){
                        $clientArray = [
                            'id_client' => NULL,
                            'isNewRecord' => TRUE
                        ];
                        //add to model
                        $clientId = $modelRepair->addModelData($modelClient,$clientArray);
                    }else{
                        $newModel = $modelClient->findOne(Yii::$app->request->post('clientDataHidden'));
                        $newModel->load(Yii::$app->request->post());
                        $newModel->save();

                        $clientId = Yii::$app->request->post('clientDataHidden');
                    }                 
                    

                    //set max budget
                    if ($modelRepair->maxBudget==""){
                        $modelRepair->maxBudget = NULL;
                    }

                    //set final vars
                    $modelRepair->attributeToRepair([
                        'status_id' => 1,
                        'store_id' => $modelStores->id_store,
                        'user_id' => \Yii::$app->user->getId(),
                        'date_entry' => date('Y-m-d H:i:s'),
                        'type_id' => $modelTypes->id_type,
                        'client_id' => $clientId,
                        'inve_id' => $invId
                    ]);
                    
                    /*VALIDATE REPAIR MODEl*/
                    if ($modelRepair->save()){
                        $repairId = Yii::$app->db->getLastInsertID();


                        //save accessories
                        if (empty(Yii::$app->request->post('Accessories')['id_accessories'])!=1){

                            for ($accInc=0;$accInc<sizeof(Yii::$app->request->post('Accessories')['id_accessories']);$accInc++){
                                $accessArray = [];

                                if (Yii::$app->request->post('Accessories')['id_accessories'][$accInc]==3){
                                    $otherDesc = Yii::$app->request->post('RepairAccessory')['otherDesc'];
                                }else{
                                    $otherDesc = NULL;
                                }

                                $accessArray = [
                                    'isNewRecord' => TRUE,
                                    'repair_id' => $repairId,
                                    'accessory_id' => Yii::$app->request->post('Accessories')['id_accessories'][$accInc],
                                    'otherDesc' => $otherDesc
                                ];

                                $modelRepair->addModelData($modelRepairAccess,$accessArray);
                            }
                            
                        }

                        //commit all saves
                        $transaction->commit();
                        return $this->redirect(['index']);
                        //throw new Exception('STOP.');
                    }else{
                        //throw new Exception('Unable to save record1.');
                    }
                                       
                }else{
                    //throw new Exception('Unable to save record2.');
                }                     

                //return $this->redirect(['view', 'id' => $model->name]);

            } catch(Exception $e) {
                $transaction->rollback();
                echo $e->getMessage(); exit;
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
                'modelRepairAccess' => $modelRepairAccess,
                'isOk' => $isOk
            ]);
        }

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
            'modelRepairAccess' => $modelRepairAccess,
            'isOk' => false
        ]);        
    }

    /**
     * Get all brands from given equipment
     * @return [json] [all brands of that equipment]
     */
    public function actionGetbrands(){
        $brands = ArrayHelper::map(brands::find()->joinwith('equipBrands','equipBrands.brand_id')->where(['equip_id' => $_POST['id'],'status'=>1])->all(), 'id_brand', 'brandName');
        return json_encode($brands);
    }

    public function actionGetmodels(){
        $models = ArrayHelper::map(models::find()->joinwith('brand')->where(['brand_id' => $_POST['brandId'],'equip_id' => $_POST['equipId'],'status'=>1])->all(), 'id_model', 'modelName');
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
        /*START MODELS*/
        $modelRepair = $this->findModel($id);
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
        

        /*GET EXISTING DATA*/
        $allStores=ArrayHelper::map($modelStores->getAllStores(), 'id_store', 'storeDesc');
        //$allStores = stores::find()->asArray()->orderBy('storeDesc ASC')->all();

        $allBrands = ArrayHelper::map($modelBrands->getAllBrands(), 'id_brand', 'brandName');        

        $allEquip = ArrayHelper::map($modelEquip->getAllEquip(), 'id_equip', 'equipDesc');      

        $allModels = ArrayHelper::map($modelModels->getAllModels(), 'id_model', 'modelName'); 

        $allTypes = ArrayHelper::map($modelTypes->getAllTypes(), 'id_type', 'typeDesc');

        $allAccess = ArrayHelper::map($modelAccess->getAllAccess(), 'id_accessories', 'accessDesc');

        /*SET DEFAULT DATA*/
        //stores
        $modelStores->id_store = $modelRepair->store_id;
        //client
        $modelClient = $modelClient->findOne($modelRepair->client_id);

        //accessories
        $modelAccess->id_accessories = $modelRepair->getThisAccess($modelRepair->id_repair);
        $modelRepairAccess->otherDesc = $modelRepair->getThisOtherDesc($modelRepair->id_repair);

        //repair type
        $modelTypes = $modelTypes->findOne($modelRepair->type_id);

        //inventory
        $modelInv = $modelInv->findOne($modelRepair->inve_id);
        $modelEquip->id_equip = $modelInv->equip_id;
        $modelBrands->id_brand = $modelInv->brand_id;
        $modelModels->id_model = $modelInv->model_id;

        if (isset($_POST['cancelar'])){
            return $this->goBack();
        }else if (isset($_POST['submit'])){
            return $this->goBack();
        }


        return $this->render('update', [
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
            'modelRepairAccess' => $modelRepairAccess,
            'isOk' => false
        ]);
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

    public function actionDelajax(){
        if (isset($_POST['list']) && $_POST['list']!=""){
            $listarray = $_POST['list'];
            $error = false;

            //removes all projects
            foreach($listarray as $repair){
                repair::find()->where(['id_repair'=>$repair])->one()->delete();
            }

            echo json_encode("done");
            
        }else{
            echo json_encode("error");
        }
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
