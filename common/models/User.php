<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id_users
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property integer $group_id
 * @property string $password_reset_token
 * @property integer $status
 * @property string $auth_key
 * @property integer $role
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Modlog[] $modlogs
 * @property Repair[] $repairs
 * @property Groups $group
 * @property UserSession[] $userSessions
 * @property UsersMessages[] $usersMessages
 * @property Messages[] $messages
 */
class User extends ActiveRecord implements IdentityInterface
{

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    const ROLE_USER = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password_hash', 'group_id', 'auth_key', 'role'], 'required'],
            [['group_id', 'status', 'role'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['username', 'email'], 'string', 'max' => 45]
            //[['password_hash', 'password_reset_token', 'auth_key'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_users' => 'Id Users',
            'username' => 'Nome de utilizador',
            'email' => 'Email',
            'password_hash' => 'Password Hash',
            'group_id' => 'Group ID',
            'password_reset_token' => 'Password Reset Token',
            'status' => 'Status',
            'auth_key' => 'Auth Key',
            'role' => 'Role',
            'created_at' => 'Data de criação',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModlogs()
    {
        return $this->hasMany(Modlog::className(), ['user_id' => 'id_users']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRepairs()
    {
        return $this->hasMany(Repair::className(), ['user_id' => 'id_users']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Groups::className(), ['id_group' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserSessions()
    {
        return $this->hasMany(UserSession::className(), ['user_id' => 'id_users']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersMessages()
    {
        return $this->hasMany(UsersMessages::className(), ['user_id' => 'id_users']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Messages::className(), ['id_message' => 'message_id'])->viaTable('users_messages', ['user_id' => 'id_users']);
    }

    /*FROM OLD*/
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id_users' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        //return static::findOne(['userMail' => $username, 'status' => self::STATUS_ACTIVE]);
        return static::findOne(['username' => $username,]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /*CUSTOM*/
    public function getThisGroup(){
        return Groups::find()->joinWith("users")->where(['groups.id_group'=>$this->group_id])->asArray()->one();
    }

    public function beforeSave($insert){

        /*if (parent::beforeSave($insert)) {
            $this->role = 50;
            $this->group_id = 1;
            $this->status = 1;
            $this->created_at = date('Y-m-d H:i:s');
            $this->updated_at = date('Y-m-d H:i:s');
            return true;
        } else {
            return false;
        }*/

        if ($this->isNewRecord)
        {
           
        }
     
        return parent::beforeSave($insert);
    }
}
