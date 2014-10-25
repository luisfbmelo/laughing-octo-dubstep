<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "equipaments".
 *
 * @property integer $id_equip
 * @property string $equipDesc
 *
 * @property Inventory[] $inventories
 */
class Equipaments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'equipaments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['equipDesc'], 'required'],
            [['equipDesc'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_equip' => 'Id Equip',
            'equipDesc' => 'Equip Desc',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventories()
    {
        return $this->hasMany(Inventory::className(), ['equip_id' => 'id_equip']);
    }
}
