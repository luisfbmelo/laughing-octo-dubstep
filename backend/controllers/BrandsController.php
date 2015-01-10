<?php

namespace backend\controllers;

use Yii;
use common\models\Brands;
use common\models\SearchBrands;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BrandsController implements the CRUD actions for brands model.
 */
class BrandsController extends Controller
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
     * Lists all brands models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchBrands();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single brands model.
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
     * Creates a new brands model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new brands();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_brand]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing brands model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_brand]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing brands model.
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
                foreach($listarray as $brand){
                    $obj = brands::find()->where(['id_brand'=>$brand])->one();
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
     * Finds the brands model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return brands the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = brands::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAllbrands(){
        
        $data = brands::find()->where('brandName LIKE CONCAT(\'%\',:stringSearch,\'%\') AND status = 1', ['stringSearch'=>$_GET['term']])->asArray()->orderBy('brandName ASC')->all();
        $retrieve = [];
        foreach ($data as $content){
            $retrieve[$content['id_brand']]['id'] = $content['id_brand'];
            $retrieve[$content['id_brand']]['brandName'] = $content['brandName'];
            $retrieve[$content['id_brand']]['value'] = $content['brandName'];


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
        if (in_array('brands',$routes))
        return "activeTop";
    }
}
