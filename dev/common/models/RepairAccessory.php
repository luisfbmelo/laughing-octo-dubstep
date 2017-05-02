<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "repair_accessory".
 *
 * @property integer $repair_id
 * @property integer $accessory_id
 * @property string $otherDesc
 *
 * @property Accessories $accessory
 * @property Repair $repair
 */
class RepairAccessory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'repair_accessory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['repair_id', 'accessory_id'], 'required'],
            [['repair_id', 'accessory_id'], 'integer'],
            [['otherDesc'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'repair_id' => 'Repair ID',
            'accessory_id' => 'Accessory ID',
            'otherDesc' => 'Other Desc',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccessory()
    {
        return $this->hasOne(Accessories::className(), ['id_accessories' => 'accessory_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepair()
    {
        return $this->hasOne(Repair::className(), ['id_repair' => 'repair_id']);
    }
}
