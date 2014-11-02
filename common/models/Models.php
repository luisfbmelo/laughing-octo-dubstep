<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "models".
 *
 * @property integer $id_model
 * @property string $modelName
 * @property integer $brand_id
 *
 * @property Inventory[] $inventories
 * @property Brands $brand
 */
class Models extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'models';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['modelName', 'brand_id'], 'required'],
            [['modelName'], 'string'],
            [['brand_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_model' => 'Id Model',
            'modelName' => 'Model Name',
            'brand_id' => 'Brand ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventories()
    {
        return $this->hasMany(Inventory::className(), ['model_id' => 'id_model']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brands::className(), ['id_brand' => 'brand_id']);
    }
}
