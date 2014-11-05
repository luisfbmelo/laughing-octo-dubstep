<?php

namespace common\models;

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
            [['id_type','typeDesc'], 'required'],
            [['typeDesc'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_type' => 'Tipo de reparação',
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

    /**
     * Returns all repair types
     * @return [array] [types data]
     */
    public function getAllTypes(){
        return $this->find()->asArray()->orderBy('typeDesc ASC')->all();
    }
}
