<?php

namespace app\modules\audit\models;

use Yii;

/**
 * This is the model class for table "audit".
 *
 * @property int $id
 * @property string $date_start дата начала проверки
 * @property string $date_finish дата окончания проверки
 * @property int $fed_district Федеральный округ
 * @property int $fed_subject Территориальная единица (субъект РФ)
 * @property string $oiv Орган исполнительной власти
 * @property string $organizer Организатор проверки
 * @property int $audit_type Тип поверки (плановая/внеплановая)
 * @property int $audit_quantity Количество проверок
 *
 * @property AuditType $auditType
 * @property FederalSubject $fedSubject
 * @property FederalDistrict $fedDistrict
 * @property AuditProcess[] $auditProcesses
 */
class Audit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'audit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_start', 'date_finish', 'fed_district', 'fed_subject', 'oiv', 'organizer', 'audit_type', 'audit_quantity'], 'required'],
            [['date_start', 'date_finish'], 'safe'],
            [['fed_district', 'fed_subject', 'audit_type', 'audit_quantity','duration'], 'integer'],
            [['oiv', 'organizer'], 'string', 'max' => 200],
            [['audit_type'], 'exist', 'skipOnError' => true, 'targetClass' => AuditType::className(), 'targetAttribute' => ['audit_type' => 'id']],
            [['fed_subject'], 'exist', 'skipOnError' => true, 'targetClass' => FederalSubject::className(), 'targetAttribute' => ['fed_subject' => 'federal_subject_id']],
            [['fed_district'], 'exist', 'skipOnError' => true, 'targetClass' => FederalDistrict::className(), 'targetAttribute' => ['fed_district' => 'federal_district_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_start' => 'Дата начала',
            'date_finish' => 'Дата окончания',
            'duration'=> 'Количество дней',
            'fed_district' => 'Федеральный округ',
            'fedDistrictName' => 'Федеральный округ',
            'fed_subject' => 'Субъект РФ',
            'fedSubjectName' => 'Субъект РФ',
            'oivSubjectName' => 'ОИВ',
            'oiv' => 'ОИВ',
            'organizer' => 'Организатор проверки',
            'audit_type' => 'Тип проверки',
            'auditTypeName' => 'Тип проверки',
            'audit_quantity' => 'Количество проверок',
        ];
    }

    /**
     * Gets query for [[AuditType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuditType()
    {
        return $this->hasOne(AuditType::className(), ['id' => 'audit_type']);
    }

    public function getAuditTypeName() {
        return $this->auditType->type;
    }

    /**
     * Gets query for [[FedSubject]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFedSubject()
    {
        return $this->hasOne(FederalSubject::className(), ['federal_subject_id' => 'fed_subject']);
    }

    public function getFedSubjectName() {
        return $this->fedSubject->name;
    }
    public function getOivSubject()
    {
        return $this->hasOne(OivSubject::className(), ['id' => 'oiv']);
    }

    public function getOivSubjectName() {
        return $this->oivSubject->name;
    }

    public function getFedSubjectOrg() {
        return $this->fedSubject->name . " (". $this->organizer . ")";
    }

    /**
     * Gets query for [[FedDistrict]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFedDistrict()
    {
        return $this->hasOne(FederalDistrict::className(), ['federal_district_id' => 'fed_district']);
    }

    public function getFedDistrictName() {
        return $this->fedDistrict->name;
    }

    /**
     * Gets query for [[AuditProcesses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuditProcesses()
    {
        return $this->hasMany(AuditProcess::className(), ['audit' => 'id']);
    }
}
