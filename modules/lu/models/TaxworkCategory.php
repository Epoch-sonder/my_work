<?php

namespace app\modules\lu\models;

use Yii;

/**
 * This is the model class for table "taxwork_category".
 *
 * @property int $id
 * @property string $category Разряд работ
 *
 * @property LuObject[] $luObjects
 */
class TaxworkCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'taxwork_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category'], 'required'],
            [['category'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => 'Category',
        ];
    }

    /**
     * Gets query for [[LuObjects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLuObjects()
    {
        return $this->hasMany(LuObject::className(), ['taxwork_cat' => 'id']);
    }
}
