<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nsi_content".
 *
 * @property int $id
 * @property int $soli_id
 * @property int $class
 * @property int $cod
 * @property string $attr_textval
 * @property int|null $class_01 классификатор для филиала №1
 * @property int|null $cod_01 кодификатор для филиала № 1
 * @property int|null $class_02
 * @property int|null $cod_02
 * @property int|null $class_03
 * @property int|null $cod_03
 * @property int|null $class_04
 * @property int|null $cod_04
 * @property int|null $class_05
 * @property int|null $cod_05
 * @property int|null $class_06
 * @property int|null $cod_06
 * @property int|null $class_07
 * @property int|null $cod_07
 * @property int|null $class_08
 * @property int|null $cod_08
 * @property int|null $class_09
 * @property int|null $cod_09
 * @property int|null $class_10
 * @property int|null $cod_10
 * @property int|null $class_11
 * @property int|null $cod_11
 * @property int|null $class_12
 * @property int|null $cod_12
 * @property int|null $class_13
 * @property int|null $cod_13
 * @property int|null $class_14
 * @property int|null $cod_14
 * @property int|null $class_15
 * @property int|null $cod_15
 * @property int|null $class_16
 * @property int|null $cod_16
 * @property int|null $class_17
 * @property int|null $cod_17
 * @property int|null $class_18
 * @property int|null $cod_18
 * @property int|null $class_19
 * @property int|null $cod_19
 * @property int|null $class_20
 * @property int|null $cod_20
 * @property int|null $class_21
 * @property int|null $cod_21
 * @property int|null $class_22
 * @property int|null $cod_22
 * @property int|null $class_23
 * @property int|null $cod_23
 * @property int|null $class_24
 * @property int|null $cod_24
 * @property int|null $class_25
 * @property int|null $cod_25
 * @property int|null $class_26
 * @property int|null $cod_26
 * @property int|null $class_27
 * @property int|null $cod_27
 * @property int|null $class_28
 * @property int|null $cod_28
 * @property int|null $class_29
 * @property int|null $cod_29
 * @property int|null $class_30
 * @property int|null $cod_30
 * @property int|null $class_31
 * @property int|null $cod_31
 * @property int|null $class_32
 * @property int|null $cod_32
 * @property int|null $class_33
 * @property int|null $cod_33
 * @property int|null $class_34
 * @property int|null $cod_34
 * @property int|null $class_35
 * @property int|null $cod_35
 * @property int|null $class_36
 * @property int|null $cod_36
 * @property int|null $class_37
 * @property int|null $cod_37
 *
 * @property NsiInfo $soli
 */
