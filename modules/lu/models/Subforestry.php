<?php

namespace app\modules\lu\models;

use Yii;

/**
 * This is the model class for table "subforestry".
 *
 * @property int $id
 * @property int $subject_kod
 * @property int $forestry_kod
 * @property int $subforestry_kod
 * @property string|null $subforestry_name
 * @property int|null $kv_count Количество кварталов из повыделенной сети
 * @property int|null $vd_count Количество выделов из повыделенной сети
 * @property int|null $kv_glr Количество кварталов по ГЛР
 * @property int|null $vd_glr Количество выделов по ГЛР
 * @property float|null $area_order Площадь по приказу
 * @property float|null $area_glr_lu Площадь на которой было лесоустройство по ГЛР
 * @property float|null $area_glr_nlu Площадь на которой не было лесоустройства по ГЛР
 * @property float|null $area_geo_lu Сумма площадей на которых было лесоустройство по данным из векторной площади поведеленной сети
 * @property float|null $area_pl Сумма площадей на которых было лесоустройство по данным из атрибутов поведеленной сети
 * @property string|null $geom Геометрия всего участкового лесничества
 * @property string|null $geom_lu Геометрия территории на которой было лесоустройство из повыделенной сети
 * @property string|null $timestamp
 *
 * @property Forestry $subjectKod
 */
class Subforestry extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subforestry';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'subject_kod', 'forestry_kod', 'subforestry_kod'], 'required'],
            [['id', 'subject_kod', 'forestry_kod', 'subforestry_kod', 'kv_count', 'vd_count', 'kv_glr', 'vd_glr'], 'integer'],
            [['area_order', 'area_glr_lu', 'area_glr_nlu', 'area_geo_lu', 'area_pl'], 'number'],
            [['timestamp'], 'safe'],
            [['subforestry_name'], 'string', 'max' => 100],
            [['geom', 'geom_lu'], 'string', 'max' => 10],
            [['subject_kod', 'forestry_kod', 'subforestry_kod'], 'unique', 'targetAttribute' => ['subject_kod', 'forestry_kod', 'subforestry_kod']],
            [['id'], 'unique'],
            [['subject_kod', 'forestry_kod'], 'exist', 'skipOnError' => true, 'targetClass' => Forestry::className(), 'targetAttribute' => ['subject_kod' => 'subject_kod', 'forestry_kod' => 'forestry_kod']],
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
        return $this->hasOne(Forestry::className(), ['subject_kod' => 'subject_kod', 'forestry_kod' => 'forestry_kod']);
    }
}
