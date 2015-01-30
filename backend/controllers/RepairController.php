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
use common\models\Delivery;

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

    private $customErrorMessages = [
                "noEquip" => "Não existe. Procure um já existente na lista ao escrever ou marque como novo.",
                "noBrand" => "Não existe. Procure uma já existente na lista ao escrever ou marque como nova."
            ];

    private $subActions = ['view','update','create'];

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
                    // allow unauthenticated users
                    [
                        'allow' => true,
                        'actions' => ['checkwarranty','pickuptime'],
                        'roles' => ['?'],
                    ],

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
/*
    public function beforeAction($event)
    {

        if (parent::beforeAction($event)) {
            echo \Yii::$app->session->get('lastAction');
            return true;
        } else {
            return false;
        }
    }*/

    /**
     * Set the latest action origin in order to set the correct track
     * @param  [type] $event  [description]
     * @param  [type] $result [description]
     * @return [type]         [description]
     */
    public function afterAction($event, $result)
    {
         
        if (!in_array(\Yii::$app->session->get('lastAction'),$this->subActions) && !in_array(Yii::$app->controller->action->id, $this->subActions)){
            \Yii::$app->session->set('lastAction',Yii::$app->controller->action->id);
        }
        
        return $result;

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
        $viewType = null;

        //RESOLVE FOR PRINTING
        if (isset($_GET['sd']) && !empty($_GET['sd']) && is_numeric($_GET['sd']) && isset($_GET['a']) && !empty($_GET['a'])){
            $modelRepair = new repair();
            switch($_GET['a']){
                //new repair
                case 'n':
                    $requestType = 'newEl';
                    $items = null;
                break;

                //delivered repair
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
     * List all repairs with total price
     */
    public function actionFastsearch(){
        $viewType = "fastsearch";

        
        $searchModel = new SearchRepair();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $viewType);

        return $this->render('fastsearch', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * List all repairs that are pending
     */
    public function actionPending(){
        $viewType = "pending";

        
        $searchModel = new SearchRepair();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $viewType);

        return $this->render('pending', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * List all repairs that were deleted
     */
    public function actionDeleted(){
        $viewType = "deleted";

        
        $searchModel = new SearchRepair();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $viewType);

        return $this->render('deleted', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
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

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {

                $valid = false;
                $isOk = [];
                $invNewItem = [];

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

                //check if inventory is new or not
                if (null == Yii::$app->request->post('equipNew') && Yii::$app->request->post('equipId')=='new'){
                    $modelEquip->addError("equipDesc", $this->customErrorMessages['noEquip']);
                    $valid = false;
                }else if (Yii::$app->request->post('equipId')=='new'){
                    $invNewItem['equip'] = 1;
                }

                if (null == Yii::$app->request->post('brandNew')  && Yii::$app->request->post('brandId')=='new'){
                    $modelBrands->addError("brandName", $this->customErrorMessages['noBrand']);
                    $valid = false;
                }else if (Yii::$app->request->post('brandId')=='new'){
                    $invNewItem['brand'] = 1;
                }

                //SET ACCESSORIES IF THEY EXIST TO SHOW ON ERRORS
                if (empty(Yii::$app->request->post('Accessories')['id_accessories'])!=1){
                    $accessArray = [];

                    for ($accInc=0;$accInc<sizeof(Yii::$app->request->post('Accessories')['id_accessories']);$accInc++){

                        if (Yii::$app->request->post('Accessories')['id_accessories'][$accInc]==3){
                            $modelRepairAccess->otherDesc = Yii::$app->request->post('RepairAccessory')['otherDesc'];
                        }else{
                            //$modelRepairAccess->otherDesc = NULL;
                        }

                        $accessArray[$accInc] = Yii::$app->request->post('Accessories')['id_accessories'][$accInc];
                    }

                    $modelAccess->id_accessories = $accessArray;
                }

                if ($valid){

                    //RESOLVE INV ID's
                    if (Yii::$app->request->post('modelId')!='new' && Yii::$app->request->post('equipId')!="new" && Yii::$app->request->post('brandId')!="new" && null == Yii::$app->request->post('equipNew') && null == Yii::$app->request->post('brandNew')){
                        $modelEquip->id_equip = Yii::$app->request->post('equipId');
                        $modelBrands->id_brand = Yii::$app->request->post('brandId');
                        $modelModels->id_model = Yii::$app->request->post('modelId');
                    }else{
                        $noModel = false;

                        //add equip
                        if (Yii::$app->request->post('equipId')!="new" && null == Yii::$app->request->post('equipNew')){
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


                        if (Yii::$app->request->post('brandId')!="new" && null == Yii::$app->request->post('brandNew')){
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
                'isOk' => $isOk,
                'invNewItem' => $invNewItem
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
            'isOk' => false,
            'invNewItem' => false
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

    /**
     * Get all models from given equipment and brand
     * @return [json] [all models of that equipment and brand]
     */
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

        $allStatus = status::find()->where(['status'=>1])->andWhere(['not',['id_status'=>6]])->asArray()->all();
        

        if (isset($_POST['cancelar'])){
            return $this->goBack();
        }else if (isset($_POST['submit'])){

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                $valid = false;
                $invNewItem = [];               
                

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

                //check if inventory is new or not
                if (null == Yii::$app->request->post('equipNew') && Yii::$app->request->post('equipId')=='new'){
                    $modelEquip->addError("equipDesc", $this->customErrorMessages['noEquip']);
                    $valid = false;
                }else if (Yii::$app->request->post('equipId')=='new'){
                    $invNewItem['equip'] = 1;
                }

                if (null == Yii::$app->request->post('brandNew')  && Yii::$app->request->post('brandId')=='new'){
                    $modelBrands->addError("brandName", $this->customErrorMessages['noBrand']);
                    $valid = false;
                }else if (Yii::$app->request->post('brandId')=='new'){
                    $invNewItem['brand'] = 1;
                }


                //SET ACCESSORIES IF THEY EXIST TO SHOW ON ERRORS
                if (empty(Yii::$app->request->post('Accessories')['id_accessories'])!=1){
                    $accessArray = [];

                    for ($accInc=0;$accInc<sizeof(Yii::$app->request->post('Accessories')['id_accessories']);$accInc++){

                        if (Yii::$app->request->post('Accessories')['id_accessories'][$accInc]==3){
                            $modelRepairAccess->otherDesc = Yii::$app->request->post('RepairAccessory')['otherDesc'];
                        }else{
                            //$modelRepairAccess->otherDesc = NULL;
                        }

                        $accessArray[$accInc] = Yii::$app->request->post('Accessories')['id_accessories'][$accInc];
                    }

                    $modelAccess->id_accessories = $accessArray;
                }


                

                if ($valid){

                    //RESOLVE INV ID's
                    if (Yii::$app->request->post('modelId')!='new' && Yii::$app->request->post('equipId')!="new" && Yii::$app->request->post('brandId')!="new" && null == Yii::$app->request->post('equipNew') && null == Yii::$app->request->post('brandNew')){
                        $modelEquip->id_equip = Yii::$app->request->post('equipId');
                        $modelBrands->id_brand = Yii::$app->request->post('brandId');
                        $modelModels->id_model = Yii::$app->request->post('modelId');
                    }else{
                        //add equip
                        if (Yii::$app->request->post('equipId')!="new" && null == Yii::$app->request->post('equipNew')){
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

                       if (Yii::$app->request->post('brandId')!="new" && null == Yii::$app->request->post('brandNew')){
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
                    //set repaired date if it is repaired
                    if ($modelStatus->id_status == 5){
                        $repairedDate = date('Y-m-d H:i:s');
                    }else{
                        $repairedDate = NULL;
                    }
                    
                    $modelRepair->attributeToRepair([
                        'id_repair' => $modelRepair->id_repair,
                        'status_id' => $modelStatus->id_status,
                        'store_id' => $modelStores->id_store,
                        'user_id' => \Yii::$app->user->getId(),
                        'type_id' => $modelTypes->id_type,
                        'client_id' => $clientId,
                        'date_repaired' => $repairedDate
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
                        //return $this->redirect(['index']);
                        //throw new Exception('STOP.');
                        
                        
                        return $this->redirect(['view', "id"=>$modelRepair->id_repair]);

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
                'items' => $items,
                'invNewItem' => $invNewItem
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

            if ($modelStatus->id_status==6){
                $allStatus = status::find()->where(['status'=>1])->asArray()->all();
            }

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
            'items' => $items,
            'invNewItem' => false
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

    /**
     * Delete repair with ajax request
     * @return json request result message
     */
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


    /**
     * Sets the repair as delivered
     * @param  int $id repair identifier
     * @return null     redirects to the index and prints element deliver sheet
     */
    public function actionSetdeliver($id)
    {
        //SET DELIVERED
        $statusSet = Status::find()->where(['type'=>3])->orderBy("id_status DESC")->one();
        $obj = $this->findModel($id);
        $obj->status_id = $statusSet->id_status;
        $obj->date_close = date('Y-m-d H:i:s');
        $obj->save();

        //GET DELIVERY ID
        $obj = Delivery::find()->where(['repair_id'=>$id])->one();

        if ($obj) $obj->delete();

        $delivery = new Delivery();
        $delivery->repair_id = $id;
        $delivery->save();

        return $this->redirect(['index','sd'=>$id,'a'=>'c']);
    
    }

    /**
     * Set a deleted repair as active again
     * @param  int $id repair identifier
     * @return null     returns to previous page
     */
    public function actionRecover($id)
    {
        $obj = $this->findModel($id);
        $obj->status = 1;
        $obj->save();
        return $this->goBack();
    
    }

    /**
     * Recover repair with ajax request
     * @return json request result message
     */
    public function actionRecoverajax(){
        if (isset($_POST['list']) && $_POST['list']!=""){
            $listarray = $_POST['list'];

            //removes all projects
            foreach($listarray as $repair){
                $obj = repair::find()->where(['id_repair'=>$repair])->one();
                $obj->status = 1;
                $obj->save();
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

        //validate first if this route exist
        //then validates if that route matches the current action
        //AND
        //the current action is one of the subActions
        if (in_array(Yii::$app->controller->action->id,$routes) || (in_array(Yii::$app->session->get('lastAction'),$routes)) && in_array(Yii::$app->controller->action->id,$this->subActions)){
            return "activeTop";
        }
        
    }

    /**
     * Set a model for each part of a repair
     * @return array all models to use
     */
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
     * Sends an email when there are repairs that will have their warranty finished in the next 5 days.
     */
    public function actionCheckwarranty()
    {
        $repairs = new Repair();
        $repairs = $repairs->getRepairOutWarranty();

        if (sizeof($repairs)>0){

            $body = "Foi detetado que algumas reparações estão prestes a terminar a garantia nos próximos <b>5 dias</b>. <br/><br/>
            Aceda ao portal em <a href=\"http://sat.toquereservado.pt/backend/web/warning/warranty\">www.sat.toquereservado.pt</a> para identificar e resolver o problema das seguintes reparações:
                <br/>
                <ul>
            ";

            foreach($repairs as $row) {
                $body.='
                <li>
                    <a href="http://sat.toquereservado.pt/backend/web/warning/warranty?SearchRepair%5Bid_repair%5D='.$row["id_repair"].'&SearchRepair%5Bstore_id%5D=&SearchRepair%5Bequip%5D=&SearchRepair%5Bmodel%5D=&SearchRepair%5Brepair_desc%5D=&SearchRepair%5Bclient%5D=&SearchRepair%5Bdate_entry%5D=&SearchRepair%5Bdatediff%5D=">'.$row["id_repair"].'</a>
                </li>
                ';
            }

            $body.="</ul>";

            //echo $body;       

            $to = \Yii::$app->params["adminEmail"].",luisfbmelo91@gmail.com";
            $from = \Yii::$app->params["adminEmail"];
            $subject = "Garantia a expirar";

            $name='=?UTF-8?B?'.base64_encode("Sistema de Gestão de ToqueReservado").'?=';
            $subject='=?UTF-8?B?'.base64_encode($subject).'?=';
            $headers="From: $name <{$from}>\r\n".
                "Reply-To: {$to}\r\n".
                "MIME-Version: 1.0\r\n".
                "Content-Type: text/html; charset=UTF-8";

            mail($to,$subject,$body,$headers);
        }
    }

    /**
     * Sends and e-mail when a repair is taking more than 90 days to pickup
     */
    public function actionPickuptime()
    {
        $repairs = new Repair();
        $repairs = $repairs->getRepairPickup();

        if (sizeof($repairs)>0){

            $body = "Existem equipamentos que não foram levantados pelo cliente após <b>90 dias</b>. <br/><br/>
            Aceda ao portal em <a href=\"http://sat.toquereservado.pt/backend/web/warning/pickup\">www.sat.toquereservado.pt</a> para identificar e resolver o problema das seguintes reparações:
            <br/>
                <ul>
            ";

            foreach($repairs as $row) {
                $body.='
                <li>
                    <a href="http://sat.toquereservado.pt/backend/web/warning/pickup?SearchRepair%5Bid_repair%5D='.$row["id_repair"].'&SearchRepair%5Bstore_id%5D=&SearchRepair%5Bequip%5D=&SearchRepair%5Bmodel%5D=&SearchRepair%5Brepair_desc%5D=&SearchRepair%5Bclient%5D=&SearchRepair%5Bdate_entry%5D=&SearchRepair%5Bdatediff%5D=">'.$row["id_repair"].'</a>
                </li>
                ';
            }

            $body.="</ul>";

            //echo $body;       

            $to = \Yii::$app->params["adminEmail"].",luisfbmelo91@gmail.com";
            $from = \Yii::$app->params["adminEmail"];
            $subject = "Equipamentos por levantar";

            $name='=?UTF-8?B?'.base64_encode("Sistema de Gestão de ToqueReservado").'?=';
            $subject='=?UTF-8?B?'.base64_encode($subject).'?=';
            $headers="From: $name <{$from}>\r\n".
                "Reply-To: {$to}\r\n".
                "MIME-Version: 1.0\r\n".
                "Content-Type: text/html; charset=UTF-8";

            mail($to,$subject,$body,$headers);
        }
    }

    /**
     * Lists all repair models.
     * @return mixed
     */
    public function actionTest()
    {

        
        $model = repair::find()->where(['id_repair'=>2])->one();

        return $this->render('test', [
            'modelRepair' => $model
        ]);
    }
}
