<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Brands;

/**
 * SearchBrands represents the model behind the search form about `common\models\Brands`.
 */
class SearchBrands extends Brands
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_brand', 'status'], 'integer'],
            [['brandName'], 'safe'],
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
        $query = Brands::find();

        $query->andFilterWhere([
            'status' => 1
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id_brand'=>SORT_ASC]],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_brand' => $this->id_brand,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'brandName', $this->brandName]);

        return $dataProvider;
    }
}
