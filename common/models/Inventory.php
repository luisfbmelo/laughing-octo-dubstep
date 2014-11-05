<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "inventory".
 *
 * @property integer $id_inve
 * @property integer $equip_id
 * @property integer $brand_id
 * @property integer $model_id
 * @property string $inveSN
 *
 * @property Brands $brand
 * @property Equipaments $equip
 * @property Models $model
 * @property Repair[] $repairs
 */
class Inventory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inventory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['equip_id', 'brand_id', 'model_id', 'inveSN'], 'required'],
            [['equip_id', 'brand_id', 'model_id'], 'integer'],
            [['inveSN'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_inve' => 'Id Inve',
            'equip_id' => 'Equip ID',
            'brand_id' => 'Brand ID',
            'model_id' => 'Model ID',
            'inveSN' => 'Número de série',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModel()
    {
        return $this->hasOne(Models::className(), ['id_model' => 'model_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepairs()
    {
        return $this->hasMany(Repair::className(), ['inve_id' => 'id_inve']);
    }
}
