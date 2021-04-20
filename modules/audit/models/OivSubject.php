<?php

namespace app\modules\audit\models;

use Yii;

/**
 * This is the model class for table "oiv_subject".
 *
 * @property int $id
 * @property int $fed_subject
 * @property string $name
 * @property string $address
 * @property string|null $phone
 * @property string|null $email
 */
class OivSubject extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'oiv_subject';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fed_subject', 'name', 'address'], 'required'],
            [['fed_subject'], 'default', 'value' => null],
            [['fed_subject'], 'integer'],
            [['name', 'address'], 'string', 'max' => 300],
            [['phone', 'email'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fed_subject' => 'Субъект РФ',
            'name' => 'Наименование ОИВ',
            'address' => 'Адрес',
            'phone' => 'Телефон',
            'email' => 'Email',
        ];
    }
}
