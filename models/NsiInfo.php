<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nsi_info".
 *
 * @property int $soli_id
 * @property string $attr_name Описание
 * @property int|null $maket_numb № макета
 * @property int|null $pole_numb № поля
 * @property string|null $winplp
 * @property int|null $pl
 * @property string|null $topol
 *
 * @property NsiContent[] $nsiContents
 */
class NsiInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nsi_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['soli_id', 'attr_name'], 'required'],
            [['soli_id', 'maket_numb', 'pole_numb', 'pl'], 'integer'],
            [['attr_name'], 'string', 'max' => 50],
            [['winplp'], 'string', 'max' => 10],
            [['topol'], 'string', 'max' => 20],
            [['soli_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function attributeLabels()
    {
        return [
            'soli_id' => 'Код справочника (soli)',
            'attr_name' => 'Описание',
            'maket_numb' => 'Номер макета',
            'pole_numb' => 'Номер поля',
            'winplp' => 'Winplp',
            'pl' => 'Pl',
            'topol' => 'Topol',
        ];
    }

    /**
     * Gets query for [[NsiContents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNsiContents()
    {
        return $this->hasMany(NsiContent::className(), ['soli_id' => 'soli_id']);
    }
}
