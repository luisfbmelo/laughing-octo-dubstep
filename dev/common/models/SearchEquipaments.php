<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Equipaments;

/**
 * SearchEquipaments represents the model behind the search form about `common\models\Equipaments`.
 */
class SearchEquipaments extends Equipaments
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_equip', 'status'], 'integer'],
            [['equipDesc'], 'safe'],
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
        $query = Equipaments::find();

        $query->andFilterWhere([
            'status' => 1
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id_equip'=>SORT_ASC]],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_equip' => $this->id_equip,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'equipDesc', $this->equipDesc]);

        return $dataProvider;
    }
}
