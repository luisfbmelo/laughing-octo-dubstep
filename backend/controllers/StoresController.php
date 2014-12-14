<?php

namespace backend\controllers;

use Yii;
use common\models\Stores;
use common\models\StoresSearch;
use common\models\Repair;
use common\models\User;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Exception;

/**
 * StoresController implements the CRUD actions for Stores model.
 */
class StoresController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Stores models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StoresSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Stores model.
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
     * Creates a new Stores model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Stores();

        if (isset($_POST['cancelar'])){
             return $this->redirect(['index']);
        }else if (isset($_POST['add'])){
            if ($model->load(Yii::$app->request->post()) && $model->validate(['storeDesc'])) {
                $model->isNewRecord = TRUE;
                $model->id_store = NULL;
                if ($model->save(false)){
                    return $this->redirect(['index']);
                }else{
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }
                
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);

    }

    /**
     * Updates an existing Stores model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (isset($_POST['cancelar'])){
             return $this->redirect(['index']);
        }else if (isset($_POST['add'])){
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['index']);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Stores model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        $obj = $this->findModel($id);

        $existsRepair = Repair::find()->where([ 'store_id' => $obj->id_store])->exists();
        $existsUser = User::find()->where([ 'store_id' => $obj->id_store])->exists();
        if (!$existsRepair && !$existsUser){
            $obj->status = 0;
            $obj->save();
            /*Yii::$app->session->setFlash('actionSuccess','Elemento eliminado com sucesso.');*/
            return $this->redirect(['index']); 
        }else if($existsRepair){
            Yii::$app->session->setFlash('errorHasRepair','<strong>Impossível remover!</strong><br/>Esta loja está associada a uma ou mais reparações.');
            return $this->redirect(['index']); 
        }else if($existsUser){
            Yii::$app->session->setFlash('errorHasRepair','<strong>Impossível remover!</strong><br/>Esta loja está associada a um ou mais utilizadores.');
            return $this->redirect(['index']); 
        }
    }

    /**
     * Finds the Stores model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Stores the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Stores::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDelajax(){
        if (isset($_POST['list']) && $_POST['list']!=""){
            $listarray = $_POST['list'];

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                //removes all projects
                foreach($listarray as $store){
                    $existsRepair = Repair::find()->where([ 'store_id' => $store])->exists();
                    $existsUser = User::find()->where([ 'store_id' => $store])->exists();
                    if ($existsRepair){
                        throw new Exception('It has repair.');
                    }else if($existsUser){
                        throw new Exception('It has user.');
                    }else{
                        $obj = stores::find()->where(['id_store'=>$store])->one();
                        $obj->status = 0;
                        $obj->save(); 
                    }
                    
                }
                echo $transaction->commit();
                echo json_encode("done");

            }catch(Exception $e) {
                $transaction->rollback();
                //echo $e->getMessage(); exit;
                echo json_encode("error");
            }
            
        }else{
            echo json_encode("error");
        }
    }

    /**
     * Checks if the current route matches with given routes
     * @param array $routes
     * @return bool
     */
    public function isActive($routes = array())
    {
        if (in_array('stores',$routes))
        return "activeTop";
    }
}
