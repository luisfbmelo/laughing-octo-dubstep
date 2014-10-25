<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "brands".
 *
 * @property integer $id_brand
 * @property string $brandName
 *
 * @property Inventory[] $inventories
 */
class Brands extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brands';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['brandName'], 'required'],
            [['brandName'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_brand' => 'Id Brand',
            'brandName' => 'Brand Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventories()
    {
        return $this->hasMany(Inventory::className(), ['brand_id' => 'id_brand']);
    }
}
