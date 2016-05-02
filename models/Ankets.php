<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ankets".
 *
 * @property int $id
 * @property string $table_name
 * @property int $user_id
 * @property string $name
 */
class Ankets extends \yii\db\ActiveRecord
{
    public $questions;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ankets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['table_name', 'name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [
                'table_name',
                'match',
                'pattern' => '/^[a-zA-Z0-9]+$/i',
                'message' => 'Поле может содержать только символы наборов: a-z, A-Z, 0-9',

            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'table_name' => 'Краткое название анкеты на латинице',
            'name' => 'Полное название анкеты',
            'questions' => 'Вопросы',
        ];
    }

    public static function getParamsByName($table_name)
    {
        $name = Ankets::find()
            ->asArray()
            ->where(['table_name' => $table_name])
            ->one();
        return $name;
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $db = Yii::$app->db;
            $transaction = $db->beginTransaction();

            try {;
                $questionsTableName = "questions_{$this->table_name}";

                $db->createCommand()->createTable(
                    $questionsTableName,
                    [
                       'id' => 'pk',
                       'column_name' => 'string',
                       'question_text' => 'string',
                    ]
                )->execute();

                $answerFields = [
                    'user_id' => 'pk',
                ];


                $length = sizeof($this->questions);
                for($i = 1; $i <= $length; $i++) {
                    $colName = "q{$i}";
                    $answerFields[$colName] = 'string';
                    $db->createCommand()->insert($questionsTableName, [
                        'column_name' => $colName,
                        'question_text' => $this->questions[$i-1],
                    ])->execute();
                }

                $db->createCommand()->createTable(
                    "answers_{$this->table_name}",
                    $answerFields
                )->execute();

                $transaction->commit();

            } catch(\Exception $e) {
                Yii::trace('error');
                $transaction->rollBack();
                throw $e;
            }
            return true;
        }
        return false;
    }
}
