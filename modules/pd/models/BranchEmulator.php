<?php 

namespace app\modules\pd\models;
use yii\base\Model;


class BranchEmulator extends Model
{
 
 public $branchEmul;


 public function rules()
    {
        return [
            [['branchEmul'], 'integer'],
        ];
    }

 public function attributeLabels()
    {
        return [
            'branchEmul' => 'Эмуляция филиала',
        ];
    }
 
}
