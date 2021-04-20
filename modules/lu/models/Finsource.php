<?php

namespace app\modules\lu\models;

use Yii;

/**
 * This is the model class for table "finsource".
 *
 * @property int $id
 * @property string $name
 *
 * @property LuZakupCard[] $luZakupCards
 */
class Finsource extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'finsource';
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
        return $this->hasMany(LuZakupCard::className(), ['finsource_type' => 'id']);
    }
}
