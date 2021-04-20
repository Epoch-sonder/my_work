<?php

namespace app\modules\lu\models;

use Yii;

/**
 * This is the model class for table "cityregion".
 *
 * @property int $id
 * @property int $subject_kod
 * @property int $cityregion_kod
 * @property string $cityregion_name
 *
 * @property FederalSubject $subjectKod
 */
class Cityregion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cityregion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject_kod', 'cityregion_kod', 'cityregion_name'], 'required'],
            [['subject_kod', 'cityregion_kod'], 'integer'],
            [['cityregion_name'], 'string', 'max' => 100],
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
            'cityregion_kod' => 'Cityregion Kod',
            'cityregion_name' => 'Cityregion Name',
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
