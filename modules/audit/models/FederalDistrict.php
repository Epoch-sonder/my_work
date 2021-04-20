<?php

namespace app\modules\audit\models;

use Yii;

/**
 * This is the model class for table "federal_district".
 *
 * @property int $federal_district_id
 * @property string|null $name
 *
 * @property Audit[] $audits
 * @property FederalSubject[] $federalSubjects
 */
class FederalDistrict extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'federal_district';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['federal_district_id'], 'required'],
            [['federal_district_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['federal_district_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
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
        return $this->hasMany(Audit::className(), ['fed_district' => 'federal_district_id']);
    }

    /**
     * Gets query for [[FederalSubjects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFederalSubjects()
    {
        return $this->hasMany(FederalSubject::className(), ['federal_district_id' => 'federal_district_id']);
    }
}
