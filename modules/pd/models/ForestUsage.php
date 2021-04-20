<?php

namespace app\modules\pd\models;

use Yii;

/**
 * This is the model class for table "forest_usage".
 *
 * @property int $id
 * @property string $usage_name
 *
 * @property PdWork[] $pdWorks
 */
class ForestUsage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'forest_usage';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usage_name'], 'required'],
            [['usage_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usage_name' => 'Usage Name',
        ];
    }

    /**
     * Gets query for [[PdWorks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPdWorks()
    {
        return $this->hasMany(PdWork::className(), ['forest_usage' => 'id']);
    }
}
