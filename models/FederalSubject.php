<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "federal_subject".
 *
 * @property int $federal_subject_id
 * @property int|null $federal_district_id
 * @property string|null $name
 *
 * @property Audit[] $audits
 * @property Cityregion[] $cityregions
 * @property FederalDistrict $federalDistrict
 */
class FederalSubject extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'federal_subject';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['federal_subject_id'], 'required'],
            [['federal_subject_id', 'federal_district_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['federal_subject_id'], 'unique'],
            [['federal_district_id'], 'exist', 'skipOnError' => true, 'targetClass' => FederalDistrict::className(), 'targetAttribute' => ['federal_district_id' => 'federal_district_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'federal_subject_id' => 'Federal Subject ID',
            'federal_district_id' => 'Federal District ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Audits]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAudits()
    {
        return $this->hasMany(Audit::className(), ['fed_subject' => 'federal_subject_id']);
    }

    /**
     * Gets query for [[Cityregions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCityregions()
    {
        return $this->hasMany(Cityregion::className(), ['subject_kod' => 'federal_subject_id']);
    }

    /**
     * Gets query for [[FederalDistrict]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFederalDistrict()
    {
        return $this->hasOne(FederalDistrict::className(), ['federal_district_id' => 'federal_district_id']);
    }
}
