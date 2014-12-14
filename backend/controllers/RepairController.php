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
use common\models\Parts;
use common\models\RepairParts;

use common\models\SearchRepair;

use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\base\Exception;
use yii\base\Model;

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

    public function actionSearch(){
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
        $modelStatus = new status();        

        /*GET EXISTING DATA*/
        $allStores = ArrayHelper::map($modelStores->getAllStores(), 'id_store', 'storeDesc');
        $allTypes = ArrayHelper::map($modelTypes->getAllTypes(), 'id_type', 'typeDesc');
        $allStatus = ArrayHelper::map($modelStatus->getAllStatus(),'id_status','statusDesc');


        /*print_r(Yii::$app->request->queryParams);
        die();*/
        $searchModel = new SearchRepair();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 0);

        return $this->render('search', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelRepair' => $modelRepair,
            'modelClient' => $modelClient,
            'allStores' => $allStores,
            'allTypes' => $allTypes,
            'allStatus' => $allStatus,
            'modelStores' => $modelStores,
            'modelBrands' => $modelBrands,
            'modelEquip' => $modelEquip,
            'modelModels' => $modelModels,
            'modelTypes' => $modelTypes,
            'modelInv' => $modelInv
        ]);
    }

    /**
     * Lists all repair models.
     * @return mixed
     */
    public function actionIndex()
    {
        $viewType = 0;

        //RESOLVE FOR PRINTING
        if (isset($_GET['sd']) && !empty($_GET['sd']) && is_numeric($_GET['sd']) && isset($_GET['a']) && !empty($_GET['a'])){
            $modelRepair = new repair();
            switch($_GET['a']){
                case 'n':
                    $requestType = 'newEl';
                    $items = null;
                break;

                case 'c':
                    $requestType = 'closeEl';
                    $items = $modelRepair->getThisParts($_GET['sd']);
                break;

                default:
                    $requestType = null;
                break;
            }

            
            $modelRepair = $modelRepair->getAllData($_GET['sd']);
            $modelAccess = new accessories();
            $modelAccess = repair::getThisAccessAll($_GET['sd']);
        }else{
            $modelRepair = null;
            $modelAccess = null;
            $requestType = null;
            $items = null;
        }

        if (isset($_GET['list']) && is_numeric($_GET['list']) && $_GET['list']>0){
            $viewType = $_GET['list'];
        }else{
            $viewType = 0;
        }
        
        $searchModel = new SearchRepair();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $viewType);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelRepair' => $modelRepair,
            'modelAccess' => $modelAccess,
            'requestType' => $requestType,
            'items' => $items
        ]);
    }

    /**
     * Displays a single repair model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $isOk = [];
        $items = array();

        /*START MODELS*/
        $modelRepair = $this->findModel($id);
        $modelClient = new client();
        $modelStores = new stores();
        $modelBrands = new brands();
        $modelEquip = new equipaments();
        $modelModels = new models();
        $modelTypes = new repairtype();
        $modelInv = inventory::findOne($modelRepair->inve_id);
        $modelAccess = new accessories();
        $modelRepairAccess = new repairaccessory();
        $modelEquipBrand = new equipbrand();
        $modelStatus = new status();
        $modelParts = new parts();     
        $modelPartsRepair = new repairparts();     
        

        /*GET EXISTING DATA*/
        $allStores=ArrayHelper::map($modelStores->getAllStores(), 'id_store', 'storeDesc');

        $allTypes = ArrayHelper::map($modelTypes->getAllTypes(), 'id_type', 'typeDesc');

        $allAccess = ArrayHelper::map($modelAccess->getAllAccess(), 'id_accessories', 'accessDesc');

        //$allStatus = ArrayHelper::map($modelStatus->getAllStatus(),'id_status','statusDesc');
        
        $allStatus = status::find()->where(['status'=>1])->asArray()->all();

        /*SET DEFAULT DATA*/
        //stores
        $modelStores = $modelStores->findOne($modelRepair->store_id);
        //client
        $modelClient = $modelClient->findOne($modelRepair->client_id);

        //accessories
        $modelAccess = $modelRepair->getThisAccessAll($modelRepair->id_repair);
        $modelRepairAccess->otherDesc = $modelRepair->getThisOtherDesc($modelRepair->id_repair);

        //repair type
        $modelTypes = $modelTypes->findOne($modelRepair->type_id);

        //inventory
        $modelInv = $modelInv->findOne($modelRepair->inve_id);
        $modelEquip = $modelEquip->findOne($modelInv->equip_id);
        $modelBrands = $modelBrands->findOne($modelInv->brand_id);
        $modelModels = $modelModels->findOne($modelInv->model_id);

        //status
        $modelStatus = $modelStatus->findOne($modelRepair->status_id);

        //parts
        $items = $modelRepair->getThisParts($modelRepair->id_repair);

        //$modelRepair->warranty_date = strtotime($modelRepair->warranty_date);

        return $this->render('view', [
            'modelRepair' => $modelRepair,
            'modelClient' => $modelClient,
            'allStores' => $allStores,
            'allTypes' => $allTypes,
            'allAccess' => $allAccess,
            'allStatus' =>$allStatus,
            'modelStores' => $modelStores,
            'modelBrands' => $modelBrands,
            'modelEquip' => $modelEquip,
            'modelModels' => $modelModels,
            'modelTypes' => $modelTypes,
            'modelInv' => $modelInv,
            'modelAccess' => $modelAccess,
            'modelRepairAccess' => $modelRepairAccess,
            'modelStatus' => $modelStatus,
            'modelParts' => $modelParts,
            'isOk' => false,
            'items' => $items
        ]);

        /*return $this->render('view', [
            'model' => $this->findModel($id),
        ]);*/
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

        /*$allBrands = ArrayHelper::map($modelBrands->getAllBrands(), 'id_brand', 'brandName');        

        $allEquip = ArrayHelper::map($modelEquip->getAllEquip(), 'id_equip', 'equipDesc');      

        $allModels = ArrayHelper::map($modelModels->getAllModels(), 'id_model', 'modelName'); */

        $allTypes = ArrayHelper::map($modelTypes->getAllTypes(), 'id_type', 'typeDesc');

        //$allAccess = ArrayHelper::map(accessories::find()->where('accessType != :id', [':id' => '2'])->asArray()->orderBy('accessDesc ASC')->all(), 'id_accessories', 'accessDesc');
        $allAccess = ArrayHelper::map($modelAccess->getAllAccess(), 'id_accessories', 'accessDesc');

        //set defaults
        $modelStores->id_store = Yii::$app->session->get('user.store');
        $modelTypes->id_type = 1;


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

                $valid = false;
                $isOk = [];

                //validate client
                $valid = $modelClient->load(Yii::$app->request->post()) && $modelClient->validate(['cliName','cliAdress','cliDoorNum','cliPostalCode','cliPostalSuffix','cliConFix','cliConMov1','cliConMov2']);

                //equipments validation
                $valid = $modelEquip->load(Yii::$app->request->post()) && $modelEquip->validate(['equipDesc']) && $valid;
                $valid = $modelBrands->load(Yii::$app->request->post()) && $modelBrands->validate(['brandName']) && $valid;
                $valid = $modelModels->load(Yii::$app->request->post()) && $modelModels->validate(['modelName']) && $valid;

                if (Yii::$app->request->post('equipId')!="new"){
                    $modelEquip->id_equip = Yii::$app->request->post('equipId'); 
                }

                if (Yii::$app->request->post('brandId')!="new"){
                    $modelBrands->id_brand = Yii::$app->request->post('brandId');
                }

                if (Yii::$app->request->post('modelId')!='new'){
                    $modelModels->id_model = Yii::$app->request->post('modelId');
                }

                if (Yii::$app->request->post('clientDataHidden')!="new"){
                    $modelClient->id_client = Yii::$app->request->post('clientDataHidden');
                }
                

                //start dropdownlists validation
                //if equip is ok, give only the brands of that equip
                /*$validDropdowns = $modelEquip->load(Yii::$app->request->post()) && $modelEquip->validate(['id_equip']);
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
                */
                $valid = $modelInv->load(Yii::$app->request->post()) && $modelInv->validate(['inveSN']) && $valid;

                $valid = $modelTypes->load(Yii::$app->request->post()) && $modelTypes->validate(['id_type']) && $valid;

                $valid = $modelStores->load(Yii::$app->request->post()) && $modelStores->validate(['id_store']) && $valid;

                $valid = $modelRepair->load(Yii::$app->request->post()) && $modelRepair->validate(['repair_desc']) && $valid;

                if ($valid){

                    //RESOLVE INV ID's
                    if (Yii::$app->request->post('modelId')!='new' && Yii::$app->request->post('equipId')!="new" && Yii::$app->request->post('brandId')!="new"){
                        $modelEquip->id_equip = Yii::$app->request->post('equipId');
                        $modelBrands->id_brand = Yii::$app->request->post('brandId');
                        $modelModels->id_model = Yii::$app->request->post('modelId');
                    }else{
                        //add equip
                        if (Yii::$app->request->post('equipId')!="new"){
                            echo "1";
                           $modelEquip->id_equip = Yii::$app->request->post('equipId'); 
                       }else{
                            $equipArray = [
                                'id_equip' => NULL,
                                'isNewRecord' => TRUE,
                                'equipDesc' => Yii::$app->request->post('Equipaments')['equipDesc'],
                                'status' => 1
                            ];
                            $modelEquip->id_equip = $modelRepair->addModelData($modelEquip,$equipArray);
                       }


                       if (Yii::$app->request->post('brandId')!="new"){
                           $modelBrands->id_brand = Yii::$app->request->post('brandId'); 
                       }else{
                            $brandArray = [
                                'id_brand' => NULL,
                                'isNewRecord' => TRUE,
                                'brandName' => Yii::$app->request->post('Brands')['brandName'],
                                'status' => 1
                            ];
                            $modelBrands->id_brand = $modelRepair->addModelData($modelBrands,$brandArray);
                       }
                       

                        $modelArray = [
                            'id_model' => NULL,
                            'isNewRecord' => TRUE,
                            'modelName' => Yii::$app->request->post('Models')['modelName'],
                            'equip_id' => $modelEquip->id_equip,
                            'brand_id' => $modelBrands->id_brand,
                            'status' => 1
                        ];
                        $modelModels->id_model = $modelRepair->addModelData($modelModels,$modelArray);
                        
                    }
                    
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
                        return $this->redirect(['index','sd'=>$repairId,'a'=>'n']);
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

        $isOk = [];
        $items = array();

        /*START MODELS*/
        $modelRepair = $this->findModel($id);
        $modelClient = new client();
        $modelStores = new stores();
        $modelBrands = new brands();
        $modelEquip = new equipaments();
        $modelModels = new models();
        $modelTypes = new repairtype();
        $modelInv = inventory::findOne($modelRepair->inve_id);
        $modelAccess = new accessories();
        $modelRepairAccess = new repairaccessory();
        $modelEquipBrand = new equipbrand();
        $modelStatus = new status();
        $modelParts = new parts();     
        $modelPartsRepair = new repairparts();     
        

        /*GET EXISTING DATA*/
        $allStores=ArrayHelper::map($modelStores->getAllStores(), 'id_store', 'storeDesc');

        $allTypes = ArrayHelper::map($modelTypes->getAllTypes(), 'id_type', 'typeDesc');

        $allAccess = ArrayHelper::map($modelAccess->getAllAccess(), 'id_accessories', 'accessDesc');

        //$allStatus = ArrayHelper::map($modelStatus->getAllStatus(),'id_status','statusDesc');

        $allStatus = status::find()->where(['status'=>1])->andWhere(['not',['id_status'=>5]])->asArray()->all();
        

        if (isset($_POST['cancelar'])){
            return $this->goBack();
        }else if (isset($_POST['submit'])){

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                $valid = false;
                

                //validate client
                $valid = $modelClient->load(Yii::$app->request->post()) && $modelClient->validate(['cliName','cliAdress','cliDoorNum','cliPostalCode','cliPostalSuffix','cliConFix','cliConMov1','cliConMov2']);

                //equipments validation
                $valid = $modelEquip->load(Yii::$app->request->post()) && $modelEquip->validate(['equipDesc']) && $valid;
                $valid = $modelBrands->load(Yii::$app->request->post()) && $modelBrands->validate(['brandName']) && $valid;
                $valid = $modelModels->load(Yii::$app->request->post()) && $modelModels->validate(['modelName']) && $valid;

                if (Yii::$app->request->post('equipId')!="new"){
                    $modelEquip->id_equip = Yii::$app->request->post('equipId'); 
                }

                if (Yii::$app->request->post('brandId')!="new"){
                    $modelBrands->id_brand = Yii::$app->request->post('brandId');
                }

                if (Yii::$app->request->post('modelId')!='new'){
                    $modelModels->id_model = Yii::$app->request->post('modelId');
                }

                if (Yii::$app->request->post('clientDataHidden')!="new"){
                    $modelClient->id_client = Yii::$app->request->post('clientDataHidden');
                }

                $valid = $modelInv->load(Yii::$app->request->post()) && $modelInv->validate(['inveSN']) && $valid;

                $valid = $modelTypes->load(Yii::$app->request->post()) && $modelTypes->validate(['id_type']) && $valid;

                $valid = $modelStores->load(Yii::$app->request->post()) && $modelStores->validate(['id_store']) && $valid;

                $valid = $modelStatus->load(Yii::$app->request->post()) && $modelStatus->validate(['id_status']) && $valid;

                $valid = $modelRepair->load(Yii::$app->request->post()) && $modelRepair->validate(['repair_desc','budget','total']) && $valid;


                //validate parts
                if (isset($_POST['Parts'])){
                    $items=$this->getItemsToUpdate();

                    $c=0;
                    foreach($_POST['Parts'] as $i=>$part){
                        

                        if (empty($part['partDesc']) && empty($part['partCode']) && empty($part['partPrice']) && empty($part['partQuant'])){

                            continue;
                        }else{
                            $items[$c]->attributes = $part;
                            $valid = $items[$c]->validate(['partDesc','partCode','partPrice','partQuant']) && $valid;
                            $c++;
                        }
                    }
                }

                if ($valid){

                    //RESOLVE INV ID's
                    if (Yii::$app->request->post('modelId')!='new' && Yii::$app->request->post('equipId')!="new" && Yii::$app->request->post('brandId')!="new"){
                        $modelEquip->id_equip = Yii::$app->request->post('equipId');
                        $modelBrands->id_brand = Yii::$app->request->post('brandId');
                        $modelModels->id_model = Yii::$app->request->post('modelId');
                    }else{
                        //add equip
                        if (Yii::$app->request->post('equipId')!="new"){
                           $modelEquip->id_equip = Yii::$app->request->post('equipId'); 
                       }else{
                            $equipArray = [
                                'id_equip' => NULL,
                                'isNewRecord' => TRUE,
                                'equipDesc' => Yii::$app->request->post('Equipaments')['equipDesc'],
                                'status' => 1
                            ];
                            $modelEquip->id_equip = $modelRepair->addModelData($modelEquip,$equipArray);
                       }

                       if (Yii::$app->request->post('brandId')!="new"){
                           $modelBrands->id_brand = Yii::$app->request->post('brandId'); 
                       }else{
                            $brandArray = [
                                'id_brand' => NULL,
                                'isNewRecord' => TRUE,
                                'brandName' => Yii::$app->request->post('Brands')['brandName'],
                                'status' => 1
                            ];
                            $modelBrands->id_brand = $modelRepair->addModelData($modelBrands,$brandArray);
                        }


                        $modelArray = [
                            'id_model' => NULL,
                            'isNewRecord' => TRUE,
                            'modelName' => Yii::$app->request->post('Models')['modelName'],
                            'equip_id' => $modelEquip->id_equip,
                            'brand_id' => $modelBrands->id_brand,
                            'status' => 1
                        ];
                        $modelModels->id_model = $modelRepair->addModelData($modelModels,$modelArray);
                    }

                    
                    //ADD INVENTORY
                    $invArray = [
                        'id_inve' => $modelRepair->inve_id,
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
                        'id_repair' => $modelRepair->id_repair,
                        'status_id' => $modelStatus->id_status,
                        'store_id' => $modelStores->id_store,
                        'user_id' => \Yii::$app->user->getId(),
                        'type_id' => $modelTypes->id_type,
                        'client_id' => $clientId
                    ]);
                    
                    /*VALIDATE REPAIR MODEl*/
                    if ($modelRepair->save()){

                        //set repair type data
                        $modelTypes = $modelTypes->findOne($modelRepair->type_id);
  
                        //save accessories
                        if (empty(Yii::$app->request->post('Accessories')['id_accessories'])!=1){
                            repairaccessory::deleteAll(["repair_id"=>$modelRepair->id_repair]);
                            for ($accInc=0;$accInc<sizeof(Yii::$app->request->post('Accessories')['id_accessories']);$accInc++){
                                $accessArray = [];

                                if (Yii::$app->request->post('Accessories')['id_accessories'][$accInc]==3){
                                    $otherDesc = Yii::$app->request->post('RepairAccessory')['otherDesc'];
                                }else{
                                    $otherDesc = NULL;
                                }

                                

                                $accessArray = [
                                    'isNewRecord' => TRUE,
                                    'repair_id' => $modelRepair->id_repair,
                                    'accessory_id' => Yii::$app->request->post('Accessories')['id_accessories'][$accInc],
                                    'otherDesc' => $otherDesc
                                ];

                                $modelRepair->addModelData($modelRepairAccess,$accessArray);
                            }

                            //reset accessories
                            $modelAccess->id_accessories = $modelRepair->getThisAccess($modelRepair->id_repair);
                            
                        }

                        //save repair parts
                        if (isset($items) && sizeof($items)>0){ 
                            //delete all existing
                            repairparts::deleteAll(["repair_id"=>$modelRepair->id_repair]);

                            //attributes to check if it is empty
                            //$opAttr = array("id_part", "status");

                            foreach($items as $i=>$item){

                                /*foreach($item as $itemKey=>$itemList){
                                    //check if it is an empty row
                                    if ($item[$itemKey]=="" && !in_array($itemKey, $opAttr)){
                                        $isEmpty = true;
                                    }
                                }
                                // if empty row, go to next element
                                if (isset($isEmpty) && $isEmpty){
                                    continue;
                                }*/
                                
                                $partArray = [];
                                //check if part is new
                                if (isset($item->id_part) && $item->id_part!=""){
                                    $idPart = $item->id_part;
                                    $isNew = FALSE;
                                }else{
                                    $idPart = NULL;
                                    $isNew = TRUE;
                                }


                                $partArray = [
                                    'id_part' => $idPart,
                                    'isNewRecord' => $isNew,
                                    'partDesc'=>$item->partDesc,
                                    'partCode'=>$item->partCode,
                                    'partPrice'=>$item->partPrice,
                                    'partQuant' => $item->partQuant,
                                    'status' => 1,
                                ];
                               
                                //save if new
                                //update if existing
                                if ($isNew){
                                    $partAdded = $modelRepair->addModelData($modelParts,$partArray);
                                }else{
                                    $modelRepair->addModelData($modelParts,$partArray);
                                    $partAdded = $idPart;
                                }                                
                                

                                //save all parts to the repair_parts table
                                $totalPartsArray = [
                                    'isNewRecord' => TRUE,
                                    'repair_id' => $modelRepair->id_repair,
                                    'part_id' => $partAdded,
                                    'partQuant' => $item->partQuant
                                ];


                                $modelRepair->addModelData($modelPartsRepair,$totalPartsArray);
                            }


                        }

                        //commit all saves
                        echo $transaction->commit();
                        return $this->redirect(['index']);
                        //throw new Exception('STOP.');
                        
                        /*return $this->render('update', [
                            'modelRepair' => $modelRepair,
                            'modelClient' => $modelClient,
                            'allStores' => $allStores,
                            'allTypes' => $allTypes,
                            'allAccess' => $allAccess,
                            'allStatus' =>$allStatus,
                            'modelStores' => $modelStores,
                            'modelBrands' => $modelBrands,
                            'modelEquip' => $modelEquip,
                            'modelModels' => $modelModels,
                            'modelTypes' => $modelTypes,
                            'modelInv' => $modelInv,
                            'modelAccess' => $modelAccess,
                            'modelRepairAccess' => $modelRepairAccess,
                            'modelStatus' => $modelStatus,
                            'modelParts' => $modelParts,
                            'isOk' => false,
                            'items' => $items
                        ]);*/

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


            return $this->render('update', [
                'modelRepair' => $modelRepair,
                'modelClient' => $modelClient,
                'allStores' => $allStores,
                'allTypes' => $allTypes,
                'allAccess' => $allAccess,
                'allStatus' =>$allStatus,
                'modelStores' => $modelStores,
                'modelBrands' => $modelBrands,
                'modelEquip' => $modelEquip,
                'modelModels' => $modelModels,
                'modelTypes' => $modelTypes,
                'modelInv' => $modelInv,
                'modelAccess' => $modelAccess,
                'modelRepairAccess' => $modelRepairAccess,
                'modelStatus' => $modelStatus,
                'modelParts' => $modelParts,
                'isOk' => false,
                'items' => $items
            ]);
        }else{

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
            $modelEquip = $modelEquip->findOne($modelInv->equip_id);
            $modelBrands = $modelBrands->findOne($modelInv->brand_id);
            $modelModels = $modelModels->findOne($modelInv->model_id);

            //status
            $modelStatus = $modelStatus->findOne($modelRepair->status_id);

            //parts
            $items = $modelRepair->getThisParts($modelRepair->id_repair);

            //$modelRepair->warranty_date = strtotime($modelRepair->warranty_date);

        }


        return $this->render('update', [
            'modelRepair' => $modelRepair,
            'modelClient' => $modelClient,
            'allStores' => $allStores,
            'allTypes' => $allTypes,
            'allAccess' => $allAccess,
            'allStatus' =>$allStatus,
            'modelStores' => $modelStores,
            'modelBrands' => $modelBrands,
            'modelEquip' => $modelEquip,
            'modelModels' => $modelModels,
            'modelTypes' => $modelTypes,
            'modelInv' => $modelInv,
            'modelAccess' => $modelAccess,
            'modelRepairAccess' => $modelRepairAccess,
            'modelStatus' => $modelStatus,
            'modelParts' => $modelParts,
            'isOk' => false,
            'items' => $items
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

        $obj = $this->findModel($id);
        $obj->status = 0;
        $obj->save();
        return $this->redirect(['index']);
    
    }

    public function actionDelajax(){
        if (isset($_POST['list']) && $_POST['list']!=""){
            $listarray = $_POST['list'];

            //removes all projects
            foreach($listarray as $repair){
                $obj = repair::find()->where(['id_repair'=>$repair])->one();
                $obj->status = 0;
                $obj->save();
            }

            echo json_encode("done");
            
        }else{
            echo json_encode("error");
        }
    }

    public function actionSetdeliver($id)
    {
        $statusSet = Status::find()->where(['type'=>3])->orderBy("id_status DESC")->one();
        $obj = $this->findModel($id);
        $obj->status_id = $statusSet->id_status;
        $obj->date_close = date('Y-m-d H:i:s');
        $obj->save();
        return $this->redirect(['index','sd'=>$id,'a'=>'c']);
    
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
        if (in_array('repair2',$routes) && isset($_GET['list'])){
            return "activeTop";
        }else if (in_array('repair',$routes) && !isset($_GET['list'])){
            return "activeTop";
        }
        
    }

    private function getItemsToUpdate(){
        $itemsArray = array();
 
        // Iterate over each item from the submitted form
        if (isset($_POST['Parts']) && is_array($_POST['Parts'])) {
            foreach ($_POST['Parts'] as $a=>$item) {
                // If item id is available, read the record from database 
                /*if (array_key_exists('id', $item) ){
                    $items[] = MyModel::model()->findByPk($item['id']);
                }
                // Otherwise create a new record
                else {
                    
                }*/
                if (empty($item['partDesc']) && empty($item['partCode']) && empty($item['partPrice']) && empty($item['partQuant'])){
                    continue;
                }else{
                    $itemsArray[] = new parts();
                }
            }
        }
        return $itemsArray;
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string  $email the target email address
     * @return boolean whether the email was sent
     */
    public function actionCheckwarranty()
    {
        $repairs = repair::getRepairOutWarranty();

        if (sizeof($repairs)>0){

            $body = "Foi detetado que algumas reparações estão prestes a terminar a garantia de reparação nos próximos 5 dias. <br/>
            Aceda ao portal em <a href=\"http://sat.toquereservado.pt/dev/backend/web\">http://sat.toquereservado.pt/dev/backend/web</a> e verifique as reparações com os seguintes ID's (números identificadores):
                <ul>
            ";

            foreach($repairs as $row) {
                $body.='
                <li>
                    '.$row["id_repair"].'
                </li>
                ';
            }

            $body.="</ul>";

            //echo $body;       

            $to = "luisfbmelo91@gmail.com";
            $from = $to;
            $subject = "Test";

            $name='=?UTF-8?B?'.base64_encode("Teste").'?=';
            $subject='=?UTF-8?B?'.base64_encode($subject).'?=';
            $headers="From: $name <{$from}>\r\n".
                "Reply-To: {$to}\r\n".
                "MIME-Version: 1.0\r\n".
                "Content-Type: text/plain; charset=UTF-8";

            mail($to,$subject,$body,$headers);
        }
    }
}
