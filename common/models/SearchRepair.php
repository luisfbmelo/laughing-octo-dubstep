<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Repair;

/**
 * SearchRepair represents the model behind the search form about `common\models\Repair`.
 */
class SearchRepair extends Repair
{
    //set other modules tables
    //CLIENT
    public $client;
    public $cliContact;

    //INVENTORY
    public $equip;
    public $brand;
    public $model;
    public $sn;

    //USER
    public $username;

    //repair custom
    public $datediffRepair;
    public $datediffDeliver;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_repair', 'type_id', 'client_id', 'inve_id', 'status_id', 'user_id', 'store_id', 'priority', 'status'], 'integer'],
            //add other modules tables to safe
            [['repair_desc', 'date_entry', 'date_close', 'obs', 'client', 'cliContact', 'equip', 'brand', 'model', 'sn', 'username','status_id', 'datediffRepair', 'datediffDeliver'], 'safe'],
            [['workPrice', 'maxBudget', 'total'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params,$viewType)
    {
    
        $query = Repair::find();
        $query->select(["*, (30-DATEDIFF(NOW(),repair.date_entry)) as 'datediffRepair', (DATEDIFF(NOW(),repair.date_repaired)) as 'datediffDeliver'"]);

        //join other models tables
        $query->innerJoin('client','client.id_client = repair.client_id');
        $query->with("client");
        $query->innerJoin('inventory','repair.inve_id = inventory.id_inve');
        $query->with("inve");
        $query->innerJoin('user','user.id_users = repair.user_id');
        $query->with("user");

        $query->innerJoin('equipaments','inventory.equip_id = equipaments.id_equip');

        $query->innerJoin('brands','inventory.brand_id = brands.id_brand');
       
        $query->innerJoin('models','inventory.model_id = models.id_model');


        if (!isset($params['SearchRepair']['status_id']) || $params['SearchRepair']['status_id']!=6){
            $query->andFilterWhere(['not',['repair.status_id'=>6]]);
        }

        //FILTER ACCORDING TO VIEW TYPE
        switch($viewType){
            case 1:
                $query->andFilterWhere(['not',['repair.status_id'=>5]]);
                $query->andFilterWhere([
                    'repair.status' => 1
                ]);
                break;
            case 3:
                $query->andWhere('repair.date_entry <= Date_Sub(Now(), Interval 25 Day)');
                $query->andFilterWhere([
                    'repair.status' => 1
                ]);
                break;
            case 4:
                $query->andWhere('repair.date_repaired < Date_Sub(Now(), Interval 90 Day)');
                $query->andFilterWhere([
                    'repair.status' => 1
                ]);
                break;
            case 5:
                $query->andFilterWhere(['repair.status'=>0]);
                break;
            default:
                $query->andFilterWhere([
                    'repair.status' => 1
                ]);
                break;
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['date_entry'=>SORT_DESC]],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        //add custom repair attributes to sort
        $dataProvider->sort->attributes['datediffRepair'] = [
            'asc' => ['datediffRepair' => SORT_ASC],
            'desc' => ['datediffRepair' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['datediffDeliver'] = [
            'asc' => ['datediffDeliver' => SORT_ASC],
            'desc' => ['datediffDeliver' => SORT_DESC],
        ];

        //add cliName attributes to sort
        $dataProvider->sort->attributes['client'] = [
            'asc' => ['client.cliName' => SORT_ASC],
            'desc' => ['client.cliName' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['username'] = [
            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['equip'] = [
            'asc' => ['equipaments.equipDesc' => SORT_ASC],
            'desc' => ['equipaments.equipDesc' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['model'] = [
            'asc' => ['models.modelName' => SORT_ASC],
            'desc' => ['models.modelName' => SORT_DESC],
        ];

        //for standard gridview with no search
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        
        /*if (isset($this->date_close) && !empty($this->date_close)){
            $this->date_close = date('Y-m-d', $this->date_close);
        }*/


        /*IF A SEARCH IS DONE*/
        $query->andFilterWhere([
            'repair.id_repair' => $this->id_repair,
            'repair.type_id' => $this->type_id,
            'repair.client_id' => $this->client_id,
            'repair.inve_id' => $this->inve_id,
            'repair.status_id' => $this->status_id,
            //'repair.user_id' => $this->user_id,
            //'repair.date_entry' => $this->date_entry,
            //'repair.date_close' => $this->date_close,
            'repair.store_id' => $this->store_id,
            //'repair.priority' => $this->priority,
            //'repair.budget' => $this->budget,
            //'repair.maxBudget' => $this->maxBudget,
           // 'repair.total' => $this->total,
            'inventory.inveSN'=>$this->sn
        ]);

        $query->andFilterWhere(['like', 'repair_desc', $this->repair_desc])
        ->andFilterWhere(['like', 'obs', $this->obs])
        ->andFilterWhere(['like', 'date_entry', $this->date_entry])
        ->andFilterWhere(['like', 'date_close', $this->date_close]);

        //repair custom
        $query->andFilterWhere(['(30-DATEDIFF(NOW(),repair.date_entry))' => $this->datediffRepair]);
        $query->andFilterWhere(['(DATEDIFF(NOW(),repair.date_repaired))' => $this->datediffDeliver]);

        //search on Client data
        $query->andFilterWhere(['like', 'client.cliName', $this->client])
        ->andFilterWhere(['like', 'client.cliConFix', $this->cliContact]);

        //search on Inventory data
        $query->andFilterWhere(['like', 'equipaments.equipDesc', $this->equip])
        ->andFilterWhere(['like', 'brands.brandName', $this->brand])
        ->andFilterWhere(['like', 'models.modelName', $this->model]);

        //search on user data
        $query->andFilterWhere(['like', 'user.username', $this->username]);

        return $dataProvider;
    }
}
