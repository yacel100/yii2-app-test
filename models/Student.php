<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "student".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $birthdate
 * @property integer $level
 */
class Student extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'birthdate'], 'required'],
            [['birthdate'], 'date', 'format' => 'yyyy-mm-dd'],
            [['level'], 'integer', 'min' => 1, 'max' => 6],
            [['email'], 'email'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'email' => 'E-mail',
            'birthdate' => 'Дата рождения',
            'level' => 'Уровень языка',
        ];
    }

    public function getLevelName()
    {
        return static::getLevelsList()[$this->level];
    }

    public static function getLevelsList()
    {
        return [
            1 => 'A1',
            2 => 'A2',
            3 => 'B1',
            4 => 'B2',
            5 => 'C1',
            6 => 'C2',
        ];
    }

    public function getTeachers()
    {
        return $this->hasMany(Teacher::className(), ['id' => 'teacher_id'])
            ->viaTable('teacher_student', ['student_id' => 'id']);
    }
}
