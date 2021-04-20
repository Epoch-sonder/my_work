<?php

namespace app\modules\audit\models;

use Yii;

/**
 * This is the model class for table "munic_region".
 *
 * @property int $id
 * @property int $federal_subject
 * @property int $forestgrow_region
 * @property string $name
 *
 * @property ForestgrowRegion $forestgrowRegion
 * @property FederalSubject $federalSubject
 */
class MunicRegion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'munic_region';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['federal_subject', 'forestgrow_region', 'name', 'full_name'], 'required'],
            [['federal_subject', 'forestgrow_region'], 'integer'],
            [['name'], 'string', 'max' => 80],
            [['full_name'], 'string', 'max' => 430],
            [['forestgrow_region'], 'exist', 'skipOnError' => true, 'targetClass' => ForestgrowRegion::className(), 'targetAttribute' => ['forestgrow_region' => 'id']],
            [['federal_subject'], 'exist', 'skipOnError' => true, 'targetClass' => FederalSubject::className(), 'targetAttribute' => ['federal_subject' => 'federal_subject_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'federalSubjectName' => 'Субъект РФ',
           'federal_subject' => 'Субъект РФ',
            'forestgrowRegionName' => 'Лесорастительный район',
           'forestgrow_region' => 'Лесорастительный район',
            'name' => 'Название',
            'full_name' => 'Полное название'
        ];
    }

    /**
     * Gets query for [[ForestgrowRegion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getForestgrowRegion()
    {
        return $this->hasOne(ForestgrowRegion::className(), ['id' => 'forestgrow_region']);
    }

    public function getForestgrowRegionName()
    {
        return $this->forestgrowRegion->name;
    }

    
     /* @return \yii\db\ActiveQuery
     */
    public function getFederalSubject()
    {
        return $this->hasOne(FederalSubject::className(), ['federal_subject_id' => 'federal_subject']);
    }

    public function getFederalSubjectName()
    {
        return $this->federalSubject->name;
    }


}
