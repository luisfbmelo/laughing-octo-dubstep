<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Parts;

/**
 * SearchParts represents the model behind the search form about `common\models\Parts`.
 */
class SearchParts extends Parts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_part', 'status', 'partQuant'], 'integer'],
            [['partDesc', 'partCode'], 'safe'],
            [['partPrice'], 'number'],
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
        $query = Parts::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_part' => $this->id_part,
            'partPrice' => $this->partPrice,
            'status' => $this->status,
            'partQuant' => $this->partQuant,
        ]);

        $query->andFilterWhere(['like', 'partDesc', $this->partDesc])
            ->andFilterWhere(['like', 'partCode', $this->partCode]);

        return $dataProvider;
    }
}
