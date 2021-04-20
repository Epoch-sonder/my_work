<?php

namespace app\modules\lu\models;

use Yii;

/**
 * This is the model class for table "subforestry".
 *
 * @property int $id
 * @property int $subject_kod
 * @property int $forestry_kod
 * @property int $subforestry_kod
 * @property string $subforestry_name
 */
class Subforestry extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subforestry';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject_kod', 'forestry_kod', 'subforestry_kod', 'subforestry_name'], 'required'],
            [['subject_kod', 'forestry_kod', 'subforestry_kod'], 'integer'],
            [['subforestry_name'], 'string', 'max' => 100],
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
            'forestry_kod' => 'Forestry Kod',
            'subforestry_kod' => 'Subforestry Kod',
            'subforestry_name' => 'Subforestry Name',
        ];
    }
}
