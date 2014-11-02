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
            [['brandName'], 'required'],
            [['brandName'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_brand' => 'Id Brand',
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
}
