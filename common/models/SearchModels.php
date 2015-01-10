<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Models;

/**
 * SearchModels represents the model behind the search form about `common\models\Models`.
 */
class SearchModels extends Models
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_model', 'brand_id', 'equip_id', 'status'], 'integer'],
            [['modelName'], 'safe'],
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
        $query = Models::find();

        $query->andFilterWhere([
            'status' => 1
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id_model'=>SORT_ASC]],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_model' => $this->id_model,
            'brand_id' => $this->brand_id,
            'equip_id' => $this->equip_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'modelName', $this->modelName]);

        return $dataProvider;
    }
}
