<?php

namespace app\modules\audit\models;

use Yii;

/**
 * This is the model class for table "brigade".
 *
 * @property int $id
 * @property int $branch Филиал
 
 * @property int $subject Субъект
 
 * @property int $forestgrow_region
 * @property string $object_work Объект работ
 
 * @property string $contract Реквизиты контракта
 
 * @property string $date_begin Дата выезда на полевые работы
 
 * @property int $brigade_number # бригады/партии
 * @property string $person id person
 * @property string $remark Примечание
 *
 * @property Branch $branch0
 * @property FederalSubject $subject0
 */
class Brigade extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'brigade';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['branch', 'subject', 'forestgrow_region', 'object_work', 'contract', 'date_begin', 'brigade_number', 'person', 'remark'], 'required'],
            [['branch', 'subject', 'forestgrow_region', 'brigade_number'], 'integer'],
            [['date_begin'], 'safe'],
            [['object_work', 'person'], 'string', 'max' => 300],
            [['contract'], 'string', 'max' => 50],
            [['remark'], 'string', 'max' => 100],
            [['branch'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['branch' => 'branch_id']],
            [['subject'], 'exist', 'skipOnError' => true, 'targetClass' => FederalSubject::className(), 'targetAttribute' => ['subject' => 'federal_subject_id']],
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
            'subject' => 'Субъект',
            'subjectName' => 'Субъект',
            'object_work' => 'Объект работ',
            'contract' => 'Реквизиты контракта',
            'date_begin' => 'Дата выезда на полевые работы',
            'brigade_number' => 'Номер бригады',
            'person' => 'ФИО работника',
            'remark' => 'Примечание',
            'forestgrow_region' => 'Лесорастительный район',
            'forestgrowRegionName' => 'Лесорастительный район',

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
    public function getForestgrowRegion()
    {
        return $this->hasOne(ForestgrowRegion::className(), ['id' => 'forestgrow_region']);
    }
    public function getForestgrowRegionName()
    {
        return $this->forestgrowRegion->name;
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
}
