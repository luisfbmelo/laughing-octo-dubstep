<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "users_messages".
 *
 * @property integer $user_id
 * @property integer $message_id
 * @property integer $status
 *
 * @property Messages $message
 * @property Users $user
 */
class UsersMessages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users_messages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'message_id', 'status'], 'required'],
            [['user_id', 'message_id', 'status'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'message_id' => 'Message ID',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessage()
    {
        return $this->hasOne(Messages::className(), ['id_message' => 'message_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id_users' => 'user_id']);
    }
}
