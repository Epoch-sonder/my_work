<?php

namespace app\modules\audit\models;

use Yii;

/**
 * This is the model class for table "audit_revision".
 *
 * @property int $id
 * @property int $branch
 * @property string $inspectorate
 * @property string $fio
 * @property string $date_start
 * @property string $date_finish
 */
class AuditRevision extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'audit_revision';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['branch', 'inspectorate', 'fio', 'date_start', 'date_finish'], 'required'],
            [['branch'], 'integer'],
            [['date_start', 'date_finish','comment' ,'proposal'], 'safe'],
            [['inspectorate', 'fio'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'branch' => 'Филиал',
            'branchName' => 'Филиал',
            'inspectorate' => 'Проверяющий орган',
            'fio' => 'ФИО и должность исполнителя',
            'date_start' => 'Дата начала проверки',
            'date_finish' => 'Дата окончания проверки',
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
}
