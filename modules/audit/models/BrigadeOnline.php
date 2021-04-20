<?php

namespace app\modules\audit\models;

use Yii;

/**
 * This is the model class for table "brigade_online".
 *
 * @property int $id
 * @property int $brigade_number
 * @property string $date_report
 * @property string|null $remark
 */
class BrigadeOnline extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'brigade_online';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['brigade_number', 'date_report'], 'required'],
            [['brigade_number'], 'integer'],
            [['date_report'], 'safe'],
            [['remark'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brigade_number' => 'Номер бригады',
            'date_report' => 'Дата отчета',
            'remark' => 'Примечание',
        ];
    }
}
