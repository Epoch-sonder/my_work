<?php

namespace app\modules\pd\models;

use Yii;

/**
 * This is the model class for table "pd_work_process".
 *
 * @property int $id
 * @property int $pd_work
 * @property string $report_date
 * @property int $pd_step
 * @property string $step_startplan
 * @property string $step_finishplan
 * @property string $progress_status
 * @property string $comment
 * @property string $resultdoc_name
 * @property string $resultdoc_num
 * @property string $resultdoc_date
 * @property string $resultdoc_file
 * @property int $person_responsible
 * @property string $timestamp
 *
 * @property PdWork $pdWork
 * @property PdStep $pdStep
 */
class PdWorkProcess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

	 public $docs;

    public static function tableName()
    {
        return 'pd_work_process';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pd_work', 'report_date', 'pd_step', 'step_startplan', 'step_finishplan', 'person_responsible', 'comment'], 'required'],
			// [['resultdoc_file'], 'file', 'extensions' => 'pdf, docx', 'skipOnEmpty' => true],
            [['pd_work', 'pd_step', 'person_responsible'], 'integer'],
            [['report_date', 'step_startplan', 'step_finishplan', 'resultdoc_date', 'timestamp', /*'resultdoc_file',*/ 'progress_status', 'resultdoc_name', 'resultdoc_num', 'resultdoc_date'], 'safe'],
            [['progress_status', 'resultdoc_name', 'pd_object'], 'string', 'max' => 100],
            [['comment'], 'string', 'max' => 500],
            [['resultdoc_num'], 'string', 'max' => 30],
            // [['resultdoc_file'], 'file'],
            [['pd_step'], 'exist', 'skipOnError' => true, 'targetClass' => PdStep::className(), 'targetAttribute' => ['pd_step' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pd_work' => 'Проектная документация',
            'pd_object' => 'Объект',
            'report_date' => 'Дата отчета',
            'pd_step' => 'Стадия разработки',
            'step_startplan' => 'Дата начала',
            'step_finishplan' => 'Дата окончания',
            'progress_status' => 'Статус прогресса',
            'comment' => 'Описание выполнения работ',
            'resultdoc_name' => 'Результирующий документ',
            'resultdoc_num' => 'Номер документа',
            'resultdoc_date' => 'Дата документа',
            'resultdoc_file' => 'Файл с документом',
            'person_responsible' => 'Ответственное лицо',
            'personFio' => 'Ответственное лицо',
            'timestamp' => 'Timestamp',
        ];
    }

    /**
     * Gets query for [[PdWork]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPdWork()
    {
        return $this->hasOne(PdWork::className(), ['id' => 'pd_work']);
    }

    /**
     * Gets query for [[PdStep]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPdStep()
    {
        return $this->hasOne(PdStep::className(), ['id' => 'pd_step']);
    }


    public function getPerson()
    {
        return $this->hasOne(User::className(), ['id' => 'person_responsible']);
    }

    public function getPersonFio() {
        return $this->person->fio;
    }



	public function getPdDocs()
    {
        return $this->hasOne(PdWorkDocs::className(), ['stage_id' => 'id']);
    }


}
