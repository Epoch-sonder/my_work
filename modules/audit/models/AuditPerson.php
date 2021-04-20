<?php

namespace app\modules\audit\models;

use Yii;

/**
 * This is the model class for table "audit_person".
 *
 * @property int $id
 * @property string $fio Ф.И.О.
 * @property string $position Должность
 * @property string $phone
 * @property string $email
 * @property int $branch Филиал
 *
 * @property Branch $branch0
 * @property AuditProcess[] $auditProcesses
 */
class AuditPerson extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'audit_person';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio', 'position', 'branch'], 'required'],
            [['branch'], 'integer'],
            [['fio', 'position'], 'string', 'max' => 100],
            [['phone','email'], 'string', 'max' => 50],
            [['branch'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['branch' => 'branch_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'Ф.И.О.',
            'position' => 'Должность',
            'branch' => 'Филиал',
            'branchName' => 'Филиал',
            'phone' => 'Телефон',
            'email' => 'E-mail',
        ];
    }

    /**
     * Gets query for [[Branch0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBranch0()
    {
        return $this->hasOne(Branch::className(), ['branch_id' => 'branch']);
    }

    public function getBranchName() {
        return $this->branch0->name;
    }

    /**
     * Gets query for [[AuditProcesses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuditProcesses()
    {
        return $this->hasMany(AuditProcess::className(), ['audit_person' => 'id']);
    }
}
