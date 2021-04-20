<?php

namespace app\modules\lu\models;

use Yii;

/**
 * This is the model class for table "contract_type".
 *
 * @property int $id
 * @property string $name
 *
 * @property LuZakupCard[] $luZakupCards
 */
class ContractType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contract_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 40],
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
        return $this->hasMany(LuZakupCard::className(), ['contract_type' => 'id']);
    }
}
