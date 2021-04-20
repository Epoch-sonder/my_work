<?php

namespace app\modules\lu\models;

use Yii;

/**
 * This is the model class for table "oopt".
 *
 * @property int $id
 * @property string $oopt_name
 *
 * @property Suboopt[] $suboopts
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
            'oopt_name' => 'Oopt Name',
        ];
    }

    /**
     * Gets query for [[Suboopts]].
     *
     * @return \yii\db\ActiveQuery
     */
}
