<?php

namespace app\modules\lu\models;

use Yii;

/**
 * This is the model class for table "lu_zakup_card".
 *
 * @property int $id
 * @property string $zakup_num Реестровый номер закупки
 * @property string|null $zakup_link ссылка на страницу закупки
 * @property int $contest_type способ определения поставщика
 * @property string $date_placement дата размещения
 * @property float $price_start Начальная цена
 * @property int $contract_type ГК или договор
 * @property int $finsource_type тип источника финансирования
 * @property string $customer_name Наименование заказчика
 * @property int $land_cat Категория земель
 * @property int $fed_subject Субъект РФ
 * @property string|null $region Лесничество/район/ООПТ
 * @property string|null $region_subdiv уч. лесн, урочище, кварталы
 * @property int|null $dzz_type Тип съемки ДЗЗ
 * @property float|null $dzz_resolution Пространственное разрешение ДЗЗ
 * @property int|null $dzz_request_sent Отправлен запрос на КП по ДЗЗ
 * @property float|null $dzz_cost Стоимость ДЗЗ из полученного КП
 * @property int|null $smp_attraction Объем привлечения субъектов малого предпринимательства, %
 * @property string $timestamp
 *
 * @property Land $landCat
 * @property Finsource $finsourceType
 * @property ContestType $contestType
 * @property ContractType $contractType
 * @property FederalSubject $fedSubject
 */
class ZakupCard extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lu_zakup_card';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['zakup_num', 'contest_type', 'date_placement', 'price_start', 'contract_type', 'finsource_type', 'customer_name', 'land_cat', 'fed_subject'], 'required'],
            [['contest_type', 'contract_type', 'finsource_type', 'land_cat', 'fed_subject', 'dzz_type', 'dzz_request_sent', 'smp_attraction', 'winner_we'], 'integer'],
            [['date_placement', 'timestamp', 'date_contract_start', 'date_contract_finish', 'dzz_control_date','date_preparatory','date_field','date_cameral'], 'safe'],
            [['price_start', 'dzz_resolution', 'dzz_cost', 'price_final', 'price_rli'], 'number'],
            [['zakup_num'], 'string', 'max' => 20],
            [['zakup_link', 'region_subdiv', 'winner_name'], 'string', 'max' => 255],
            [['customer_name', 'region'], 'string', 'max' => 100],
            [['contract_num', 'region'], 'string', 'max' => 50],
            [['land_cat'], 'exist', 'skipOnError' => true, 'targetClass' => Land::className(), 'targetAttribute' => ['land_cat' => 'land_id']],
            [['finsource_type'], 'exist', 'skipOnError' => true, 'targetClass' => Finsource::className(), 'targetAttribute' => ['finsource_type' => 'id']],
            [['contest_type'], 'exist', 'skipOnError' => true, 'targetClass' => ContestType::className(), 'targetAttribute' => ['contest_type' => 'id']],
            [['contract_type'], 'exist', 'skipOnError' => true, 'targetClass' => ContractType::className(), 'targetAttribute' => ['contract_type' => 'id']],
            [['fed_subject'], 'exist', 'skipOnError' => true, 'targetClass' => FederalSubject::className(), 'targetAttribute' => ['fed_subject' => 'federal_subject_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'zakup_num' => 'Реестровый номер',
            'zakup_link' => 'Ссылка на страницу с закупкой',
            'contest_type' => 'Определение поставщика',
            'contestTypeName' => 'Определение поставщика',
            'date_placement' => 'Дата размещения',
            'price_start' => 'Начальная цена',
            'contract_type' => 'Тип контракта',
            'contractTypeName' => 'Тип контракта',
            'contract_num' => 'Номер контракта',
            'finsource_type' => 'Источник финансирования',
            'finsourceName' => 'Источник финансирования',
            'customer_name' => 'Заказчик',
            'land_cat' => 'Категория земель',
            'landCatName' => 'Категория земель',
            'fed_subject' => 'Субъект РФ',
            'fedSubjectName' => 'Субъект РФ',
            'region' => 'Район/Лесничество/ООПТ',
            'region_subdiv' => 'уч. лесничество, урочище, кварталы',
            'dzz_type' => 'Тип съемки',
            'dzzTypeName' => 'Тип съемки',
            'dzz_resolution' => 'Разрешение, m/px',
            'dzz_request_sent' => 'Отправлены запросы КП на ДЗЗ',
            'dzzRequestSent' => 'Отправлены запросы КП на ДЗЗ',
            'dzz_control_date' => 'Контрольная дата получения КП',
            'dzz_cost' => 'Стоимость ДЗЗ из КП',
            'smp_attraction' => 'Объем привлечения СМП, %',

            'price_final' => 'Окончательная цена',
            'price_rli' => 'Цена РЛИ',
            'winner_we' => 'Победитель: Рослесинфорг',
            'winner_name' => 'Наименование победителя',
            'date_contract_start' => 'Дата подписания',
            'date_contract_finish' => 'Дата завершения',

            'date_preparatory' => 'Окончание подготовительных работ',
            'date_field' => 'Окончание полевых работ',
            'date_cameral' => 'Окончание камеральных работ',


            'timestamp' => 'Timestamp',
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

    public function getLandCatName() {
        return $this->landCat->name;
    }


    /**
     * Gets query for [[FinsourceType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFinsourceType()
    {
        return $this->hasOne(Finsource::className(), ['id' => 'finsource_type']);
    }

    public function getFinsourceName()
    {
        return $this->finsourceType->name;
    }


    /**
     * Gets query for [[ContestType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContestType()
    {
        return $this->hasOne(ContestType::className(), ['id' => 'contest_type']);
    }

    public function getContestTypeName()
    {
        return $this->contestType->name;
    }



    /**
     * Gets query for [[ContractType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContractType()
    {
        return $this->hasOne(ContractType::className(), ['id' => 'contract_type']);
    }

    public function getContractTypeName() {
        return $this->contractType->name;
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

    public function getFedSubjectName() {
        return $this->fedSubject->name;
    }




    public function getDzzType()
    {
        return $this->hasOne(DzzType::className(), ['id' => 'dzz_type']);
    }

    public function getDzzTypeName() {
        return $this->dzzType->name;
    }




    public function getDzzRequestSent() {
        if ($this->dzz_request_sent == 1 ) return 'Да';
        else return 'Нет';
    }


}
