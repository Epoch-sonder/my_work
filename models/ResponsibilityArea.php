<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "responsibility_area".
 *
 * @property int $responsibility_area_id
 * @property int|null $federal_subject_id
 * @property int|null $branch_id
 * @property int|null $with_order в соответствии с приказом
 */
class ResponsibilityArea extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'responsibility_area';
    }


    // public $invert;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['federal_subject_id', 'branch_id', 'with_order'], 'integer'],
            // [['invert'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'responsibility_area_id' => 'ID',
            'federal_subject_id' => 'Субъект РФ ID',
            'federalSubjectName' => 'Субъект РФ',
            'branchName' => 'Филиал РЛИ',
            'branch_id' => 'Филиал ID',
            'with_order' => 'в соответствии с приказом',
            'invert' => 'Инверт',
        ];
    }


    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['branch_id' => 'branch_id']);
    }

    public function getBranchName() {
        return $this->branch->name;
    }

    public function getInvert() {
        // return $this->hasOne(Branch::className(), ['branch_id' => 'branch_id']);
        // if ($this->branch_id > 10) return 1;
        // else return 0;
        // return $this->hasOne(Branch::className(), ['branch_id' => 'branch_id']);
        return "rr";
    }

    public static function get_message_trigger($id){
        $model = ResponsibilityArea::find()->where(["federal_subject_id" => $id])->one();
        // if(!empty($model)){
        //     return $model->object_name;
        // }

        // return null;
        return "rr";
    }




    public function getFederalSubject()
    {
        return $this->hasOne(FederalSubject::className(), ['federal_subject_id' => 'federal_subject_id']);
    }

    /* Геттер для названия субъекта РФ */
    public function getFederalSubjectName() {
        return $this->federalSubject->name;
    }


}
