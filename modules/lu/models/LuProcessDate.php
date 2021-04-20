<?php

namespace app\modules\lu\models;

use Yii;

/**
 * This is the model class for table "lu_process_date".
 *
 * @property int $id
 * @property int $zakup_card
 * @property int $process_step
 * @property string $date_start
 *
 * @property LuProcessStep $processStep
 * @property LuZakupCard $zakupCard
 */
class LuProcessDate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lu_process_date';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['zakup_card', 'process_step', 'date_start'], 'required'],
            [['zakup_card', 'process_step'], 'integer'],
            [['date_start'], 'safe'],
            [['process_step'], 'exist', 'skipOnError' => true, 'targetClass' => LuProcessStep::className(), 'targetAttribute' => ['process_step' => 'id']],
            [['zakup_card'], 'exist', 'skipOnError' => true, 'targetClass' => LuZakupCard::className(), 'targetAttribute' => ['zakup_card' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'zakup_card' => 'Zakup Card',
            'process_step' => 'Process Step',
            'date_start' => 'Date Start',
        ];
    }

    /**
     * Gets query for [[ProcessStep]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProcessStep()
    {
        return $this->hasOne(LuProcessStep::className(), ['id' => 'process_step']);
    }

    /**
     * Gets query for [[ZakupCard]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getZakupCard()
    {
        return $this->hasOne(LuZakupCard::className(), ['id' => 'zakup_card']);
    }
}
