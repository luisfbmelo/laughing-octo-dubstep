<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_session".
 *
 * @property integer $id_session
 * @property integer $user_id
 * @property string $hash
 *
 * @property Users $users
 */
class UserSession extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_session';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'hash'], 'required'],
            [['user_id'], 'integer'],
            [['hash'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_session' => 'Id Session',
            'user_id' => 'User ID',
            'hash' => 'Hash',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['id_users' => 'id_session']);
    }
}
