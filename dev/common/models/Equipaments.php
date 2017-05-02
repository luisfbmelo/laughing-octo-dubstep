<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "equipaments".
 *
 * @property integer $id_equip
 * @property string $equipDesc
 *
 * @property EquipBrand[] $equipBrands
 * @property Brands[] $brands
 * @property Inventory[] $inventories
 * @property Models[] $models
 */
class Equipaments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'equipaments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['equipDesc'], 'required'],
            [['equipDesc'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_equip' => 'Equipamento',
            'equipDesc' => 'Equipamentos',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipBrands()
    {
        return $this->hasMany(EquipBrand::className(), ['equip_id' => 'id_equip']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrands()
    {
        return $this->hasMany(Brands::className(), ['id_brand' => 'brand_id'])->viaTable('equip_brand', ['equip_id' => 'id_equip']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventories()
    {
        return $this->hasMany(Inventory::className(), ['equip_id' => 'id_equip']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModels()
    {
        return $this->hasMany(Models::className(), ['equip_id' => 'id_equip']);
    }

    /**
     * Returns all equipments
     * @return [array] [equipments data]
     */
    public function getAllEquip(){
        return $this->find()->where('status=1')->asArray()->orderBy('equipDesc ASC')->all();  
    }
}
