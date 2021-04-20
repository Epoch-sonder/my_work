<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "forestry_munic".
 *
 * @property int $id
 * @property int $subject_kod
 * @property int $forestry_kod
 * @property int $munic_region
 *
 * @property FederalSubject $subjectKod
 */
class ForestryMunic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'forestry_munic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject_kod', 'forestry_kod', 'munic_region'], 'required'],
            [['subject_kod', 'forestry_kod', 'munic_region'], 'integer'],
            [['subject_kod'], 'exist', 'skipOnError' => true, 'targetClass' => FederalSubject::className(), 'targetAttribute' => ['subject_kod' => 'federal_subject_id']],
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
            'munic_region' => 'Munic Region',
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
}
