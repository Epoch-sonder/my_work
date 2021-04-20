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
 * @property int $finsource_type тип источника финансирования
 * @property int|null $smp_attraction Объем привлечения субъектов малого предпринимательства, %
 * @property string $customer_name Наименование заказчика
 * @property int $land_cat Категория земель
 * @property int $fed_subject Субъект РФ
 * @property string|null $region Лесничество/район/ООПТ
 * @property string|null $region_subdiv уч. лесн, урочище, кварталы
 * @property int|null $dzz_type Тип съемки ДЗЗ
 * @property float|null $dzz_resolution Пространственное разрешение ДЗЗ
 * @property int|null $dzz_request_sent Отправлен запрос на КП по ДЗЗ
 * @property string|null $dzz_control_date Контрольная дата получения КП
 * @property float|null $dzz_cost Стоимость ДЗЗ из полученного КП
 * @property int|null $winner_we Победил Рослесинфорг
 * @property string|null $winner_name Наименование победителя
 * @property float|null $price_final Окончательная цена
 * @property float|null $price_rli Цена, предложенная ФГБУ "Рослесинфорг
 * @property int $contract_type ГК или договор
 * @property string|null $contract_num Номер заключенного контракта
 * @property string|null $date_contract_start Дата подписания контракта
 * @property string|null $date_contract_finish Дата окончания контракта
 * @property string $timestamp
 *
 * @property LuObject[] $luObjects
 * @property LuProcess[] $luProcesses
 * @property Land $landCat
 * @property Finsource $finsourceType
 * @property ContestType $contestType
 * @property ContractType $contractType
 * @property FederalSubject $fedSubject
 */
class LuZakupCard extends \yii\db\ActiveRecord
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
            [['zakup_num', 'contest_type', 'date_placement', 'price_start', 'finsource_type', 'customer_name', 'land_cat', 'fed_subject', 'contract_type'], 'required'],
            [['contest_type', 'finsource_type', 'smp_attraction', 'land_cat', 'fed_subject', 'dzz_type', 'dzz_request_sent', 'winner_we', 'contract_type'], 'integer'],
            [['date_placement', 'dzz_control_date', 'date_contract_start', 'date_contract_finish', 'timestamp'], 'safe'],
            [['price_start', 'dzz_resolution', 'dzz_cost', 'price_final', 'price_rli'], 'number'],
            [['zakup_num'], 'string', 'max' => 20],
            [['zakup_link', 'region_subdiv', 'winner_name'], 'string', 'max' => 255],
            [['customer_name', 'region'], 'string', 'max' => 100],
            [['contract_num'], 'string', 'max' => 50],
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
            'zakup_num' => 'Zakup Num',
            'zakup_link' => 'Zakup Link',
            'contest_type' => 'Contest Type',
            'date_placement' => 'Date Placement',
            'price_start' => 'Price Start',
            'finsource_type' => 'Finsource Type',
            'smp_attraction' => 'Smp Attraction',
            'customer_name' => 'Customer Name',
            'land_cat' => 'Land Cat',
            'fed_subject' => 'Fed Subject',
            'region' => 'Region',
            'region_subdiv' => 'Region Subdiv',
            'dzz_type' => 'Dzz Type',
            'dzz_resolution' => 'Dzz Resolution',
            'dzz_request_sent' => 'Dzz Request Sent',
            'dzz_control_date' => 'Dzz Control Date',
            'dzz_cost' => 'Dzz Cost',
            'winner_we' => 'Winner We',
            'winner_name' => 'Winner Name',
            'price_final' => 'Price Final',
            'price_rli' => 'Price Rli',
            'contract_type' => 'Contract Type',
            'contract_num' => 'Contract Num',
            'date_contract_start' => 'Date Contract Start',
            'date_contract_finish' => 'Date Contract Finish',
            'timestamp' => 'Timestamp',
        ];
    }

    /**
     * Gets query for [[LuObjects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLuObjects()
    {
        return $this->hasMany(LuObject::className(), ['zakup' => 'id']);
    }

    /**
     * Gets query for [[LuProcesses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLuProcesses()
    {
        return $this->hasMany(LuProcess::className(), ['zakup' => 'id']);
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

    /**
     * Gets query for [[FinsourceType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFinsourceType()
    {
        return $this->hasOne(Finsource::className(), ['id' => 'finsource_type']);
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

    /**
     * Gets query for [[ContractType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContractType()
    {
        return $this->hasOne(ContractType::className(), ['id' => 'contract_type']);
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
}
