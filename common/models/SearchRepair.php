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
    public $client;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_repair', 'type_id', 'client_id', 'inve_id', 'status_id', 'user_id', 'date_close', 'store_id', 'priority', 'status'], 'integer'],
            //add other modules tables to safe
            [['repair_desc', 'date_entry', 'obs', 'client'], 'safe'],
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
        $query = Repair::find();

        //join other models tables
        $query->joinWith('client');

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

        //for standard gridview with no search
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        /*IF A SEARCH IS DONE*/
        $query->andFilterWhere([
            'repair.id_repair' => $this->id_repair,
            'repair.type_id' => $this->type_id,
            'repair.client_id' => $this->client_id,
            'repair.inve_id' => $this->inve_id,
            'repair.status_id' => $this->status_id,
            'repair.user_id' => $this->user_id,
            //'repair.date_entry' => $this->date_entry,
            'repair.date_close' => $this->date_close,
            'repair.store_id' => $this->store_id,
            'repair.priority' => $this->priority,
            'repair.budget' => $this->budget,
            'repair.maxBudget' => $this->maxBudget,
            'repair.total' => $this->total,
            'repair.status' => 1
        ]);

        $query->andFilterWhere(['like', 'repair_desc', $this->repair_desc])
            ->andFilterWhere(['like', 'obs', $this->obs])
            ->andFilterWhere(['like', 'date_entry', $this->date_entry]);

        //search on other modules tables
        $query->andFilterWhere(['like', 'client.cliName', $this->client]);

        return $dataProvider;
    }
}
