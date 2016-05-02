<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ankets".
 *
 * @property string $id
 */
class Questions extends \yii\db\ActiveRecord
{
    public static $table_name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return self::$table_name;
    }

    public static function setTableName($name){
        self::$table_name = $name;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [];
    }
}
