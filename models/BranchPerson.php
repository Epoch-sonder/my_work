<?php

namespace app\models;

use app\modules\lu\models\Vaccination;
use Yii;

/**
 * This is the model class for table "branch_person".
 *
 * @property int $id
 * @property string $fio ФИО
 (полностью)
 * @property string $position Должность
 
 
 * @property int $branch Наименование филиала
 
 
 * @property string $division Отдел
 
 
 * @property string|null $subdivision Участок
 
 
 * @property int $lu_dzz Обработка материалов ДЗЗ
 
 * @property int $lu_tax_eye Таксация глазомерный способом, глазомерно-измерительным способом
 
 * @property int $lu_tax_aero  Таксация методом аналитико-измерительного дешифрирование стерео аэроснимков 
 
 * @property int $lu_tax_actual Таксация дешифровочным методом, методом актуализации
 
 * @property int $lu_cameral1 Камеральна обработка лесоустроительных материалов, (картографические работы, формирование топографической основы, векторизация, формирование ситуационных карт)
 
 * @property int $lu_cameral2 Камеральная обработка лесоустроительных материалов
 
 * @property int $lu_plot_allocation Отвод лесосек
 
 * @property int $lu_park_inventory Садово-парковая инвентаризация 
 
 * @property int $gil_field Опредедение количественных 
 и качественных характеристик лесов (полевые)
 * @property int $gil_cameral Опредедение количественных 
 и качественных характеристик лесов (камеральные)
 * @property int $gil_ozvl_quality Оценка качества проведения и эффективности мероприятий по охране, защите, воспроизводству лесов и использованию лесов наземными способами
 
 * @property int $gil_remote_monitoring Дистанционный мониторинг
 
 * @property string $education Образование
 
 
 * @property string|null $specialization Специальность и квалификация в соответствии с образованием
 
 
 * @property string|null $academic_degree Ученая степень
 
 
 * @property int|null $experience_specialty Стаж работы по специальности 
 (полных лет)
 * @property int|null $experience_work Опыт работы полевых лесотаксационных работ, количество сезонов 
 
 
 * @property string $date_admission Дата приема на должность 
 
 
 * @property string|null $date_dismissial Дата увольнения
 
 
 * @property int|null $remark Примечание
 
 
 * @property int|null $num_brigade номер бригады
 * @property int|null $training_process_1 id тренировки 1
 * @property int|null $training_process_2 id тренировки 2
 * @property int|null $training_process_3 id тренировки 3
 */
class BranchPerson extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'branch_person';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio', 'position', 'branch', 'division', 'lu_dzz', 'lu_tax_eye', 'lu_tax_aero', 'lu_tax_actual', 'lu_cameral1', 'lu_cameral2', 'lu_plot_allocation', 'lu_park_inventory', 'gil_field', 'gil_cameral', 'gil_ozvl_quality', 'gil_remote_monitoring', 'education', 'date_admission'], 'required'],
            [['branch', 'lu_dzz', 'lu_tax_eye', 'lu_tax_aero', 'lu_tax_actual', 'lu_cameral1', 'lu_cameral2', 'lu_plot_allocation', 'lu_park_inventory', 'gil_field', 'gil_cameral', 'gil_ozvl_quality', 'gil_remote_monitoring', 'experience_specialty', 'experience_work', 'remark', 'num_brigade', 'training_process_1', 'training_process_2', 'training_process_3'], 'integer'],
            [['num_brigade', 'training_process_1', 'training_process_2', 'training_process_3'], 'default', 'value'=>null],
            [['date_admission', 'date_dismissial'], 'safe'],
            [['fio', 'position', 'division', 'subdivision', 'education', 'specialization', 'academic_degree'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'ФИО',
            'position' => 'Должность',
            'branch' => 'Филиал',
            'division' => 'Отдел',
            'subdivision' => 'Участок',
            'lu_dzz' => 'Обработка материалов ДЗЗ',
            'lu_tax_eye' => 'Таксация глазомерным способом',
            'lu_tax_aero' => 'Таксация методом АИДСА',
            'lu_tax_actual' => 'Метод актуализации',
            'lu_cameral1' => 'Обработка и забивка карточки таксации',
            'lu_cameral2' => 'Формирование картографической информации',
            'lu_plot_allocation' => 'Отвод лесосек',
            'lu_park_inventory' => 'Садово-парковая инвентаризация',
            'gil_field' => 'Определение характеристик полевых лесов',
            'gil_cameral' => 'Определение характеристик камеральных лесов',
            'gil_ozvl_quality' => 'Оценка качества',
            'gil_remote_monitoring' => 'Дистанционный мониторинг',
            'education' => 'Образование',
            'specialization' => 'Специальность',
            'academic_degree' => 'Ученая степень',
            'experience_specialty' => 'Стаж работы по специальности',
            'experience_work' => 'Опыт работы  полевых лесотаксационных работ, кол-во сезонов',
            'date_admission' => 'Дата приема на должность',
            'date_dismissial' => 'Дата увольнения',
            'remark' => 'Примечание',
            'num_brigade' => 'номер бригады',
            'training_process_1' => 'Тренировка 1',
            'training_process_2' => 'Тренировка 2',
            'training_process_3' => 'Тренировка 3',
            'branchName' => 'Филиал',
        ];
    }

    public function getBranchKod()
    {
        return $this->hasOne(Branch::className(), ['branch_id' => 'branch']);
    }

    public function getBranchName()
    {
        return $this->branchKod->name;
    }

    public function getFirst()
    {
        return $this->hasOne(Vaccination::className(), ['person_id' => 'id'])->
        orderBy(['first_vaccination' => SORT_DESC]);
    }
    public function getFirstDate()
    {
        return $this->first->first_vaccination;
    }

    public function getSecond()
    {
        return $this->hasOne(Vaccination::className(), ['person_id' => 'id'])->
        orderBy(['second_vaccination' => SORT_DESC]);
    }
    public function getSecondDate()
    {
        return $this->second->second_vaccination;
    }

    public function getThird()
    {
        return $this->hasOne(Vaccination::className(), ['person_id' => 'id'])->
        orderBy(['third_vaccination' => SORT_DESC]);
    }

    public function getThirdDate()
    {
        return $this->third->third_vaccination;
    }

}
