<?php

namespace app\modules\audit\models;

use Yii;

/**
 * This is the model class for table "forestgrow_region_subject".
 *
 * @property int $id
 * @property int $region_id
 * @property int $subject_id
 *
 * @property FederalSubject $subject
 * @property ForestgrowRegion $region
 */
class ForestgrowRegionSubject extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'forestgrow_region_subject';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region_id', 'subject_id'], 'required'],
            [['region_id', 'subject_id'], 'integer'],
            [['subject_id'], 'exist', 'skipOnError' => true, 'targetClass' => FederalSubject::className(), 'targetAttribute' => ['subject_id' => 'federal_subject_id']],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => ForestgrowRegion::className(), 'targetAttribute' => ['region_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'regionName' => 'Лесорастительные районы',
            'subjectName' => 'Субъекты РФ',
        ];
    }

    /**
     * Gets query for [[Subject]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubject()
    {
        return $this->hasOne(FederalSubject::className(), ['federal_subject_id' => 'subject_id']);
    }

    public function getSubjectName()
    {
        return $this->subject->name;
    }

    /**
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(ForestgrowRegion::className(), ['id' => 'region_id']);
    }

    public function getRegionName()
    {
        return $this->region->name;
    }
}
