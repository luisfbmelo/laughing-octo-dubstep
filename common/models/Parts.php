<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "parts".
 *
 * @property integer $id_part
 * @property string $partDesc
 * @property string $partCode
 * @property string $partPrice
 * @property integer $status
 * @property integer $partQuant
 *
 * @property RepairParts[] $repairParts
 * @property Repair[] $repairs
 */
class Parts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['partDesc', 'partCode', 'partPrice','partQuant'], 'required'],
            [['id_part', 'status', 'partQuant'], 'integer'],
            [['partPrice'], 'number'],
            [['partDesc', 'partCode'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_part' => 'Id Part',
            'partDesc' => 'Descrição',
            'partCode' => 'Código',
            'partPrice' => 'Preço',
            'status' => 'Status',
            'partQuant' => 'Quantidade',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepairParts()
    {
        return $this->hasMany(RepairParts::className(), ['part_id' => 'id_part']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepairs()
    {
        return $this->hasMany(Repair::className(), ['id_repair' => 'repair_id'])->viaTable('repair_parts', ['part_id' => 'id_part']);
    }
}
