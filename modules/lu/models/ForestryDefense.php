<?php

namespace app\modules\lu\models;

use Yii;

/**
 * This is the model class for table "forestry_defense".
 *
 * @property int $id
 * @property int $subject_kod
 * @property int $forestry_kod
 * @property string $forestry_name
 *
 * @property SubforestryDefense[] $subforestryDefenses
 */
class ForestryDefense extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'forestry_defense';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject_kod', 'forestry_kod', 'forestry_name'], 'required'],
            [['subject_kod', 'forestry_kod'], 'integer'],
            [['forestry_name'], 'string', 'max' => 100],
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
            'forestry_name' => 'Forestry Name',
        ];
    }

    /**
     * Gets query for [[SubforestryDefenses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubforestryDefenses()
    {
        return $this->hasMany(SubforestryDefense::className(), ['forestry_kod' => 'forestry_kod']);
    }
}
