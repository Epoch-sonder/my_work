<?php

namespace app\modules\pd\models;

use Yii;

/**
 * This is the model class for table "pd_worktype".
 *
 * @property int $id
 * @property string $work_name
 * @property int|null $average_cost средняя стоимость, руб.
 * @property int|null $average_humanday средние затраты человеко-дней
 */
class PdWorktype extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pd_worktype';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['work_name'], 'required'],
            [['average_cost', 'average_humanday'], 'integer'],
            [['work_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'work_name' => 'Наименование работ',
            'average_cost' => 'Средние затраты, руб.',
            'average_humanday' => 'Среднее количество человеко-дней',
        ];
    }
}
