<?php

namespace app\modules\pd\models;

use Yii;

/**
 * This is the model class for table "pd_work".
 *
 * @property int $id
 * @property string $executor
 * @property int $branch
 * @property string $customer
 * @property int $basedoc_type
 * @property string $basedoc_name
 * @property string $basedoc_datasign
 * @property string $basedoc_datefinish
 * @property string $data_order
 * @property int $work_cost
 * @property string $work_datastart
 * @property int $federal_subject
 * @property int $forestry
 * @property int $subforestry
 * @property int $subdivforestry
 * @property int $quarter
 * @property float $work_area
 * @property int $wotk_name
 * @property int $forest_usage
 * @property string $comment
 * @property string $timestamp
 *
 * @property PdWorkProcess $id0
 * @property Branch $branch0
 * @property BasedocType $basedocType
 * @property PdWorktype $wotkName
 * @property ForestUsage $forestUsage
 */
class PdWork extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pd_work';
    }


    public $pdworktype; // наименование работ по проектной документации
    public $branchname; // наименование филиала
    public $docName; 
    public $forestry_qnty;
    public $row_qnty;
    public $work_type;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['branch', 'customer', 'basedoc_type', 'basedoc_name', 'basedoc_datasign', 'basedoc_datefinish', 'work_cost', 'federal_subject', 'work_area', 'work_name', 'forest_usage', 'work_reason', 'in_complex'], 'required'],
            [['branch', 'basedoc_type', 'federal_subject', 'forestry_quantity', 'subforestry', 'subdivforestry', 'work_name', 'forest_usage', 'work_reason', 'in_complex', 'completed', 'signed_by_ca'], 'integer'],
            [['executor', 'basedoc_datasign', 'basedoc_datefinish', 'work_datastart', 'forestry', 'subforestry', 'subdivforestry', 'timestamp', 'warning', 'warning_descr', 'remark', 'fact_datefinish','date_create'], 'safe'],
            [['work_area', 'work_cost'], 'number'],
            [['executor', 'customer', 'basedoc_name', 'work_othername', 'quarter', 'rli_order_num' ,'data_order'], 'string', 'max' => 100],
            [['remark'], 'string', 'max' => 300],
            [['forestry', 'comment'], 'string', 'max' => 300],
            /*[['id'], 'exist', 'skipOnError' => true, 'targetClass' => PdWorkProcess::className(), 'targetAttribute' => ['id' => 'pd_work']],*/
            [['branch'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['branch' => 'branch_id']],
            [['basedoc_type'], 'exist', 'skipOnError' => true, 'targetClass' => BasedocType::className(), 'targetAttribute' => ['basedoc_type' => 'id']],
            [['work_name'], 'exist', 'skipOnError' => true, 'targetClass' => PdWorktype::className(), 'targetAttribute' => ['work_name' => 'id']],
            [['forest_usage'], 'exist', 'skipOnError' => true, 'targetClass' => ForestUsage::className(), 'targetAttribute' => ['forest_usage' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'executor' => 'Соисполнитель работ (в случае привлечения СМП, %)',
            'branch' => 'Филиал ФГБУ "Рослесинфорг"',
            'branch0.name' => 'Филиал РЛИ',
            'branchName' => 'Филиал РЛИ',
            'customer' => 'Заказчик',
            'basedoc_type' => 'Вид документа-основания',
            'basedocType.doctype' => 'Документ-основание',
            'basedoc_name' => 'Номер документа',
            'fullDocName' => 'Документ-основание',
            'pdWorkName' => 'Наименование работ',
            'basedoc_datasign' => 'Дата заключения',
            'basedoc_datefinish' => 'Дата окончания',
            'signed_by_ca' => 'Документ подписан ЦА',
            'rli_order_num' => 'Приказ ЦА',
            'data_order' => 'Дата приказа',
            'ca_curator' => 'Куратор от ЦА',
            'work_cost' => 'Стоимость работ по документу (включая НДС 20%) [руб.коп]',
            'work_datastart' => 'Дата фактического начала работ',
            'federal_subject' => 'Субъект РФ',
            'forestry' => 'Лесничества',
            'forestry_quantity' => 'Количество выбранных лесничеств',
            'subforestry' => 'Участковое лесничество',
            'subdivforestry' => 'Участок/дача/урочище',
            'federalSubject.name' => 'Субъект РФ',
            'federalSubjectName' => 'Субъект РФ',
            'forestry0.forestry_name' => 'Лесничество',
            'subForestry.subforestry_name' => 'Участковое лесничество',
            'subdivforestry.name' => 'Участок/дача/урочище',
            'quarter' => 'Квартал (-ы)',
            'work_area' => 'Площадь по документу (га)',
            'work_name' => 'Наименование работ по проектированию',
            'work_othername' => 'Укажите наименование работ',
            'forest_usage' => 'Вид использования лесов (или предполагаемый вид использования лесных участков)',
            'workName.work_name' => 'Наименование работ по проектированию',
            'work_reason' => 'Цель',
            'workReasonName' => 'Цель',
            'in_complex' => 'Работы выполняются в комплексе',
            'forestUsage.usage_name' => 'Вид использования лесов',
            'comment' => 'Примечания куратора',
            'timestamp' => 'Момент добавления/обновления',
            'warning' => 'Ошибки',
            'warning_descr' => 'Описание ошибки',
            'remark' => 'Примечания филиала',
            'completed' => 'Проект завершен и сдан заказчику',
            'fact_datefinish'=>'Фактическая дата завершения',
            'no_report'=>'Без отчётов'
        ];
    }

    /**
     * Gets query for [[Id0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(PdWorkProcess::className(), ['pd_work' => 'id']);
    }

    /**
     * Gets query for [[Branch0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBranch0()
    {
        return $this->hasOne(Branch::className(), ['branch_id' => 'branch']);
    }

    public function getBranchName() {
        return $this->branch0->name;
    }

    /**
     * Gets query for [[BasedocType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBasedocType()
    {
        return $this->hasOne(BasedocType::className(), ['id' => 'basedoc_type']);
    }

    /* Геттер для названия документа-основания */
    public function getBaseDocName() {
        return $this->basedocType->doctype;
    }

    /* Геттер для полного названия документа-основания с номером */
    public function getFullDocName() {
        return $this->basedocType->doctype . ' ' . $this->basedoc_name;
    }


    /**
     * Gets query for [[WorkName]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWorkName()
    {
        return $this->hasOne(PdWorktype::className(), ['id' => 'work_name']);
    }

    /* Геттер для названия вида работ */
    public function getPdWorkName() {
        return $this->workName->work_name;
    }



    /**
     * Gets query for [[ForestUsage]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getForestUsage()
    {
        return $this->hasOne(ForestUsage::className(), ['id' => 'forest_usage']);
    }

    public function getWorkReason()
    {
        return $this->hasOne(PdWorkReason::className(), ['id' => 'work_reason']);
    }

    public function getWorkReasonName() {
        return $this->workReason->reason;
    }



	public function getFederalSubject()
    {
        return $this->hasOne(FederalSubject::className(), ['federal_subject_id' => 'federal_subject']);
    }

    /* Геттер для названия субъекта РФ */
    public function getFederalSubjectName() {
        return $this->federalSubject->name;
    }


	
	public function getForestry0()
    {
        return $this->hasOne(Forestry::className(), ['id' => 'forestry']);
    }

    public function getSubForestry()
    {
        return $this->hasOne(SubForestry::className(), ['id' => 'subforestry']);
    }


}
