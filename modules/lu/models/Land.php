<?php

namespace app\modules\lu\models;

use Yii;

/**
 * This is the model class for table "land".
 *
 * @property int $land_id
 * @property string|null $name
 *
 * @property LuZakupCard[] $luZakupCards
 * @property Object[] $objects
 */
class Land extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'land';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['land_id'], 'required'],
            [['land_id'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['land_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'land_id' => 'Land ID',
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
        return $this->hasMany(LuZakupCard::className(), ['land_cat' => 'land_id']);
    }

    /**
     * Gets query for [[Objects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getObjects()
    {
        return $this->hasMany(Object::className(), ['land_id' => 'land_id']);
    }
}
