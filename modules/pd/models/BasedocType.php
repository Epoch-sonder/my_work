<?php

namespace app\modules\pd\models;

use Yii;

/**
 * This is the model class for table "basedoc_type".
 *
 * @property int $id
 * @property string $doctype
 *
 * @property PdWork[] $pdWorks
 */
class BasedocType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'basedoc_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['doctype'], 'required'],
            [['doctype'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'doctype' => 'Doctype',
        ];
    }

    /**
     * Gets query for [[PdWorks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPdWorks()
    {
        return $this->hasMany(PdWork::className(), ['basedoc_type' => 'id']);
    }
}
