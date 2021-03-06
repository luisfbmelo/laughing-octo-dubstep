<?php

namespace backend\controllers;

use Yii;
use common\models\Status;
use common\models\StatusSearch;
use common\models\Repair;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Exception;
use yii\filters\AccessControl;

/**
 * StatusController implements the CRUD actions for Status model.
 */
class StatusController extends Controller
{
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
     * Lists all Status models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StatusSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Status model.
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
     * Creates a new Status model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Status();

        if (isset($_POST['cancelar'])){
             return $this->redirect(['index']);
        }else if (isset($_POST['add'])){
            if ($model->load(Yii::$app->request->post()) && $model->validate(['statusDesc','type'])) {
                $model->isNewRecord = TRUE;
                $model->id_status = NULL;
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
     * Updates an existing Status model.
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
     * Deletes an existing Status model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        /*$this->findModel($id)->delete();*/
        $obj = $this->findModel($id);

        $exists = Repair::find()->where([ 'status_id' => $obj->id_status])->exists();
        if (!$exists){
            $obj->status = 0;
            $obj->save();
            return $this->redirect(['index']); 
        }else{
            Yii::$app->session->setFlash('errorHasRepair','<strong>Impossível remover!</strong><br/>Este estado está associado a uma ou mais reparações.');
            return $this->redirect(['index']); 
        }  
    }

    public function actionDelajax(){
        if (isset($_POST['list']) && $_POST['list']!=""){
            $listarray = $_POST['list'];

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                //removes all projects
                foreach($listarray as $status){
                    $exists = Repair::find()->where([ 'status_id' => $status])->exists();
                    if ($exists){
                        throw new Exception('It has repair.');
                    }else{
                        $obj = status::find()->where(['id_status'=>$status])->one();
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
     * Finds the Status model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Status the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Status::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Checks if the current route matches with given routes
     * @param array $routes
     * @return bool
     */
    public function isActive($routes = array())
    {
        if (in_array('status',$routes))
        return "activeTop";
    }
}
