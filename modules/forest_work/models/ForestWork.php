<?php

namespace app\modules\forest_work\models;

use Yii;

class ForestWork extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'forest_work';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['branch_id', 'federal_subject_id', 'date', 'reporter'], 'required'],
            [['branch_id', 'federal_subject_id', 'reporter', 'a1', 'a2', 'a3', 'a4', 'a5', 'a6', 'a7', 'a8', 'a9', 'a10', 'a11', 'a12', 'a13', 'a14', 'a15', 'a16', 'a17', 'b1', 'b2', 'b3', 'b4', 'b5', 'b6', 'b7', 'b8', 'b9', 'b10', 'b11', 'b12', 'b13', 'b14', 'b15', 'b16', 'b17'], 'integer'],
            [['date', 'timestamp'], 'safe'],
            [['reporter'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['reporter' => 'id']],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['branch_id' => 'branch_id']],
            [['federal_subject_id'], 'exist', 'skipOnError' => true, 'targetClass' => FederalSubject::className(), 'targetAttribute' => ['federal_subject_id' => 'federal_subject_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'branch_id' => 'Филиал',
            'branchName' => 'Филиал',
            'federal_subject_id' => 'Субъект РФ',
            'federalSubjectName' => 'Субъект РФ',
            'date' => 'Дата подготовки отчета',
            'reporter' => 'Должностное лицо',
            'reporterName' => 'Должностное лицо',
            'a1' => '',
            'a2' => '',
            'a3' => '',
            'a4' => '',
            'a5' => '',
            'a6' => '',
            'a7' => '',
            'a8' => '',
            'a9' => '',
            'a10' => '',
            'a11' => '',
            'a12' => '',
            'a13' => '',
            'a14' => '',
            'a15' => '',
            'a16' => '',
            'a17' => '',
            'b1' => '',
            'b2' => '',
            'b3' => '',
            'b4' => '',
            'b5' => '',
            'b6' => '',
            'b7' => '',
            'b8' => '',
            'b9' => '',
            'b10' => '',
            'b11' => '',
            'b12' => '',
            'b13' => '',
            'b14' => '',
            'b15' => '',
            'b16' => '',
            'b17' => '',
            'timestamp' => 'Момент добавления отчета',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'reporter']);
    }

    public function getReporterName() {
        return $this->user->fio;
    }



    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['branch_id' => 'branch_id']);
    }

    public function getBranchName() {
        return $this->branch->name;
    }



    public function getFederalSubject()
    {
        return $this->hasOne(FederalSubject::className(), ['federal_subject_id' => 'federal_subject_id']);
    }

    public function getFedSubjectName() {
        return $this->federalSubject->name;
    }


    
}
