<?php

namespace app\modules\forest_work\models;

use Yii;

/**
 * This is the model class for table "responsibility_area".
 *
 * @property int $responsibility_area_id
 * @property int|null $federal_subject_id
 * @property int|null $branch_id
 *
 * @property FederalSubject $federalSubject
 * @property Branch $branch
 */
class ResponsibilityArea extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'responsibility_area';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['responsibility_area_id'], 'required'],
            [['responsibility_area_id', 'federal_subject_id', 'branch_id'], 'integer'],
            [['responsibility_area_id'], 'unique'],
            [['federal_subject_id'], 'exist', 'skipOnError' => true, 'targetClass' => FederalSubject::className(), 'targetAttribute' => ['federal_subject_id' => 'federal_subject_id']],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['branch_id' => 'branch_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'responsibility_area_id' => 'Responsibility Area ID',
            'federal_subject_id' => 'Federal Subject ID',
            'branch_id' => 'Branch ID',
        ];
    }

    /**
     * Gets query for [[FederalSubject]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFederalSubject()
    {
        return $this->hasOne(FederalSubject::className(), ['federal_subject_id' => 'federal_subject_id']);
    }

    /**
     * Gets query for [[Branch]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['branch_id' => 'branch_id']);
    }
}
