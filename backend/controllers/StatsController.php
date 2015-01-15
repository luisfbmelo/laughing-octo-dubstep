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
use common\models\LoginForm;
use common\models\Groups;

use common\models\SearchRepair;


use yii\filters\AccessControl;
use yii\web\Controller;

use yii\filters\VerbFilter;

class StatsController extends Controller
{

	private $subActions = ['view','update','create'];

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
    
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionEntry(){

    	$viewType = "entry";

    	$searchModel = new SearchRepair();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $viewType);
        
        return $this->render('entry', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dates' => $this->hasDates()
        ]);
    }

    public function actionRepaired(){

    	$viewType = "repaired";

    	$searchModel = new SearchRepair();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $viewType);
        
        return $this->render('repaired', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dates' => $this->hasDates()
        ]);
    }

    public function actionDelivery(){

    	$viewType = "delivery";

    	$searchModel = new SearchRepair();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $viewType);
        
        return $this->render('delivery', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dates' => $this->hasDates()
        ]);
    }

    private function hasDates(){
    	//set default date values
    	$searchModel = new SearchRepair();
		if (isset(Yii::$app->request->queryParams['SearchRepair']['date_range'])){
		    $dates = $searchModel->getSeperateDates(urldecode(Yii::$app->request->queryParams['SearchRepair']['date_range']));
		}else{
		    $dates = [date("d-m-Y"),date("d-m-Y",strtotime("+1 month"))];
		}

		return $dates;
    }

    /**
     * Checks if the current route matches with given routes
     * @param array $routes
     * @return bool
     */
    public function isActive($routes = array())
    {
    	
        //validate first if this route exist 
        //OR
        //if that route matches the current action
        //AND
        //the current action is one of the subActions
        if (in_array(Yii::$app->controller->action->id,$routes) || (in_array(Yii::$app->session->get('lastAction'),$routes)) && in_array(Yii::$app->controller->action->id,$this->subActions)){
            return "activeTop";
        }
        
    }

}
