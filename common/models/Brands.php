<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "brands".
 *
 * @property integer $id_brand
 * @property string $brandName
 *
 * @property EquipBrand[] $equipBrands
 * @property Equipaments[] $equips
 * @property Inventory[] $inventories
 * @property Models[] $models
 */
class Brands extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brands';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_brand' ,'brandName'], 'required'],
            [['brandName'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_brand' => 'Marca',
            'brandName' => 'Brand Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipBrands()
    {
        return $this->hasMany(EquipBrand::className(), ['brand_id' => 'id_brand']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquips()
    {
        return $this->hasMany(Equipaments::className(), ['id_equip' => 'equip_id'])->viaTable('equip_brand', ['brand_id' => 'id_brand']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventories()
    {
        return $this->hasMany(Inventory::className(), ['brand_id' => 'id_brand']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModels()
    {
        return $this->hasMany(Models::className(), ['brand_id' => 'id_brand']);
    }

    /**
     * Returns all brands
     * @return [array] [brands data]
     */
    public function getAllBrands(){
        return $this->find()->asArray()->orderBy('brandName ASC')->all();
    }

    /**
     * Returns brands of given equipment
     * @param  [int] $equipId [equipment id]
     * @return [array]          [equipments data]
     */
    public function getBrandsOfEquip($equipId){
        return $this->find()->joinWith("equipBrands")->where(['equip_brand.equip_id' => $equipId,'status'=>1])->asArray()->orderBy('brandName ASC')->all();
    }
}
