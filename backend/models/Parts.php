<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parts".
 *
 * @property integer $id_part
 * @property string $partDesc
 * @property string $partDoce
 * @property string $partPrice
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
            [['id_part', 'partDesc', 'partDoce', 'partPrice'], 'required'],
            [['id_part'], 'integer'],
            [['partPrice'], 'number'],
            [['partDesc'], 'string', 'max' => 45],
            [['partDoce'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_part' => 'Id Part',
            'partDesc' => 'Part Desc',
            'partDoce' => 'Part Doce',
            'partPrice' => 'Part Price',
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
