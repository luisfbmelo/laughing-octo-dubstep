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
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_repair', 'type_id', 'client_id', 'inve_id', 'status_id', 'user_id', 'date_close', 'store_id', 'priority', 'status'], 'integer'],
            [['repair_desc', 'date_entry', 'obs'], 'safe'],
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

        

        $query->andFilterWhere([
            'id_repair' => $this->id_repair,
            'type_id' => $this->type_id,
            'client_id' => $this->client_id,
            'inve_id' => $this->inve_id,
            'status_id' => $this->status_id,
            'user_id' => $this->user_id,
            'date_entry' => $this->date_entry,
            'date_close' => $this->date_close,
            'store_id' => $this->store_id,
            'priority' => $this->priority,
            'budget' => $this->budget,
            'maxBudget' => $this->maxBudget,
            'total' => $this->total,
            'status' => 1,
        ]);

        $query->andFilterWhere(['like', 'repair_desc', $this->repair_desc])
            ->andFilterWhere(['like', 'obs', $this->obs]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
           
            'sort'=> ['defaultOrder' => ['date_entry'=>SORT_DESC]],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        return $dataProvider;
    }
}
