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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_repair', 'type_id', 'client_id', 'inve_id', 'status_id', 'user_id', 'date_close', 'store_id', 'priority', 'status'], 'integer'],
            //add other modules tables to safe
            [['repair_desc', 'date_entry', 'date_close', 'obs', 'client', 'cliContact', 'equip', 'brand', 'model', 'sn'], 'safe'],
            [['budget', 'maxBudget', 'total'], 'number'],
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
    public function search($params)
    {
        //transform date if is submited
        if (isset($params['SearchRepair']['date_entry']) && !empty($params['SearchRepair']['date_entry'])){
            $params['SearchRepair']['date_entry'] = date('Y-m-d', $params['SearchRepair']['date_entry']);
        }


        $query = Repair::find();

        //join other models tables
        $query->innerJoin('client','client.id_client = repair.client_id');
        $query->with("client");
        $query->innerJoin('inventory','repair.inve_id = inventory.id_inve');
        $query->with("inve");

        $query->innerJoin('equipaments','inventory.equip_id = equipaments.id_equip');

        $query->innerJoin('brands','inventory.brand_id = brands.id_brand');
       
        $query->innerJoin('models','inventory.model_id = models.id_model');


        $query->andFilterWhere([
            'repair.status' => 1
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['date_entry'=>SORT_DESC]],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        //add cliName attributes to sort
        $dataProvider->sort->attributes['client'] = [
            'asc' => ['client.cliName' => SORT_ASC],
            'desc' => ['client.cliName' => SORT_DESC],
        ];


        //for standard gridview with no search
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        if (isset($this->date_close) && !empty($this->date_close)){
            $this->date_close = date('Y-m-d', $this->date_close);
        }


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
            'repair.status' => 1,
            'inventory.inveSN'=>$this->sn
        ]);

        $query->andFilterWhere(['like', 'repair_desc', $this->repair_desc])
        ->andFilterWhere(['like', 'obs', $this->obs])
        ->andFilterWhere(['like', 'date_entry', $this->date_entry])
        ->andFilterWhere(['like', 'date_close', $this->date_close]);

        //search on Client data
        $query->andFilterWhere(['like', 'client.cliName', $this->client])
        ->andFilterWhere(['like', 'client.cliConFix', $this->cliContact]);

        //search on Inventory data
        $query->andFilterWhere(['like', 'equipaments.equipDesc', $this->equip])
        ->andFilterWhere(['like', 'brands.brandName', $this->brand])
        ->andFilterWhere(['like', 'models.modelName', $this->model]);

        return $dataProvider;
    }
}
