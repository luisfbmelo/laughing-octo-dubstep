<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "models".
 *
 * @property integer $id_model
 * @property string $modelName
 * @property integer $brand_id
 * @property integer $equip_id
 * @property integer $status
 *
 * @property Inventory[] $inventories
 * @property Brands $brand
 * @property Equipaments $equip
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
            [['modelName', 'brand_id', 'equip_id'], 'required'],
            [['modelName'], 'string'],
            [['brand_id', 'equip_id', 'status'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_model' => 'Id Model',
            'modelName' => 'Modelos',
            'brand_id' => 'Brand ID',
            'equip_id' => 'Equip ID',
            'status' => 'Status',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquip()
    {
        return $this->hasOne(Equipaments::className(), ['id_equip' => 'equip_id']);
    }

    /**
     * Returns all models
     * @return [array] [models data]
     */
    public function getAllModels(){
        return $this->find()->where('status=1')->asArray()->orderBy('modelName ASC')->all();
    }

    /**
     * Returns models of given equipment and brand
     * @param  [id] $equipId [equipment id]
     * @param  [id] $brandId [brand id]
     * @return [array]          [models data]
     */
    public function getModelsOfEqBr($equipId,$brandId){
        return $this->find()->where(['brand_id' => $brandId,'equip_id' => $equipId,'stauts'=>1])->asArray()->orderBy('modelName ASC')->all();
    }
}
