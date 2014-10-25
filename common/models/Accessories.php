<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "accessories".
 *
 * @property integer $id_accessories
 * @property string $accessDesc
 * @property integer $accessType
 *
 * @property RepairAccessory[] $repairAccessories
 * @property Repair[] $repairs
 */
class Accessories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'accessories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['accessDesc', 'accessType'], 'required'],
            [['accessType'], 'integer'],
            [['accessDesc'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_accessories' => 'Id Accessories',
            'accessDesc' => 'Access Desc',
            'accessType' => 'Access Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepairAccessories()
    {
        return $this->hasMany(RepairAccessory::className(), ['accessory_id' => 'id_accessories']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepairs()
    {
        return $this->hasMany(Repair::className(), ['id_repair' => 'repair_id'])->viaTable('repair_accessory', ['accessory_id' => 'id_accessories']);
    }
}
