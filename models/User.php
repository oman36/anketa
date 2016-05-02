<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $role
 * @property string $auth_key
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    const REGISTRATION = 'registration';

    public $password_repeat;
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return  User::findOne($id);
    }
    /**
     * @inheritdoc
     */
    public static function findByUsername($name)
    {
        return  User::findOne(['username'=>$name]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
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
    public function validateAuthKey($auth_key)
    {
        return $this->auth_key === $auth_key;
    }

    /**
     * @param $password string
     * @return bool
     */
    public function validatePassword($password)
    {
        $md5 = md5($password);
        \yii::trace("{$this->password} === {$md5}");
        return $this->password === $md5;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    public function passValidate()
    {
        if (!$this->validatePassword($this->password_old)) {
            $this->addError('password_old', 'Неверный пароль');
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                'username',
                'unique',
                'message' => 'Пользователь с таким именем уже зарегистрирован',
                'on' => [self::REGISTRATION]
            ],
            [
                'password',
                'string',
                'min' => 4,
                'tooShort' => 'Минимальная длина пароля – 4 символа',
                'on' => [self::REGISTRATION]
            ],
            [
                'password',
                'match',
                'pattern' => '/^[^\s\t\\\\ ]+$/i', 'message' => 'Пароль не может содержать знаки пробела, табуляции, “\”',
                'on' => [self::REGISTRATION]
            ],
            [
                'password_repeat',
                'compare',
                'compareAttribute' => 'password', 'message' => 'Пароли не совпадают',
                'on' => [self::REGISTRATION]
            ],
            [
                [
                    'username',
                    'password',
                    'password_repeat'
                ],
                'required',
                'message' => 'Поле обязательно для заполнения',
                'on' => self::REGISTRATION
            ],
            [
                'username',
                'match',
                'pattern' => '/^[a-zA-Z0-9]+$/i',
                'message' => 'Пароль не может содержать знаки пробела, табуляции, “\”',
                'on' => self::REGISTRATION
            ],

            ['id', 'integer'],
            [['role','username','password'], 'string'],
        ];
    }

    public function scenarios()
    {
        return [
            self::REGISTRATION => ['username','password','password_repeat'],
            self::SCENARIO_DEFAULT  => ['username'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'password' => 'Пароль',
            'password_repeat' => 'Повторите пароль',
            'role' => 'Статус',
        ];
    }

    public function beforeSave($in)
    {
        $md5 = md5($this->password);
        $this->password = $md5;
        return parent::beforeSave($in);
    }
}
