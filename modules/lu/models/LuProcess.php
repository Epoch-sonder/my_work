<?php

namespace app\modules\lu\models;

use Yii;

/**
 * This is the model class for table "lu_process".
 *
 * @property int $id
 * @property int $lu_zakup_card  id объекта
 * @property int $step_process id стадии
 * @property string $person_responsible фио ответственного
 * @property float $volume Объем
 * @property float $staff Кадровые
 * @property string $mtr Материально-технические ресурсы
 * @property string $date_finish Конец стадии
 * @property int $reporter фио заполняющего
 * @property string $timestamp
 *
 * @property LuObject $luObject
 * @property LuProcessStep $stepProcess
 */
class LuProcess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lu_process';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lu_zakup_card', 'step_process', 'person_responsible', 'date_finish', 'reporter'], 'required'],
            [['lu_zakup_card', 'step_process', 'reporter'], 'integer'],
            [['volume', 'staff'], 'number'],
            [['date_finish', 'timestamp'], 'safe'],
            [['person_responsible'], 'string', 'max' => 50],
            [['mtr'], 'string', 'max' => 255],
            [['lu_zakup_card'], 'exist', 'skipOnError' => true, 'targetClass' => LuObject::className(), 'targetAttribute' => ['lu_zakup_card' => 'id']],
            [['step_process'], 'exist', 'skipOnError' => true, 'targetClass' => LuProcessStep::className(), 'targetAttribute' => ['step_process' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '',
            'lu_zakup_card' => '',
            'step_process' => '',
            'person_responsible' => '',
            'volume' => '',
            'staff' => '',
            'mtr' => '',
            'date_finish' => '',
            'reporter' => '',
            'timestamp' => '',
        ];
    }

    /**
     * Gets query for [[LuObject]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLuObject()
    {
        return $this->hasOne(LuZakupCard::className(), ['id' => 'lu_zakup_card']);
    }

    /**
     * Gets query for [[StepProcess]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStepProcess()
    {
        return $this->hasOne(LuProcessStep::className(), ['id' => 'step_process']);
    }

    public static function getProcessST(){
        return LuProcessStep::find()->orderBy('sort_order ASC')->all();

    }

    public $dateST;


//    public function validateData()
//    {
//
//
//        if ($dateSTend || !$user->validatePassword($this->password)) {
//            $this->addError('password', 'Incorrect username or password.');
//        }
//    }

}
