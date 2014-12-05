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
            [['id_store','storeDesc'], 'required'],
            [['storeDesc'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_store' => 'Loja',
            'storeDesc' => 'Nome da loja',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepairs()
    {
        return $this->hasMany(Repair::className(), ['store_id' => 'id_store']);
    }

    /**
     * Returns all stores
     * @return [array] [stores data]
     */
    public function getAllStores(){
        return $this->find()->where(['status'=>1])->asArray()->orderBy('storeDesc ASC')->all();  
    }
}
