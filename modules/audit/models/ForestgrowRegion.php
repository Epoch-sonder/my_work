<?php

namespace app\modules\audit\models;

use Yii;

/**
 * This is the model class for table "forestgrow_region".
 *
 * @property int $id
 * @property int $forestgrow_zone
 * @property string $name
 *
 * @property ForestgrowZone $forestgrowZone
 * @property ForestgrowRegionSubject[] $forestgrowRegionSubjects
 */
class ForestgrowRegion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'forestgrow_region';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['forestgrow_zone', 'name'], 'required'],
            [['forestgrow_zone'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['forestgrow_zone'], 'exist', 'skipOnError' => true, 'targetClass' => ForestgrowZone::className(), 'targetAttribute' => ['forestgrow_zone' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'forestgrowZoneName' => 'Лесорастительная зона',
            'name' => 'Название района',
        ];
    }

    /**
     * Gets query for [[ForestgrowZone]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getForestgrowZone()
    {
        return $this->hasOne(ForestgrowZone::className(), ['id' => 'forestgrow_zone']);
    }
    public function getForestgrowZoneName()
    {
        return $this->forestgrowZone->name;

    }
    /**
     * Gets query for [[ForestgrowRegionSubjects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getForestgrowRegionSubjects()
    {
        return $this->hasMany(ForestgrowRegionSubject::className(), ['region_id' => 'id' ]);
    }

    
}
