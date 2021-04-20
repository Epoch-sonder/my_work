<?php

namespace app\modules\lu\models;

use app\models\BranchPerson;
use app\modules\audit\models\Branch;
use Yii;

/**
 * This is the model class for table "gps_tracking".
 *
 * @property int $id
 * @property int $branch
 * @property int $contract
 * @property int $specialist
 * @property string|null $april_recd
 * @property int|null $april_check
 * @property string|null $may_recd
 * @property int|null $may_check
 * @property string|null $june_recd
 * @property int|null $june_check
 * @property string|null $july_recd
 * @property int|null $july_check
 * @property string|null $august_recd
 * @property int|null $august_check
 * @property string|null $september_recd
 * @property int|null $september_check
 * @property string|null $october_recd
 * @property int|null $october_check
 * @property string|null $november_recd
 * @property int|null $november_check
 * @property int $party_leader
 * @property int $fio_responsible
 * @property string $date_create
 */
class GpsTracking extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gps_tracking';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['branch', 'contract', 'specialist', 'party_leader', 'fio_responsible', 'date_create'], 'required'],
            [['branch', 'contract', 'specialist', 'april_check', 'may_check', 'june_check', 'july_check', 'august_check', 'september_check', 'october_check', 'november_check', 'party_leader', 'fio_responsible'], 'integer'],
            [['april_recd', 'may_recd', 'june_recd', 'july_recd', 'august_recd', 'september_recd', 'october_recd', 'november_recd', 'date_create'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'branch' => 'Филиал',
            'branchName' => 'Филиал',
            'contract' => 'Контракт',
            'contractName' => 'Контракт',
            'specialist' => 'Специалист',
            'specialistName' => 'Специалист',
            'april_recd' => 'Апрель',
            'april_check' => 'Апрель проверено',
            'may_recd' => 'Май',
            'may_check' => 'Май проверено',
            'june_recd' => 'Июнь',
            'june_check' => 'Июнь проверено',
            'july_recd' => 'Июль',
            'july_check' => 'Июль проверено',
            'august_recd' => 'Август',
            'august_check' => 'Август проверено',
            'september_recd' => 'Сентябрь',
            'september_check' => 'Сентябрь проверено',
            'october_recd' => 'Октябрь',
            'october_check' => 'Октябрь проверено',
            'november_recd' => 'Ноябрь',
            'november_check' => 'Ноябрь проверено',
            'party_leader' => 'Руководитель полевой группы',
            'partyLeaderName' => 'Руководитель п.г.',
            'fio_responsible' => 'ФИО отвественного',
            'date_create' => 'Дата создание',
        ];
    }
    public function getBranch0()
    {
        return $this->hasOne(Branch::className(), ['branch_id' => 'branch']);
    }

    public function getBranchName()
    {
        return $this->branch0->name;
    }

    public function getContract0()
    {
        return $this->hasOne(ZakupCard::className(), ['id' => 'contract']);
    }
    public function getContractName() {
        return $this->contract0->zakup_num;
    }

    public function getSpecialist0()
    {
        return $this->hasOne(BranchPerson::className(), ['id' => 'specialist']);
    }
    public function getSpecialistName() {
        return $this->specialist0->fio;
    }

    public function getPartyLeader0()
    {
        return $this->hasOne(BranchPerson::className(), ['id' => 'party_leader']);
    }
    public function getPartyLeaderName() {
        return $this->partyLeader0->fio;
    }

    public function normal_date($month_recd,$arrayMonth){
        $arr_date = explode('-',$month_recd);
        $arr_date['1'] *= 1;
        return $month_recd = $arr_date['2'].' '.$arrayMonth[$arr_date['1']].' '.$arr_date['0'];
    }

    public function month_date($month,$month_check,$month_recd,$month_minus_recd,$id,$arrayMonth) {
        echo ' <h4 style="margin-left: 0;text-align: center;">'.$month.'</h4>';
        //gps_check роль
        if (\Yii::$app->user->can('gps_check')) {
            //если месяц заполнения существует
            if (isset($month_recd)) {
                $month_recd = $this->normal_date($month_recd, $arrayMonth);
                if ($month_check == 0)
                    echo '<div class="date_view">' . $month_recd . '</div>' . '<div class="text-center"><a class="verified btn btn-primary" id = ' . $id . '>Потвердить</a></div>';
                else
                    echo '<div class="date_view">' . $month_recd .'<br> <p style="color:green">Проверено <span style="color:green" title="Проверено" class="glyphicon glyphicon-ok"></span></p>' . '</div>';
            }
            else echo '<div class="date_view">Не заполнено</div>';
        }

        //gps_edit роль
        elseif (\Yii::$app->user->can('gps_edit')) {
            //если месяц заполнения не существует, но существует предыдущий месяц
            if (!isset($month_recd) and isset($month_minus_recd))
                echo '<a class="confirmation btn btn-primary" id = '.$id.'>gps-треки<br>отправлены </a>';
            //если месяц заполнения существует
            elseif (isset($month_recd)){
                echo '<div class ="date_view">'.$month_recd = $this->normal_date($month_recd,$arrayMonth)
                        .($month_check ?' <span style="color:green" title="Проверено" class="glyphicon glyphicon-ok"></span>':' <span style="color:red" title="Не проверено" class="glyphicon glyphicon-remove"></span>'). '</div>';
            }
            else
                echo '<p class="'.$id.'">Не отправлены за предыдущий месяц</p>';
        }

        //gps_view роль
        elseif (\Yii::$app->user->can('gps_view'))
            if( isset($month_recd))
                echo '<div class ="date_view">'.$month_recd = $this->normal_date($month_recd,$arrayMonth)
                        .($month_check ?' <span style="color:green" title="Проверено" class="glyphicon glyphicon-ok"></span>':' <span style="color:red" title="Не проверено" class="glyphicon glyphicon-remove"></span>'). '</div>';
            else echo '<div class="date_view">Не заполнено</div>';

        if (\Yii::$app->user->can('admin')){
            if (isset($month_recd) or $month_check == 1)
                echo '<div class="text-center"><a data-id= '.$id.' class="delete btn">Убрать </a></div>';
        }

    }





}
