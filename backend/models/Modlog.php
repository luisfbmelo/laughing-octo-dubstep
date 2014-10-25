<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "modlog".
 *
 * @property integer $id_log
 * @property string $logDate
 * @property string $logMessage
 * @property integer $logType
 * @property integer $user_id
 *
 * @property Users $user
 */
class Modlog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'modlog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['logDate', 'logMessage', 'logType', 'user_id'], 'required'],
            [['logDate'], 'safe'],
            [['logMessage'], 'string'],
            [['logType', 'user_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_log' => 'Id Log',
            'logDate' => 'Log Date',
            'logMessage' => 'Log Message',
            'logType' => 'Log Type',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id_users' => 'user_id']);
    }
}
