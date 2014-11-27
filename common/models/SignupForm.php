<?php
namespace common\models;

use common\models\User;
use yii\base\Model;
use Yii;

date_default_timezone_set("Atlantic/Azores");

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_repeat;
    public $id_group;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'O nome de utilizador já é utilizado.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Este e-mail já se encontra em utilização.'],

            [['password','password_repeat'], 'required'],
            [['password','password_repeat'], 'string', 'min' => 6],
            ['password', 'compare', 'compareAttribute'=>'password_repeat', 'message'=>"Palavras-chave não são iguais."]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Nome de utilizador',
            'password_repeat' => 'Password'
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {

        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();

            $user->role = 50;
            $user->group_id = $this->id_group;
            $user->status = 1;
            $user->created_at = date('Y-m-d H:i:s');
            $user->updated_at = date('Y-m-d H:i:s');

            $user->save();
                      
            return $user;                 
        }

        return null;
    }
}
