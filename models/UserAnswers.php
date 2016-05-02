<?php

namespace app\models;

use Yii;


/**
 * This is the model class for table "user_answers".
 *
 * @property int $user_id
 * @property string $userName
 * @property string $userNames
 * @property int $ankets_id
 * @property string $anketsName
 * @property app\models\User $user
 * @property app\models\Ankets $ankets
 */
class UserAnswers extends \yii\db\ActiveRecord
{
    public $anketsName;
    public $userName;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_answers';
    }

    public function getUser()
    {
        return $this->hasOne(User::className(),['id' => 'user_id']);
    }

    public function getAnkets()
    {
        return $this->hasOne(Ankets::className(),['id' => 'ankets_id']);
    }

    public function getUserName(){
       return $this->user->username;
    }

    public function getAnketsName(){
        return $this->ankets->name;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id','ankets_id'], 'integer'],
            [
                ['user_id','ankets_id'],
                'unique',
                'message' => 'Пользователь с таким именем уже заполнил анкету',
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'userName' => 'Пользователь',
            'anketsName' => 'Анкета',
        ];
    }
}
