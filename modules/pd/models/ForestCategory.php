<?php

namespace app\modules\pd\models;

use Yii;

/**
 * This is the model class for table "forest_category".
 *
 * @property int $id
 * @property string $protection_category
 */
class ForestCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'forest_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['protection_category'], 'required'],
            [['protection_category'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'protection_category' => 'Protection Category',
        ];
    }
}
