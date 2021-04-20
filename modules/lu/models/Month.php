<?php

namespace app\modules\lu\models;

use Yii;

/**
 * This is the model class for table "month".
 *
 * @property int $id
 * @property string $name
 *
 * @property LuObjectProcess[] $luObjectProcesses
 */
class Month extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'month';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[LuObjectProcesses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLuObjectProcesses()
    {
        return $this->hasMany(LuObjectProcess::className(), ['month' => 'id']);
    }
}
