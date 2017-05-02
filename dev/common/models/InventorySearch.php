<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Inventory;

/**
 * InventorySearch represents the model behind the search form about `common\models\Inventory`.
 */
class InventorySearch extends Inventory
{
    public $equipName;
    public $brandName;
    public $modelName;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_inve', 'equip_id', 'brand_id', 'model_id', 'status'], 'integer'],

            //add other modules tables to safe
            [['equipName','brandName','modelName','inveSN'], 'safe'],
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
        $query = Inventory::find();

        //join other models tables        
        $query->innerJoin('equipaments','equipaments.id_equip = inventory.equip_id');
        $query->with("equip");

        $query->innerJoin('brands','inventory.brand_id = brands.id_brand');
        $query->with("brand");
       
        $query->innerJoin('models','inventory.model_id = models.id_model');
        $query->with("model");

        $query->innerJoin('repair','repair.inve_id = inventory.id_inve');
        $query->with("repairs");


        

        $query->andFilterWhere([
            'repair.status' => 1
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id_inve'=>SORT_DESC]],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        //add attributes to sort
        $dataProvider->sort->attributes['equipName'] = [
            'asc' => ['equipaments.equipDesc' => SORT_ASC],
            'desc' => ['equipaments.equipDesc' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['brandName'] = [
            'asc' => ['brands.brandName' => SORT_ASC],
            'desc' => ['brands.brandName' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['modelName'] = [
            'asc' => ['models.modelName' => SORT_ASC],
            'desc' => ['models.modelName' => SORT_DESC],
        ];


        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_inve' => $this->id_inve,
            'equip_id' => $this->equip_id,
            'brand_id' => $this->brand_id,
            'model_id' => $this->model_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'inveSN', $this->inveSN]);

        //search on Inventory data
        $query->andFilterWhere(['like', 'equipaments.equipDesc', $this->equipName])
        ->andFilterWhere(['like', 'brands.brandName', $this->brandName])
        ->andFilterWhere(['like', 'models.modelName', $this->modelName]);

        return $dataProvider;
    }
}
