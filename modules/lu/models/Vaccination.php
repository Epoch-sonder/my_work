<?php

namespace app\modules\lu\models;

use Yii;

/**
 * This is the model class for table "vaccination".
 *
 * @property int $id
 * @property int $person_id
 * @property string|null $first_vaccination
 * @property string|null $second_vaccination
 * @property string|null $third_vaccination
 * @property int|null $url_docs
 * @property int|null $verified
 */
class Vaccination extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $date_cheak;
    public $vaccin;

    public static function tableName()
    {
        return 'vaccination';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['person_id','date_cheak','vaccin'], 'required'],
            [['verified'], 'integer'],
            [['first_vaccination', 'second_vaccination', 'third_vaccination','date_cheak','vaccin'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
//            'person_id' => 'Person ID',
            'first_vaccination' => 'First Vaccination',
            'second_vaccination' => 'Second Vaccination',
            'third_vaccination' => 'Third Vaccination',
            'url_docs' => 'Url Docs',
            'verified' => 'Verified',
            'date_cheak' => 'Дата вакцины',
            'person_id' => 'Специалистов',
            'Vaccin' => 'Документы',
        ];
    }
}
