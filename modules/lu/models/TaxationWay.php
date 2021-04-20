<?php

namespace app\modules\lu\models;

use Yii;

/**
 * This is the model class for table "taxation_way".
 *
 * @property int $id
 * @property string $name Способ таксации
 *
 * @property LuObject[] $luObjects
 */
class TaxationWay extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'taxation_way';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 200],
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
     * Gets query for [[LuObjects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLuObjects()
    {
        return $this->hasMany(LuObject::className(), ['taxation_way' => 'id']);
    }
}
