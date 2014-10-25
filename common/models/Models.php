<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "models".
 *
 * @property integer $id_model
 * @property string $modelName
 *
 * @property Inventory[] $inventories
 */
class Models extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'models';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['modelName'], 'required'],
            [['modelName'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_model' => 'Id Model',
            'modelName' => 'Model Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventories()
    {
        return $this->hasMany(Inventory::className(), ['model_id' => 'id_model']);
    }
}
