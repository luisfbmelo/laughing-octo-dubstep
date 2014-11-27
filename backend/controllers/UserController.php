<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\UserSearch;
use common\models\SignupForm;
use common\models\Groups;

use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Exception;

date_default_timezone_set("Atlantic/Azores");

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        /*$model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_users]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }*/

        $model = new SignupForm();
        $modelGroups = new Groups();

        $allGroups = ArrayHelper::map($modelGroups->getAllGroups(), 'id_group', 'groupType');

        if (isset($_POST['cancelar'])){
            $this->redirect(['index']);

        }else if (isset($_POST['signup'])){

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {

                $valid = false;
                $valid = $modelGroups->load(Yii::$app->request->post()) && $modelGroups->validate(['id_group']);

                if ($model->load(Yii::$app->request->post()) && $model->validate() && $valid) {

                    $model->id_group = $modelGroups->id_group;

                    if ($user = $model->signup()) {

                        //commit all saves
                        $transaction->commit();
                        $this->redirect(['index']);
                    }else{
                        throw new Exception('Error comparing passwords1.');
                    }
                }
            }catch(Exception $e) {
                $transaction->rollback();
                echo $e->getMessage(); exit;
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelGroups' => $modelGroups,
            'allGroups' => $allGroups
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        /*LOAD MODELS*/
        $model = $this->findModel($id);
        $modelSignup = new SignupForm();
        $modelGroups = new Groups();

        /*GET ESSENCIAL CONTENT*/
        $allGroups = ArrayHelper::map($modelGroups->getAllGroups(), 'id_group', 'groupType');

        /*SET FROM OTHER MODELS*/
        $modelGroups->id_group = $model->group_id;

        if (isset($_POST['cancelar'])){
            $this->redirect(['index']);

        }else if (isset($_POST['update'])){
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {

                $currentPass = $model->password_hash;
                $valid = $modelGroups->load(Yii::$app->request->post()) && $modelGroups->validate(['id_group']);
                

                if ($model->load(Yii::$app->request->post()) && $model->validate(['username','email']) && $valid) {

                    if (!empty(Yii::$app->request->post('SignupForm')['password']) || !empty(Yii::$app->request->post('SignupForm')['password_repeat'])){
                        if ($modelSignup->load(Yii::$app->request->post()) && $modelSignup->validate(['password','password_repeat'])){
                            $model->setPassword(Yii::$app->request->post('SignupForm')['password']);
                            
                        }else{
                            throw new Exception('Error comparing passwords.');
                        }
                    }else{
                        $model->password_hash = $currentPass;
                    }

                    //set values
                    $model->group_id = $modelGroups->id_group;
                    $model->updated_at = date('Y-m-d H:i:s');
                    
                    $model->save();

                    //commit all saves
                    $transaction->commit();
                    $this->redirect(['index']);
                }

            }catch(Exception $e) {
                $transaction->rollback();
                //echo $e->getMessage(); exit;
            }
        } 

        return $this->render('update', [
            'model' => $model,
            'modelGroups' => $modelGroups,
            'allGroups' => $allGroups,
            'modelSignup' => $modelSignup
        ]);  
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        /*$this->findModel($id)->delete();*/
        $obj = $this->findModel($id);
        $obj->status = 0;
        $obj->save();

        return $this->redirect(['index']);
    }

    public function actionDelajax(){
        if (isset($_POST['list']) && $_POST['list']!=""){
            $listarray = $_POST['list'];

            //removes all projects
            foreach($listarray as $user){
                $obj = user::find()->where(['id_users'=>$user])->one();
                $obj->status = 0;
                $obj->save();
            }

            echo json_encode("done");
            
        }else{
            echo json_encode("error");
        }
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
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
        if (in_array('user',$routes))
        return "activeTop";
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
