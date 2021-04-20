<?php

namespace app\modules\audit\models;

use Yii;

/**
 * This is the model class for table "forestgrow_zone".
 *
 * @property int $id
 * @property string $name
 *
 * @property ForestgrowRegion[] $forestgrowRegions
 */
class ForestgrowZone extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'forestgrow_zone';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
        ];
    }

    /**
     * Gets query for [[ForestgrowRegions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getForestgrowRegions()
    {
        return $this->hasMany(ForestgrowRegion::className(), ['forestgrow_zone' => 'id']);
    }
}
