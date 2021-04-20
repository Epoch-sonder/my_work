<?php

namespace app\modules\pd\models;

use Yii;

/**
 * This is the model class for table "pd_step".
 *
 * @property int $id
 * @property string $step_name
 *
 * @property PdWorkProcess[] $pdWorkProcesses
 */
class PdStep extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pd_step';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['step_name'], 'required'],
            [['step_name'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'step_name' => 'Step Name',
        ];
    }

    /**
     * Gets query for [[PdWorkProcesses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPdWorkProcesses()
    {
        return $this->hasMany(PdWorkProcess::className(), ['pd_step' => 'id']);
    }
}
