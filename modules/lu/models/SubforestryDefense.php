<?php

namespace app\modules\lu\models;

use Yii;

/**
 * This is the model class for table "subforestry_defense".
 *
 * @property int $id
 * @property int $subject_kod
 * @property int $forestry_kod
 * @property int $subforestry_kod
 * @property string $subforestry_name
 *
 * @property FederalSubject $subjectKod
 * @property ForestryDefense $forestryKod
 */
class SubforestryDefense extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subforestry_defense';
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
            [['subject_kod'], 'exist', 'skipOnError' => true, 'targetClass' => FederalSubject::className(), 'targetAttribute' => ['subject_kod' => 'federal_subject_id']],
            [['forestry_kod'], 'exist', 'skipOnError' => true, 'targetClass' => ForestryDefense::className(), 'targetAttribute' => ['forestry_kod' => 'forestry_kod']],
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

    /**
     * Gets query for [[SubjectKod]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubjectKod()
    {
        return $this->hasOne(FederalSubject::className(), ['federal_subject_id' => 'subject_kod']);
    }

    /**
     * Gets query for [[ForestryKod]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getForestryKod()
    {
        return $this->hasOne(ForestryDefense::className(), ['forestry_kod' => 'forestry_kod']);
    }
}
