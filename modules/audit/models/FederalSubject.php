<?php

namespace app\modules\audit\models;

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
 * @property ForestWork[] $forestWorks
 * @property Forestry[] $forestries
 * @property LuObject[] $luObjects
 * @property LuZakupCard[] $luZakupCards
 * @property Object[] $objects
 * @property ResponsibilityArea[] $responsibilityAreas
 * @property Subcityregion[] $subcityregions
 * @property Subforestry[] $subforestries
 * @property SubforestryDefense[] $subforestryDefenses
 * @property Suboopt[] $suboopts
 * @property VegetPeriod[] $vegetPeriods
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

    /**
     * Gets query for [[ForestWorks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getForestWorks()
    {
        return $this->hasMany(ForestWork::className(), ['federal_subject_id' => 'federal_subject_id']);
    }

    /**
     * Gets query for [[Forestries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getForestries()
    {
        return $this->hasMany(Forestry::className(), ['subject_kod' => 'federal_subject_id']);
    }

    /**
     * Gets query for [[LuObjects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLuObjects()
    {
        return $this->hasMany(LuObject::className(), ['fed_subject' => 'federal_subject_id']);
    }

    /**
     * Gets query for [[LuZakupCards]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLuZakupCards()
    {
        return $this->hasMany(LuZakupCard::className(), ['fed_subject' => 'federal_subject_id']);
    }

    /**
     * Gets query for [[Objects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getObjects()
    {
        return $this->hasMany(Object::className(), ['federal_subject_id' => 'federal_subject_id']);
    }

    /**
     * Gets query for [[ResponsibilityAreas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponsibilityAreas()
    {
        return $this->hasMany(ResponsibilityArea::className(), ['federal_subject_id' => 'federal_subject_id']);
    }

    /**
     * Gets query for [[Subcityregions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubcityregions()
    {
        return $this->hasMany(Subcityregion::className(), ['subject_kod' => 'federal_subject_id']);
    }

    /**
     * Gets query for [[Subforestries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubforestries()
    {
        return $this->hasMany(Subforestry::className(), ['subject_kod' => 'federal_subject_id']);
    }

    /**
     * Gets query for [[SubforestryDefenses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubforestryDefenses()
    {
        return $this->hasMany(SubforestryDefense::className(), ['subject_kod' => 'federal_subject_id']);
    }

    /**
     * Gets query for [[Suboopts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSuboopts()
    {
        return $this->hasMany(Suboopt::className(), ['subject_kod' => 'federal_subject_id']);
    }

    /**
     * Gets query for [[VegetPeriods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVegetPeriods()
    {
        return $this->hasMany(VegetPeriod::className(), ['subject_id' => 'federal_subject_id']);
    }
}
