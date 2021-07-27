<?php

namespace app\models;

use yii\base\BaseObject;
use yii\base\Model;
use Yii;


/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $login
 * @property string $password
 * @property string $username
 */
class SignupForm extends Model
{

    public $login;
    public $password;
    public $password2;
    public $username;
    public $auth_key;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'login', 'password'], 'filter', 'filter' => 'trim'],
            [['username', 'password', 'password2', 'login'], 'required'],
            [['username', 'password', 'password2', 'login'], 'string', 'max' => 35],
            ['username', 'string', 'min' => 2, 'max' => 35],
            [['password', 'password2'],  'string', 'min' => 4, 'max' => 35],
            ['password2', 'compare', 'compareAttribute'=>'password', 'message' => 'Пароли должны совпадать.'],
            ['password', 'match', 'pattern' => '/[a-z0-9]\w*$/i', 'message' => 'Пароль должен содежрать только латинские буквы и цифры.'],
            ['username', 'unique', 'targetClass' => User::className(), 'message' => 'Это имя уже занято.'],

        ];
    }

//    public function rules()
//    {
//        return [
//            [['password', 'login'], 'required'],
//            [['password','login'], 'string', 'max' => 35],
//            ['login', 'unique', 'targetClass' => User::className(),  'message' => 'Этот логин уже занят'],
//        ];
//    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Логин',
            'password' => 'Пароль',
            'password2' => 'Подтвердите пароль',
            'username' => 'Имя',
            'status' => 'Статус',
            'role' => 'Роль',
        ];
    }

    public function reg()
    {
        $user = new User();
        $user->username = $this->username;
        $user->login = $this->login;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->status = 10;
        $user->role = 'user';
        return $user->save() ? $user : null;
    }
}
