<?php

namespace app\modules\pd\models;

use Yii;

/**
 * This is the model class for table "pd_work_docs".
 *
 * @property int $id
 * @property int $file_name
 * @property int $pd_work
 */
class PdWorkDocs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pd_work_docs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file_name', 'pd_work'], 'required'],
            [['file_name', 'pd_work'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file_name' => 'File Name',
            'pd_work' => 'Pd Work',
        ];
    }
}
