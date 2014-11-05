<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "messages".
 *
 * @property integer $id_message
 * @property integer $user_id
 * @property integer $messPriority
 * @property string $messMessage
 * @property string $messDate
 *
 * @property UsersMessages[] $usersMessages
 * @property User[] $users
 */
class Messages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'messMessage', 'messDate'], 'required'],
            [['user_id', 'messPriority'], 'integer'],
            [['messMessage'], 'string'],
            [['messDate'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_message' => 'Id Message',
            'user_id' => 'User ID',
            'messPriority' => 'Mess Priority',
            'messMessage' => 'Mess Message',
            'messDate' => 'Mess Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersMessages()
    {
        return $this->hasMany(UsersMessages::className(), ['message_id' => 'id_message']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id_users' => 'user_id'])->viaTable('users_messages', ['message_id' => 'id_message']);
    }
}
