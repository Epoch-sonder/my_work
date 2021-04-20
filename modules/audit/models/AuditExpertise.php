<?php

namespace app\modules\audit\models;

use Yii;

/**
 * This is the model class for table "audit_expertise".
 *
 * @property int $id
 * @property int $subject
 * @property string $contract
 * @property float $sum_contract
 * @property string $date_start
 * @property string $date_finish
 * @property int $branch
 * @property string $fio
 * @property float $participation_cost
 */
class AuditExpertise extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'audit_expertise';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject', 'contract', 'sum_contract', 'date_start', 'date_finish', 'branch', 'fio', 'participation_cost'], 'required'],
            [['subject', 'branch'], 'integer'],
            [['sum_contract', 'participation_cost'], 'number'],
            [['date_start', 'date_finish','comment' ,'proposal'], 'safe'],
            [['contract', 'fio'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject' => 'Субъект РФ',
            'fedSubjectName' => 'Субъект РФ',
            'contract' => 'Договор на экспертизу',
            'sum_contract' => 'Сумма договора',
            'date_start' => 'Дата начала проверки',
            'date_finish' => 'Дата окончания проверки',
            'branch' => 'Филиал',
            'branchName' => 'Филиал',
            'fio' => 'ФИО и должность исполнителя',
            'participation_cost' => 'Затраты на участие',
            'comment'  => 'Замечания, комментарии',
            'proposal' => 'Предложения',
        ];
    }
    public function getBranchID()
    {
        return $this->hasOne(Branch::className(), ['branch_id' => 'branch']);
    }

    public function getBranchName() {
        return $this->branchID->name;
    }

    public function getFedSubject()
    {
        return $this->hasOne(FederalSubject::className(), ['federal_subject_id' => 'subject']);
    }

    public function getFedSubjectName() {
        return $this->fedSubject->name;
    }
}
