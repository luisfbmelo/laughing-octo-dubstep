<?php

namespace backend\controllers;

use Yii;
use common\models\Models;
use common\models\SearchModels;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ModelsController implements the CRUD actions for models model.
 */
class ModelsController extends Controller
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
     * Lists all models models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchModels();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single models model.
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
     * Creates a new models model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new models();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_model]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing models model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_model]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing models model.
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

        /*if (!$existsInv){
            $obj->status = 0;
            $obj->save();
            return $this->redirect(['index']); 
        }else{
            Yii::$app->session->setFlash('errorHasRepair','<strong>Impossível remover!</strong><br/>Este equipamento está associada a uma ou mais reparações.');
            return $this->redirect(['index']); 
        }*/
    }

    public function actionDelajax(){
        if (isset($_POST['list']) && $_POST['list']!=""){
            $listarray = $_POST['list'];

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                //removes all projects
                foreach($listarray as $model){
                    $obj = models::find()->where(['id_model'=>$model])->one();
                    $obj->status = 0;
                    $obj->save(); 
                    
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
     * Finds the models model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return models the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = models::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAllmodels(){
        
        $data = models::find()->innerJoinWith(['brand','equip'])->where('models.modelName LIKE CONCAT(\'%\',:stringSearch,\'%\') AND models.status = 1', ['stringSearch'=>$_GET['term']])->asArray()->orderBy('models.modelName ASC')->all();
        $retrieve = [];
        foreach ($data as $content){
            $retrieve[$content['id_model']]['id'] = $content['id_model'];
            $retrieve[$content['id_model']]['modelName'] = $content['modelName'];
            $retrieve[$content['id_model']]['value'] = $content['modelName'];
            $retrieve[$content['id_model']]['equipId'] = $content['equip_id'];
            $retrieve[$content['id_model']]['equipName'] = $content['equip']['equipDesc'];
            $retrieve[$content['id_model']]['brandId'] = $content['brand_id'];
            $retrieve[$content['id_model']]['brandName'] = $content['brand']['brandName'];

        }
        return json_encode($retrieve); 
    }

    /**
     * Checks if the current route matches with given routes
     * @param array $routes
     * @return bool
     */
    public function isActive($routes = array())
    {
        if (in_array('models',$routes))
        return "activeTop";
    }
}
