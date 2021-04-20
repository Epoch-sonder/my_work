<?php

namespace app\modules\audit\models;

use Yii;

/**
 * This is the model class for table "training_person".
 *
 * @property int $id
 * @property string $fio
 * @property string $position
 * @property string|null $workplace_rli
 * @property string|null $workplace_other
 */
class TrainingPerson extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'training_person';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio', 'position'], 'required'],
            [['fio'], 'string', 'max' => 80],
            [['position'], 'string', 'max' => 200],
            [['workplace_rli', 'workplace_other'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'ФИО',
            'position' => 'Должность',
            'workplace_rli' => 'Филиал Рослесинфорг',
            'workplace_other' => 'Другое место работы',
        ];
    }
}
