<?php

namespace app\modules\lu\models;

use Yii;

/**
 * This is the model class for table "lu_process_step".
 *
 * @property int $id
 * @property string $step_name Название шага
 * @property string $step_number Номер шага
 * @property int $step_phase Этап работ
 * @property int $max_duration Максимальное дней на шаг
 * @property int $sort_order Порядок сортировки
 *
 * @property LuProcess[] $luProcesses
 * @property LuPhase $stepPhase
 */
class LuProcessStep extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lu_process_step';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['step_name', 'step_number', 'step_phase', 'max_duration', 'sort_order'], 'required'],
            [['step_phase', 'max_duration', 'sort_order'], 'integer'],
            [['step_name'], 'string', 'max' => 1000],
            [['step_number'], 'string', 'max' => 10],
            [['step_phase'], 'exist', 'skipOnError' => true, 'targetClass' => LuPhase::className(), 'targetAttribute' => ['step_phase' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'step_name' => 'Название шага',
            'step_number' => 'Номер шага',
            'step_phase' => 'Название фазы',
            'max_duration' => 'Максимальное количесво дней',
            'sort_order' => 'Порядок сортировки',
        ];
    }

    /**
     * Gets query for [[LuProcesses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLuProcesses()
    {
        return $this->hasMany(LuProcess::className(), ['step_process' => 'id']);
    }

    /**
     * Gets query for [[StepPhase]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStepPhase()
    {
        return $this->hasOne(LuPhase::className(), ['id' => 'step_phase']);

    }
    public function getStPhases()
    {
        return $this->stepPhase->phase_name;
    }



}
