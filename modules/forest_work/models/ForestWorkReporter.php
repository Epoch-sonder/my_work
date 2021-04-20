<?php

namespace app\modules\forest_work\models;

use Yii;

/**
 * This is the model class for table "forest_work_reporter".
 *
 * @property int $reporter_id
 * @property string $reporter_fio
 * @property string $reporter_position
 * @property int $reporter_tel
 * @property int $reporter_branch
 *
 * @property ForestWork[] $forestWorks
 * @property Branch $reporterBranch
 */
class ForestWorkReporter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'forest_work_reporter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reporter_fio', 'reporter_position', 'reporter_tel', 'reporter_branch'], 'required'],
            [['reporter_branch'], 'integer'],
            [['reporter_fio', 'reporter_position'], 'string', 'max' => 100],
            [['reporter_branch'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['reporter_branch' => 'branch_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'reporter_id' => 'Reporter ID',
            'reporter_fio' => 'Ф.И.О.',
            'reporter_position' => 'Должность',
            'reporter_tel' => 'Номер телефона',
            'reporter_branch' => 'Филиал',

        ];
    }

    /**
     * Gets query for [[ForestWorks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getForestWorks()
    {
        return $this->hasMany(ForestWork::className(), ['reporter' => 'reporter_id']);
    }

    /**
     * Gets query for [[ReporterBranch]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReporterBranch()
    {
        return $this->hasOne(Branch::className(), ['branch_id' => 'reporter_branch']);
    }
}
