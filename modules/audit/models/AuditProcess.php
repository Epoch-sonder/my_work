<?php

namespace app\modules\audit\models;

use Yii;

/**
 * This is the model class for table "audit_process".
 *
 * @property int $id
 * @property int $audit ID проверки
 * @property int $audit_person ID проверяющего лица
 * @property int|null $audit_chapter Раздел
 * @property int|null $comment Замечания, комментарии
 * @property int|null $proposal Предложения
 * @property float|null $mooney_daily Суточные, всего (деньги)
 * @property float|null $money_accomod Проживание (деньги)
 * @property float|null $money_transport Транспортные расходы
 * @property float|null $money_other Прочие расходы
 *
 * @property Audit $audit0
 * @property AuditPerson $auditPerson
 */
class AuditProcess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'audit_process';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['audit', 'audit_person'], 'required'],
//            [['audit', 'audit_person', 'audit_chapter', 'comment', 'proposal'], 'integer'],
            [['audit', 'audit_person' , 'remote_mode'], 'integer'],
            [['comment', 'proposal'], 'string'],
            [['date_start', 'date_finish'], 'safe'],
            [['audit_chapter'], 'string', 'max' => 20],
            [['money_daily', 'money_accomod', 'money_transport', 'money_other'], 'number'],
            [['audit'], 'exist', 'skipOnError' => true, 'targetClass' => Audit::className(), 'targetAttribute' => ['audit' => 'id']],
            [['audit_person'], 'exist', 'skipOnError' => true, 'targetClass' => AuditPerson::className(), 'targetAttribute' => ['audit_person' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'audit' => 'Проверка',
            'audit_person' => 'Проверяющий специалист',
            'auditFio' => 'Проверяющий специалист',
            'audit_chapter' => 'Раздел',
            'comment' => 'Замечания',
            'proposal' => 'Предложения',
            'date_start' => 'Дата начала',
            'date_finish' => 'Дата окончания',
            'money_daily' => 'Суточные, руб.',
            'money_accomod' => 'Проживание, руб.',
            'money_transport' => 'Транспортные, руб.',
            'money_other' => 'Прочие, руб.',
            'federalSubjectName' => 'Субъект РФ',
        ];
    }

    /**
     * Gets query for [[Audit0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAudit0()
    {
        return $this->hasOne(Audit::className(), ['id' => 'audit']);
    }
    public function getAuditFed()
    {
        return $this->audit0->fed_subject;
    }
//    public function getAuditFed0()
//    {
//        return $this->audit0 ? $this->audit0->fed_subject : '0';
//    }

    /**
     * Gets query for [[AuditPerson]].
     *
     * @return \yii\db\ActiveQuery
     */

    public function getAuditPerson()
    {
        return $this->hasOne(AuditPerson::className(), ['id' => 'audit_person']);
    }

    public function getAuditFio()
    {
        return $this->auditPerson->fio;
    }

    public function getAuditPosition()
    {
        return $this->auditPerson->position;
    }

    public function getAuditBranch()
    {
        return $this->auditPerson->branch;
    }

    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['branch_id' => 'auditBranch']);
    }
    public function getBranchName()
    {
        return $this->branch->name;
    }

    public function getFederalSubject()
    {
        return $this->hasOne(FederalSubject::className(), ['federal_subject_id' => 'auditFed']);
    }

    /* Геттер для названия субъекта РФ */
    public function getFederalSubjectName() {
        return $this->federalSubject->name;
    }
}
