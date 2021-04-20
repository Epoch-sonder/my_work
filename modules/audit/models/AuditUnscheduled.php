<?php

namespace app\modules\audit\models;

use Yii;

/**
 * This is the model class for table "audit_unscheduled".
 *
 * @property int $id
 * @property int $subject
 * @property int $branch
 * @property string $fio
 * @property string $date_start
 * @property string $date_finish
 * @property float $participation_cost
 */
class AuditUnscheduled extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'audit_unscheduled';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject', 'branch', 'fio', 'date_start', 'date_finish', 'participation_cost'], 'required'],
            [['subject', 'branch'], 'integer'],
            [['date_start', 'date_finish','comment' ,'proposal'], 'safe'],
            [['participation_cost'], 'number'],
            [['fio'], 'string', 'max' => 200],
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
            'branch' => 'Филиал',
            'branchName' => 'Филиал',
            'fio' => 'ФИО и должность исполнителя',
            'date_start' => 'Дата начала проверки',
            'date_finish' => 'Дата окончания проверки',
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
