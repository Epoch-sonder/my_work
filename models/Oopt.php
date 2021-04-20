<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "oopt".
 *
 * @property int $id
 * @property int|null $subject_kod
 * @property int|null $oopt_kod
 * @property string $oopt_name
 *
 * @property OoptBinding[] $ooptBindings
 */
class Oopt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'oopt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject_kod', 'oopt_kod'], 'integer'],
            [['oopt_name'], 'required'],
            [['oopt_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject_kod' => 'Subject Kod',
            'oopt_kod' => 'Oopt Kod',
            'oopt_name' => 'Oopt Name',
        ];
    }

    /**
     * Gets query for [[OoptBindings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOoptBindings()
    {
        return $this->hasMany(OoptBinding::className(), ['oopt' => 'id']);
    }
}
