<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "repair_type".
 *
 * @property integer $id_type
 * @property string $typeDesc
 *
 * @property Repair[] $repairs
 */
class RepairType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'repair_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['typeDesc'], 'required'],
            [['typeDesc'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_type' => 'Id Type',
            'typeDesc' => 'Type Desc',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepairs()
    {
        return $this->hasMany(Repair::className(), ['type_id' => 'id_type']);
    }
}
