<?php

namespace app\modules\pd\models;

use Yii;

/**
 * This is the model class for table "forestry".
 *
 * @property int $id
 * @property int $subject_kod
 * @property int $forestry_kod
 * @property string $forestry_name
 */
class Forestry extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'forestry';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject_kod', 'forestry_kod', 'forestry_name'], 'required'],
            [['subject_kod', 'forestry_kod', 'removed'], 'integer'],
            [['forestry_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject_kod' => 'Subject Kod',
            'forestry_kod' => 'Forestry Kod',
            'forestry_name' => 'Forestry Name',
            'removed' => 'Ликвидировано',
        ];
    }

}
