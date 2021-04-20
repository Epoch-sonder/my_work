<?php

namespace app\modules\pd\models;

use Yii;

/**
 * This is the model class for table "veget_period".
 *
 * @property int $id
 * @property int $subject_id
 * @property string $veget_start
 * @property string $veget_finish
 *
 * @property FederalSubject $subject
 */
class VegetPeriod extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'veget_period';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject_id', 'veget_start', 'veget_finish'], 'required'],
            [['subject_id'], 'integer'],
            [['veget_start', 'veget_finish'], 'safe'],
            [['subject_id'], 'exist', 'skipOnError' => true, 'targetClass' => FederalSubject::className(), 'targetAttribute' => ['subject_id' => 'federal_subject_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject_id' => 'Subject ID',
            'veget_start' => 'Начало вегетации',
            'veget_finish' => 'Окончание вегетации',
            'subjectName' => 'Субъект РФ',
        ];
    }

    /**
     * Gets query for [[Subject]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubject()
    {
        return $this->hasOne(FederalSubject::className(), ['federal_subject_id' => 'subject_id']);
    }

    public function getSubjectName() {
        return $this->subject->name;
    }


}
