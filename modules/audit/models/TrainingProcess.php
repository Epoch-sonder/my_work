<?php

namespace app\modules\audit\models;

use Yii;

/**
 * This is the model class for table "training_process".
 *
 * @property int $id
 * @property int $branch
 * @property int $subject
 * @property int $forestgrow_region
 * @property int|null $munic_region
 * @property int|null $forestry
 * @property int|null $subforestry
 * @property string|null $quarter_strip
 * @property int|null $traininng_forestry
 * @property int|null $training_subforesty
 * @property int|null $training_site_amount
 * @property int|null $training_strip_amount
 * @property string|null $training_contract_num
 * @property string|null $training_date_start
 * @property string|null $training_date_finish
 * @property int $person
 *
 * @property Branch $branch0
 * @property FederalSubject $subject0
 * @property ForestgrowRegion $forestgrowRegion
 * @property TrainingPerson $person0
 */
class TrainingProcess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'training_process';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['branch', 'subject', ], 'required'],
            [['branch', 'subject', 'forestgrow_region','munic_region','forestry','subforestry','training_forestry', 'training_subforestry', 'training_site_amount', 'training_strip_amount'], 'integer'],
            [['training_date_start', 'training_date_finish', 'verified'], 'safe'],
            [['training_quarter_strip'], 'string', 'max' => 100],
            [['training_contract_num','person'], 'string', 'max' => 50],
            [['branch'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['branch' => 'branch_id']],
            [['subject'], 'exist', 'skipOnError' => true, 'targetClass' => FederalSubject::className(), 'targetAttribute' => ['subject' => 'federal_subject_id']],
            [['forestgrow_region'], 'exist', 'skipOnError' => true, 'targetClass' => ForestgrowRegion::className(), 'targetAttribute' => ['forestgrow_region' => 'id']],
            ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'branchName' => 'Филиал',
            'subjectName' => 'Субъект РФ',
            'forestgrowRegionName' => 'Лесорастительный район',
            'municName' => 'Муниципальный район',
            'munic_region' => 'Муниципальный район',
            'forestry' => 'Лесничество',
            'subforestry' => 'Участковое лесничество',
            'training_forestry' => 'Тренировочное лесничество',
            'training_subforestry' => 'Тренировочное участковое лесничество',
            'training_quarter_strip' => 'Квартал и выдел',
            'training_site_amount' => 'Количество тренировочных площадок',
            'training_strip_amount' => 'Количество тренировочных выделов',
            'training_contract_num' => 'Номер контракта',
            'training_date_start' => 'Дата начала',
            'training_date_finish' => 'Дата завершения',
            'personFio' => 'Участник тренировки',
            'verified'=> 'Проверено'
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

     public function getBranchName()
    {
        return $this->branch0->name;
    }

    /**
     * Gets query for [[Subject0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubject0()
    {
        return $this->hasOne(FederalSubject::className(), ['federal_subject_id' => 'subject']);
    }

    public function getSubjectName()
    {
        return $this->subject0->name;
    }

    /**
     * Gets query for [[ForestgrowRegion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getForestgrowRegion()
    {
        return $this->hasOne(ForestgrowRegion::className(), ['id' => 'forestgrow_region']);
    }
    public function getForestgrowRegionName()
    {
        return $this->forestgrowRegion->name;
    }


    public function getMunic()
    {
        return $this->hasOne(MunicRegion::className(), ['id' => 'munic_region']);
    }

    public function getMunicName()
    {
        return $this->munic->name;
    }


    public function getSubforestry()
    {
        return $this->hasOne(SubForestry::className(), ['subforestry_kod' => 'subforestry']);
    }

    public function getSubforestryName()
    {
        return $this->subforestry->subforestry_name;
    }

    /**
     * Gets query for [[Person0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerson0()
    {
        return $this->hasOne(TrainingPerson::className(), ['id' => 'person']);
    }

    public function getPersonFio()
    {
        return $this->person0->fio;
    }
}
