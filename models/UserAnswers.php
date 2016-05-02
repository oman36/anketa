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
 * @property app/models/User $user
 */
class UserAnswers extends \yii\db\ActiveRecord
{
    public $anketsName;
    public $userName;
    public $userNames;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_answers';
    }

    public function getUserName(){
        if (!$this->userName) {
            $user =  $this->user_id ? User::findOne($this->user_id) : null;
            return $user ? $user->username : null;
        } else {
            return $this->userName;
        }
    }

    public function getAnketsName(){
        if (!$this->anketsName) {
            $anket = $this->ankets_id ? Ankets::findOne($this->ankets_id) : null;
            return $anket ? $anket->name : null;
        }else {
            return $this->anketsName;
        }
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
