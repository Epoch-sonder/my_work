<?php

namespace app\modules\pd\models;

use Yii;

/**
 * This is the model class for table "subdivs".
 *
 * @property int $id
 * @property int $subject_kod
 * @property int $forestry_kod
 * @property int $subforestry_kod
 * @property int $subdiv_kod
 * @property string $subdiv_name
 */
class Subdivs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subdivs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject_kod', 'forestry_kod', 'subforestry_kod', 'subdiv_kod', 'subdiv_name'], 'required'],
            [['subject_kod', 'forestry_kod', 'subforestry_kod', 'subdiv_kod'], 'integer'],
            [['subdiv_name'], 'string', 'max' => 255],
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
            'subforestry_kod' => 'Subforestry Kod',
            'subdiv_kod' => 'Subdiv Kod',
            'subdiv_name' => 'Subdiv Name',
        ];
    }
}
