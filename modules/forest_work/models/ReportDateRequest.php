<?php 

namespace app\modules\forest_work\models;
use yii\base\Model;


class ReportDateRequest extends Model
{
 
 public $reportDate;


 public function rules()
    {
        return [
            [['reportDate'], 'string', 'max' => 255],
        ];
    }

 public function attributeLabels()
    {
        return [
            'reportDate' => 'Выбрать дату отчета',
        ];
    }
 
}
