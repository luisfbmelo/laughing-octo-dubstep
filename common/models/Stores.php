<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stores".
 *
 * @property integer $id_store
 * @property string $storeDesc
 *
 * @property Repair[] $repairs
 */
class Stores extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stores';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['storeDesc'], 'required'],
            [['storeDesc'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_store' => 'Id Store',
            'storeDesc' => 'Loja',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepairs()
    {
        return $this->hasMany(Repair::className(), ['store_id' => 'id_store']);
    }
}
