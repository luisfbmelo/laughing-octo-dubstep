<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "delivery".
 *
 * @property integer $id_delivery
 * @property integer $repair_id
 *
 * @property Repair $repair
 */
class Delivery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'delivery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['repair_id'], 'required'],
            [['repair_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_delivery' => 'Id Delivery',
            'repair_id' => 'Repair ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepair()
    {
        return $this->hasOne(Repair::className(), ['id_repair' => 'repair_id']);
    }
}
