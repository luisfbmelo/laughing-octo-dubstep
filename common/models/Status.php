<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "status".
 *
 * @property integer $id_status
 * @property string $statusDesc
 * @property integer $status
 * @property integer $type
 * @property string $color
 *
 * @property Repair[] $repairs
 */
class Status extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['statusDesc'], 'required'],
            [['status', 'type'], 'integer'],
            [['statusDesc'], 'string', 'max' => 250],
            [['color'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_status' => 'Número de estado',
            'statusDesc' => 'Estado',
            'status' => 'Status',
            'type' => 'Tipo de estado',
            'color' => 'Cor',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepairs()
    {
        return $this->hasMany(Repair::className(), ['status_id' => 'id_status']);
    }

    public function getAllStatus(){
        return $this->find()->asArray()->orderBy('id_status ASC')->all();  
    }

    public function convertType(){
        switch($this->type){
            case 1:
                return 'Normal';
                break;
            case 2:
                return 'Por entregar';
                break;
            case 3:
                return 'Entregue';
                break;
        }
    }
}
