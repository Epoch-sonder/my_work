<?php

namespace app\modules\lu\models;

use Yii;

/**
 * This is the model class for table "forestry".
 *
 * @property int $id
 * @property int $subject_kod
 * @property int $forestry_kod
 * @property string|null $forestry_name
 * @property int|null $removed
 * @property int|null $kv_count Количество кварталов из повыделенной сети
 * @property int|null $vd_count Количество выделов из повыделенной сети
 * @property int|null $kv_glr Количество кварталов по ГЛР
 * @property int|null $vd_glr Количество выделов по ГЛР
 * @property float|null $area_order Площадь по приказу
 * @property float|null $area_glr_lu Площадь на которой было лесоустройство по ГЛР
 * @property float|null $area_glr_nlu Площадь на которой не было лесоустройства по ГЛР
 * @property float|null $area_geo_lu Сумма площадей на которых было лесоустройство по данным из векторной площади поведеленной сети
 * @property float|null $area_pl Сумма площадей на которых было лесоустройство по данным из атрибутов поведеленной сети
 * @property string|null $geom Геометрия всего лесничества
 * @property string|null $geom_lu Геометрия территории на которой было лесоустройство из повыделенной сети
 * @property string|null $timestamp
 *
 * @property FederalSubject $subjectKod
 * @property Subforestry[] $subforestries
 */
class Forestry extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'forestry';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'subject_kod', 'forestry_kod'], 'required'],
            [['id', 'subject_kod', 'forestry_kod', 'removed', 'kv_count', 'vd_count', 'kv_glr', 'vd_glr'], 'integer'],
            [['area_order', 'area_glr_lu', 'area_glr_nlu', 'area_geo_lu', 'area_pl'], 'number'],
            [['timestamp'], 'safe'],
            [['forestry_name'], 'string', 'max' => 100],
            [['geom', 'geom_lu'], 'string', 'max' => 10],
            [['subject_kod', 'forestry_kod'], 'unique', 'targetAttribute' => ['subject_kod', 'forestry_kod']],
            [['id'], 'unique'],
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
            'forestry_name' => 'Forestry Name',
            'removed' => 'Removed',
            'kv_count' => 'Kv Count',
            'vd_count' => 'Vd Count',
            'kv_glr' => 'Kv Glr',
            'vd_glr' => 'Vd Glr',
            'area_order' => 'Area Order',
            'area_glr_lu' => 'Area Glr Lu',
            'area_glr_nlu' => 'Area Glr Nlu',
            'area_geo_lu' => 'Area Geo Lu',
            'area_pl' => 'Area Pl',
            'geom' => 'Geom',
            'geom_lu' => 'Geom Lu',
            'timestamp' => 'Timestamp',
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
     * Gets query for [[Subforestries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubforestries()
    {
        return $this->hasMany(Subforestry::className(), ['subject_kod' => 'subject_kod', 'forestry_kod' => 'forestry_kod']);
    }
}
