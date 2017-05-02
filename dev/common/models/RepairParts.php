<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "repair_parts".
 *
 * @property integer $repair_id
 * @property integer $part_id
 * @property integer $partQuant
 *
 * @property Parts $part
 * @property Repair $repair
 */
class RepairParts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'repair_parts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['repair_id', 'part_id', 'partQuant'], 'required'],
            [['repair_id', 'part_id', 'partQuant'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'repair_id' => 'Repair ID',
            'part_id' => 'Part ID',
            'partQuant' => 'Part Quant',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPart()
    {
        return $this->hasOne(Parts::className(), ['id_part' => 'part_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepair()
    {
        return $this->hasOne(Repair::className(), ['id_repair' => 'repair_id']);
    }
}
