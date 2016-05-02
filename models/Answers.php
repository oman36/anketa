<?php

namespace app\models;

use Yii;


/**
 * This is the model class for table "ankets".
 *
 * @property string $id
 * @property string $user_id
 */
class Answers extends \yii\db\ActiveRecord
{
    public static $table_name;
    public $questions;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return self::$table_name;
    }

    /**
     * Выбираем с какой таблицей работать
     * @param string $name
     */
    public static function setTableName($name){
        self::$table_name = $name;
    }

    public function getUsername(){
        return $this->user_id ? User::findOne($this->user_id)->username : 'anonymous';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [array_keys($this->getFields()),'string']
        ];
    }

    /**
     * Возвращает массив содержащий названия столбцов с ответами
     * @return array
     */
    public function getFields() {
        $fields = $this->getAttributes();
        unset($fields['id']);
        unset($fields['user_id']);
        return $fields;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        // если еще не запрашивали лейблы
        if (!$this->questions) {
            $this->questions = [];
            //answer_<имя> в questions_<имя>
            Questions::setTableName(
                preg_replace('/answers_/ui','questions_',self::$table_name)
            );

            $questions = Questions::find()
                ->asArray()
                ->select(['column_name', 'question_text'])
                ->all();

            foreach ($questions as $question) {
                $this->questions[$question['column_name']] = $question['question_text'];
            }
        }
        return $this->questions;
    }
}
