<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "munic_region".
 *
 * @property int $id
 * @property int $federal_subject
 * @property int $forestgrow_region
 * @property string $name
 * @property string $full_name
 *
 * @property ForestgrowRegion $forestgrowRegion
 * @property FederalSubject $federalSubject
 * @property OoptBinding[] $ooptBindings
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
            'federal_subject' => 'Federal Subject',
            'forestgrow_region' => 'Forestgrow Region',
            'name' => 'Name',
            'full_name' => 'Full Name',
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

    /**
     * Gets query for [[FederalSubject]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFederalSubject()
    {
        return $this->hasOne(FederalSubject::className(), ['federal_subject_id' => 'federal_subject']);
    }

    /**
     * Gets query for [[OoptBindings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOoptBindings()
    {
        return $this->hasMany(OoptBinding::className(), ['munic' => 'id']);
    }
}