class NsiContent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nsi_content';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['soli_id', 'class', 'cod', 'attr_textval'], 'required'],
            [['soli_id', 'class', 'cod', 'class_01', 'cod_01', 'class_02', 'cod_02', 'class_03', 'cod_03', 'class_04', 'cod_04', 'class_05', 'cod_05', 'class_06', 'cod_06', 'class_07', 'cod_07', 'class_08', 'cod_08', 'class_09', 'cod_09', 'class_10', 'cod_10', 'class_11', 'cod_11', 'class_12', 'cod_12', 'class_13', 'cod_13', 'class_14', 'cod_14', 'class_15', 'cod_15', 'class_16', 'cod_16', 'class_17', 'cod_17', 'class_18', 'cod_18', 'class_19', 'cod_19', 'class_20', 'cod_20', 'class_21', 'cod_21', 'class_22', 'cod_22', 'class_23', 'cod_23', 'class_24', 'cod_24', 'class_25', 'cod_25', 'class_26', 'cod_26', 'class_27', 'cod_27', 'class_28', 'cod_28', 'class_29', 'cod_29', 'class_30', 'cod_30', 'class_31', 'cod_31', 'class_32', 'cod_32', 'class_33', 'cod_33', 'class_34', 'cod_34', 'class_35', 'cod_35', 'class_36', 'cod_36', 'class_37', 'cod_37'], 'integer'],
            [['attr_textval'], 'string', 'max' => 60],
            [['soli_id'], 'exist', 'skipOnError' => true, 'targetClass' => NsiInfo::className(), 'targetAttribute' => ['soli_id' => 'soli_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'soli_id' => 'Код справочника (soli)',
            'class' => 'Классификатор',
            'cod' => 'Кодификатор',
            'attr_textval' => 'Название справочника',
            'class_01' => 'Классификатор 01',
            'cod_01' => 'Кодификатор 01',
            'class_02' => 'Классификатор 02',
            'cod_02' => 'Кодификатор 02',
            'class_03' => 'Классификатор 03',
            'cod_03' => 'Кодификатор 03',
            'class_04' => 'Классификатор 04',
            'cod_04' => 'Кодификатор 04',
            'class_05' => 'Классификатор 05',
            'cod_05' => 'Кодификатор 05',
            'class_06' => 'Классификатор 06',
            'cod_06' => 'Кодификатор 06',
            'class_07' => 'Классификатор 07',
            'cod_07' => 'Кодификатор 07',
            'class_08' => 'Классификатор 08',
            'cod_08' => 'Кодификатор 08',
            'class_09' => 'Классификатор 09',
            'cod_09' => 'Кодификатор 09',
            'class_10' => 'Классификатор 10',
            'cod_10' => 'Кодификатор 10',
            'class_11' => 'Классификатор 11',
            'cod_11' => 'Кодификатор 11',
            'class_12' => 'Классификатор 12',
            'cod_12' => 'Кодификатор 12',
            'class_13' => 'Классификатор 13',
            'cod_13' => 'Кодификатор 13',
            'class_14' => 'Классификатор 14',
            'cod_14' => 'Кодификатор 14',
            'class_15' => 'Классификатор 15',
            'cod_15' => 'Кодификатор 15',
            'class_16' => 'Классификатор 16',
            'cod_16' => 'Кодификатор 16',
            'class_17' => 'Классификатор 17',
            'cod_17' => 'Кодификатор 17',
            'class_18' => 'Классификатор 18',
            'cod_18' => 'Кодификатор 18',
            'class_19' => 'Классификатор 19',
            'cod_19' => 'Кодификатор 19',
            'class_20' => 'Классификатор 20',
            'cod_20' => 'Кодификатор 20',
            'class_21' => 'Классификатор 21',
            'cod_21' => 'Кодификатор 21',
            'class_22' => 'Классификатор 22',
            'cod_22' => 'Кодификатор 22',
            'class_23' => 'Классификатор 23',
            'cod_23' => 'Кодификатор 23',
            'class_24' => 'Классификатор 24',
            'cod_24' => 'Кодификатор 24',
            'class_25' => 'Классификатор 25',
            'cod_25' => 'Кодификатор 25',
            'class_26' => 'Классификатор 26',
            'cod_26' => 'Кодификатор 26',
            'class_27' => 'Классификатор 27',
            'cod_27' => 'Кодификатор 27',
            'class_28' => 'Классификатор 28',
            'cod_28' => 'Кодификатор 28',
            'class_29' => 'Классификатор 29',
            'cod_29' => 'Кодификатор 29',
            'class_30' => 'Классификатор 30',
            'cod_30' => 'Кодификатор 30',
            'class_31' => 'Классификатор 31',
            'cod_31' => 'Кодификатор 31',
            'class_32' => 'Классификатор 32',
            'cod_32' => 'Кодификатор 32',
            'class_33' => 'Классификатор 33',
            'cod_33' => 'Кодификатор 33',
            'class_34' => 'Классификатор 34',
            'cod_34' => 'Кодификатор 34',
            'class_35' => 'Классификатор 35',
            'cod_35' => 'Кодификатор 35',
            'class_36' => 'Классификатор 36',
            'cod_36' => 'Кодификатор 36',
            'class_37' => 'Классификатор 37',
            'cod_37' => 'Кодификатор 37',
        ];
    }

    /**
     * Gets query for [[Soli]].
     *
     * @return \yii\db\ActiveQuery
     */


    public function getSoli()
    {
        return $this->hasOne(NsiInfo::className(), ['soli_id' => 'soli_id']);
    }

    public function getSoliID()
    {
        return $this->soli->soli_id;
    }
}
