<?php

namespace app\modules\lu\models;

use app\models\OoptBinding;
use Yii;

/**
 * This is the model class for table "lu_object".
 *
 * @property int $id
 * @property int $zakup id закупки в таблице закупок
 * @property int $land_cat Категория земель
 * @property int $fed_subject Субъект РФ
 * @property int $region Лесничество/ООПТ/район
 * @property int $region_subdiv Уч. лесничество
 * @property int $taxation_way Способ таксации
 * @property int $taxwork_cat Разряд работ
 * @property int $taxwork_vol Объем работ
 * @property int $stage_prepare_vol Объем подготовительных работ
 * @property int $stage_prepare_year Год подготовительных работ
 * @property int $stage_field_vol Объем полевых работ
 * @property int $stage_field_year Год полевых работ
 * @property int $stage_cameral_vol Объем камеральных работ
 * @property int $stage_cameral_year Год камеральных работ
 *
 * @property Land $landCat
 * @property FederalSubject $fedSubject
 * @property TaxationWay $taxationWay
 * @property TaxworkCategory $taxworkCat
 * @property LuZakupCard $zakup0
 */
class LuObject extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lu_object';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['zakup', 'land_cat', 'fed_subject', 'region', 'taxation_way', 'taxwork_cat'], 'required'],
            [['zakup', 'land_cat', 'fed_subject', 'region', 'region_subdiv', 'taxation_way', 'taxwork_cat', 'taxwork_vol', 'stage_prepare_vol', 'stage_prepare_year', 'stage_field_vol', 'stage_field_year', 'stage_cameral_vol', 'stage_cameral_year'], 'integer'],
            [['land_cat'], 'exist', 'skipOnError' => true, 'targetClass' => Land::className(), 'targetAttribute' => ['land_cat' => 'land_id']],
            [['fed_subject'], 'exist', 'skipOnError' => true, 'targetClass' => FederalSubject::className(), 'targetAttribute' => ['fed_subject' => 'federal_subject_id']],
            [['taxation_way'], 'exist', 'skipOnError' => true, 'targetClass' => TaxationWay::className(), 'targetAttribute' => ['taxation_way' => 'id']],
            [['taxwork_cat'], 'exist', 'skipOnError' => true, 'targetClass' => TaxworkCategory::className(), 'targetAttribute' => ['taxwork_cat' => 'id']],
            [['zakup'], 'exist', 'skipOnError' => true, 'targetClass' => ZakupCard::className(), 'targetAttribute' => ['zakup' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID объекта',
            'zakup' => 'ID закупки',
            'land_cat' => 'Категория земель',
            'landCatName' => 'Категория земель',
            'fed_subject' => 'Субъект РФ',
            'fedSubjectName' => 'Субъект РФ',
            'region' => 'Район/ООПТ/лесничество',
            'region_subdiv' => 'уч. лесничество',
            'forestryName' => 'Лесничество',
            'forestryDefenseName' => 'Лесничество',
            'subforestryName' => 'уч. лесничество',
            'subforestryDefenseName' => 'уч. лесничество',
            'oopt' => 'ООПТ',
            'cityregion' => 'Район',
            'taxation_way' => 'Способ таксации',
            'taxationWayName' => 'Способ таксации',
            'taxwork_cat' => 'Разряд работ',
            'taxworkCatName' => 'Разряд',
            'taxwork_vol' => 'Общий объем',
            'stage_prepare_vol' => 'Подготовительные работы, объем',
            'stage_prepare_year' => 'Подготовительные работы, год',
            'stage_field_vol' => 'Полевые работы, объем',
            'stage_field_year' => 'Полевые работы, год',
            'stage_cameral_vol' => 'Камеральные работы, объем',
            'stage_cameral_year' => 'Камеральные работы, год',
            'stagePrepare' => 'Подготовительные работы',
            'stageField' => 'Полевые работы',
            'stageCameral' => 'Камеральные работы',
        ];
    }

    /**
     * Gets query for [[LandCat]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLandCat()
    {
        return $this->hasOne(Land::className(), ['land_id' => 'land_cat']);
    }

    public function getLandCatName()
    {
        return $this->landCat->name;
    }



    /**
     * Gets query for [[FedSubject]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFedSubject()
    {
        return $this->hasOne(FederalSubject::className(), ['federal_subject_id' => 'fed_subject']);
    }

    public function getFedSubjectName()
    {
        return $this->fedSubject->name;
    }




    public function getForestry()
    {
        return $this->hasOne(Forestry::className(), ['subject_kod' => 'fed_subject', 'forestry_kod' => 'region']);
    }

    public function getForestryName()
    {
        return $this->forestry->forestry_name;
    }



    public function getSubforestry()
    {
        return $this->hasOne(Subforestry::className(), ['subject_kod' => 'fed_subject', 'forestry_kod' => 'region', 'subforestry_kod' => 'region_subdiv']);
    }

    public function getSubforestryName()
    {
        return $this->subforestry->subforestry_name;
    }



    public function getForestryDefense()
    {
        return $this->hasOne(ForestryDefense::className(), ['subject_kod' => 'fed_subject', 'forestry_kod' => 'region']);
    }

    public function getForestryDefenseName()
    {
        return $this->forestryDefense->forestry_name;
    }



    public function getSubforestryDefense()
    {
        return $this->hasOne(SubforestryDefense::className(), ['subject_kod' => 'fed_subject', 'forestry_kod' => 'region', 'subforestry_kod' => 'region_subdiv']);
    }

    public function getSubforestryDefenseName()
    {
        return $this->subforestryDefense->subforestry_name;
    }



    public function getOopt()
    {
        return $this->hasOne(OoptBinding::className(), ['oopt' => 'fed_subject',]);
    }

    public function getOoptName()
    {
        return $this->oopt->oopt_name;
    }



    public function getCityregion()
    {
        return $this->hasOne(Cityregion::className(), ['subject_kod' => 'fed_subject', 'cityregion_kod' => 'region']);
    }

    public function getCityregionName()
    {
        return $this->cityregion->cityregion_name;
    }



    public function getStagePrepare()
    {
        return $this->stage_prepare_vol . ' га, ' . $this->stage_prepare_year;
    }

    public function getStageField()
    {
        return $this->stage_field_vol . ' га, ' . $this->stage_field_year;
    }

    public function getStageCameral()
    {
        return $this->stage_cameral_vol . ' га, ' . $this->stage_cameral_year;
    }



    /**
     * Gets query for [[TaxationWay]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaxationWay()
    {
        return $this->hasOne(TaxationWay::className(), ['id' => 'taxation_way']);
    }

    public function getTaxationWayName()
    {
        return $this->taxationWay->name;
    }



    /**
     * Gets query for [[TaxworkCat]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaxworkCat()
    {
        return $this->hasOne(TaxworkCategory::className(), ['id' => 'taxwork_cat']);
    }

    public function getTaxworkCatName()
    {
        return $this->taxworkCat->category;
    }



    /**
     * Gets query for [[Zakup0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getZakup0()
    {
        return $this->hasOne(ZakupCard::className(), ['id' => 'zakup']);
    }
}
