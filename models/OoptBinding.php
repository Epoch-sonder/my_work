<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "oopt_binding".
 *
 * @property int $id
 * @property int $oopt id базы "oopt"
 * @property int $subject id базы "federal_subject"
 * @property int $munic id базы "munic_region"
 *
 * @property MunicRegion $munic0
 * @property Oopt $oopt0
 * @property FederalSubject $subject0
 */
class OoptBinding extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'oopt_binding';
    }

    /**
     * {@inheritdoc}
     */


    public function rules()
    {
        return [
            [['oopt', 'subject', 'munic'], 'required'],
            [['oopt', 'subject', 'munic'], 'integer'],
            [['munic'], 'exist', 'skipOnError' => true, 'targetClass' => MunicRegion::className(), 'targetAttribute' => ['munic' => 'id']],
            [['oopt'], 'exist', 'skipOnError' => true, 'targetClass' => Oopt::className(), 'targetAttribute' => ['oopt' => 'id']],
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
            'oopt' => 'ООПТ',
            'ooptName' => 'ООПТ',
            'subject' => 'Субъект РФ',
            'subjectName' => 'Субъект РФ',
            'munic' => 'Муниципальный район',
            'municName' => 'Муниципальный район',
        ];
    }

    /**
     * Gets query for [[Munic0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMunic0()
    {
        return $this->hasOne(MunicRegion::className(), ['id' => 'munic']);
    }
    public function getMunicName()
    {
        return $this->munic0->name;
    }

    /**
     * Gets query for [[Oopt0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOopt0()
    {
        return $this->hasOne(Oopt::className(), ['id' => 'oopt']);
    }
    public function getOoptName()
    {
        return $this->oopt0->oopt_name;
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
