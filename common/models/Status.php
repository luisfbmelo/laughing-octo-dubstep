<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "status".
 *
 * @property integer $id_status
 * @property string $statusDesc
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
            [['type'], 'integer'],
            [['id_status','statusDesc'], 'required'],
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
            'id_status' => 'Estado de reparação',
            'statusDesc' => 'Descrição',
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
        return $this->find()->where(['status'=>1])->asArray()->orderBy('id_status ASC')->all();  
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
