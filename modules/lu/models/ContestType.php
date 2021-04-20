<?php

namespace app\modules\lu\models;

use Yii;

/**
 * This is the model class for table "contest_type".
 *
 * @property int $id
 * @property string $name
 *
 * @property LuZakupCard[] $luZakupCards
 */
class ContestType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contest_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
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
     * Gets query for [[LuZakupCards]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLuZakupCards()
    {
        return $this->hasMany(LuZakupCard::className(), ['contest_type' => 'id']);
    }
}
