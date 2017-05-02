<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "equip_brand".
 *
 * @property integer $equip_id
 * @property integer $brand_id
 *
 * @property Brands $brand
 * @property Equipaments $equip
 */
class EquipBrand extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'equip_brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['equip_id', 'brand_id'], 'required'],
            [['equip_id', 'brand_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'equip_id' => 'Equip ID',
            'brand_id' => 'Brand ID',
        ];
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
}
