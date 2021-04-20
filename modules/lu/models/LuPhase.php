<?php

namespace app\modules\lu\models;

use Yii;

/**
 * This is the model class for table "lu_phase".
 *
 * @property int $id
 * @property string $phase_name Название фазы
 * @property string $phase_number Номер фазы
 * @property int $sort_order порядок сортировки
 *
 * @property LuProcessStep[] $luProcessSteps
 */
class LuPhase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lu_phase';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phase_name', 'phase_number', 'sort_order'], 'required'],
            [['sort_order'], 'integer'],
            [['phase_name'], 'string', 'max' => 255],
            [['phase_number'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phase_name' => 'Название фазы',
            'phase_number' => 'Номер фазы',
            'sort_order' => 'Порядок сортировки',
        ];
    }

    /**
     * Gets query for [[LuProcessSteps]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLuProcessSteps()
    {
        return $this->hasMany(LuProcessStep::className(), ['step_phase' => 'id']);
    }
}
