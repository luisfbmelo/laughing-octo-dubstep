<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use common\models\User;
use common\models\Groups;
use yii\filters\VerbFilter;


/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'email'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'email'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'logout' => ['post'],
                ],
            ],
        ];
    }

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

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $userInfo = Groups::find()->select('groups.type')->innerJoin('user','user.group_id = groups.id_group')->where(['user.id_users'=>Yii::$app->user->getId()])->one();
            $user = User::find()->where(['id_users'=>Yii::$app->user->getId()])->one();
            
            \Yii::$app->session->set('user.group',$userInfo->type);
            \Yii::$app->session->set('user.name',$user->username);
            \Yii::$app->session->set('user.store',$user->store_id);
            //return $this->goBack();
            return $this->redirect(Yii::$app->urlManager->createUrl(['repair/index']));
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }  
}
