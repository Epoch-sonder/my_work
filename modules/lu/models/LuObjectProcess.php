<?php

namespace app\modules\lu\models;

use Yii;

/**
 * This is the model class for table "lu_object_process".
 *
 * @property int $id
 * @property int $lu_object
 * @property int $lu_process_step
 * @property int $month
 * @property int $year
 * @property float $plan
 * @property float $fact
 * @property string $timestamp
 *
 * @property LuObject $luObject
 * @property LuProcessStep $luProcessStep
 * @property Month $month0
 */
class LuObjectProcess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lu_object_process';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lu_object', 'lu_process_step', 'month', 'year', 'plan', 'fact'], 'required'],
            [['lu_object', 'lu_process_step', 'month', 'year'], 'integer'],
            [['plan', 'fact'], 'number'],
            [['timestamp'], 'safe'],
            [['lu_object'], 'exist', 'skipOnError' => true, 'targetClass' => LuObject::className(), 'targetAttribute' => ['lu_object' => 'id']],
            [['lu_process_step'], 'exist', 'skipOnError' => true, 'targetClass' => LuProcessStep::className(), 'targetAttribute' => ['lu_process_step' => 'id']],
            [['month'], 'exist', 'skipOnError' => true, 'targetClass' => Month::className(), 'targetAttribute' => ['month' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lu_object' => 'id объекта',
            'lu_process_step' => 'id шага процесса',
            'month' => 'месяц',
            'year' => 'год',
            'plan' => 'Плановая',
            'fact' => 'Фактическая',
            'timestamp' => 'Timestamp',
        ];
    }

    /**
     * Gets query for [[LuObject]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLuObject()
    {
        return $this->hasOne(LuObject::className(), ['id' => 'lu_object']);
    }

    /**
     * Gets query for [[LuProcessStep]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLuProcessStep()
    {
        return $this->hasOne(LuProcessStep::className(), ['id' => 'lu_process_step']);
    }

    /**
     * Gets query for [[Month0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMonth0()
    {
        return $this->hasOne(Month::className(), ['id' => 'month']);
    }
    public function getMonth()
    {
        return $this->month0->name;
    }
}
