<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Status;

/**
 * StatusSearch represents the model behind the search form about `common\models\Status`.
 */
class StatusSearch extends Status
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_status', 'status', 'type'], 'integer'],
            [['statusDesc'], 'safe'],
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
        $query = Status::find();

        $query->andFilterWhere([
            'status' => 1
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id_status'=>SORT_ASC]],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_status' => $this->id_status,
            'status' => $this->status,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'statusDesc', $this->statusDesc]);

        return $dataProvider;
    }
}
