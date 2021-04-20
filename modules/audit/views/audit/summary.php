<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\audit\models\SearchAudit */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Summary';
$this->params['breadcrumbs'][] = $this->title;





echo Html::a('<- вернуться к проверкам', ['../audit/audit/' ], ['class' => 'btn btn-primary']);
echo ' ';
echo Html::a('вернуться к старой версии', ['../audit/audit/summary?old_version=1' ], ['class' => 'btn btn-primary']);
echo ' ';
echo Html::a('Инструкция', ['/audit/audit/instruction'], ['class' => 'btn btn-danger']);
echo ' ';
echo Html::a('<i class="fas fa-file-pdf"></i> PDF', ['../audit/audit/summary?from_date='.$fromDate.'&to_date='.$toDate.'&format=pdf'], [
    'class' => 'btn btn-danger',
    'target' => '_blank',
    'data-toggle' => 'tooltip',
    'title' => 'Сгенерировать текущий отчет в формате PDF'
]);
echo '<br>';
echo '<br>';

//для подсчета начальной даты
$dateT = new \DateTime($toDate);
$dateFR = new \DateTime($fromDate);
$dateTd = Yii::$app->formatter->asDatetime($dateT, 'dd');
$dateTm = Yii::$app->formatter->asDatetime($dateT, 'M');
$dateTy = Yii::$app->formatter->asDatetime($dateT, 'Y');
$dateFRd = Yii::$app->formatter->asDatetime($dateFR, 'dd');
$dateFRm = Yii::$app->formatter->asDatetime($dateFR, 'M');
$dateFRy = Yii::$app->formatter->asDatetime($dateFR, 'Y');
$dateTm = $arrayMonth[$dateTm];
$dateFRm = $arrayMonth[$dateFRm];
$dateMonthm = 0;

echo '<style> .peoplehide{
display: none;
background: #eaeaea7a!important;
    color: #7b7b7b!important ;
}
.clickpeople{    background-color: #ffffff!important;}</style>';

// Отображение дат
//if( !empty(Yii::$app->request->get('from_date')) and !empty(Yii::$app->request->get('to_date'))){
//    $viewData =  'c ' . $dateFRd . ' ' . $dateFRm . ' ' . $dateFRy
//        . ' по ' . $dateTd . ' ' . $dateTm . ' ' . $dateTy
//        . '<br>' . '<br>' ;
//}
//elseif(!empty(Yii::$app->request->get('from_date')) and empty(Yii::$app->request->get('to_date')) ){
//    $viewData =  'от ' . $dateFRd . ' ' .$dateFRm . ' ' . $dateFRy
//        . '<br>' . '<br>' ;
//}
//elseif( empty(Yii::$app->request->get('from_date')) and !empty(Yii::$app->request->get('to_date'))){
//    $viewData =  'до ' . $dateTd . ' ' . $dateTm . ' ' . $dateTy
//        . '<br>' . '<br>' ;
//}
//else{
    $viewData = 'с '. $dateFRd . ' ' . $dateFRm . ' ' . $dateFRy .' по '. $dateTd . ' ' . $dateTm . ' ' . $dateTy  .' <br>';
//}

//Форма ввода дат
echo '<div class="logotip">';
    echo ' <img src="/img/rli_logo.png">';
    echo '</div>';
echo '<div  class="displaySelect"><table style="    font-weight: 400 !important;">
        <caption>
           
     
            <h3>Вывести проверки за определенную дату</h3>

        </caption>
        <tr> 
            <td style="padding-right: 5px"> <p>Дата начала</p></td>
            <td style="padding-right: 400px"> <p>Дата конца</p></td>
        </tr>
        <tr> 
            <th style="padding-right: 5px;padding-bottom: 15px;">';
$form = ActiveForm::begin(['method'=>'get','action'=>['summary']]);
echo $form = DatePicker::widget([
    'options' => [
        'class' => 'formDateR'],
    'value'=>"$fromDate",
    'name' => 'from_date',
    'pluginOptions' => [
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true
    ]
]);
echo '     </td>
           <th style="padding-right: 400px;padding-bottom: 15px;">' .
    $form = DatePicker::widget([
        'options' => ['class' => 'formDateR'],
        'value'=>"$toDate",
        'name' => 'to_date',
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true
        ]
    ]);
echo '    </td>
        </tr>
        <tr>
          <td>';
echo Html::submitButton('Запросить', ['class' => 'btn btn-success formDateBT']);
ActiveForm::end();
echo '    </td> 
          </tr>
         </table></div>';




//Начало таблицы
echo '<br>';

echo '<table class="table table-striped table-bordered detail-view tableTH"> 
        <caption class="Text_Ogl"> <h2> Проверки </h2><h4><br> Исполнения переданных полномочий в области лесных отношений<br> органами исполнительной власти субъектов РФ <br>за период '. $viewData .  '</h4><div class="show_all_details">Развернуть все &#9660;</div>
<div class="hide_all_details">Cвернуть все &#9650;</div></caption>
                        <tr class="nameSpace">
                         <td style="width: 20%"> Дата</td>
                         <td style="width: 30%"> Федеральный округ,<br>  Субъект РФ</td>
                         <td style="width: 30%"> Орган исполнительной власти</td>
                         <td style="width: 10%"> Организатор, <br>тип проверки  </td>
                         <td style="width: 10%"> Расходы,руб.  </td>
                         
                         
                        '?>
<?php //'
///                         <td>  Формат<br> проведения,<br> Раздел </td>
//                         <td> Итого расходов,<br>  руб.	</td>
//                          <td> Формат<br> проведения</td>
//                          <td> Орган исполнительной власти </td>
//                          <td> Должность </td>
//                         <td> Суточные, руб. </td>
//                         <td> Проживание, руб. </td>
//                         <td> Транспортные расходы, руб. </td>
//                         <td> Прочие расходы, руб.	 </td>
//
//                        </tr> ' ;

//разбираем массив проверки
foreach ($audit as $audits){
    //разбираем массив проверки процесс
    foreach ($auditProcess as $auditsProcess){
        //если  проверки процесс = проверки
        if($auditsProcess['audit'] == $audits['id']){

            //если  переменная $same = проверки процесс и переменная,которая хранит нулл для множество одинаковых проверок,
            //а также переменная,которая хранит не нулл для одной проверки
            if($same != $auditsProcess['audit'] and $auditМany == null and $auditOne != null){
                //выводим подитог строку
                echo '<td class="sumOneMoney">'.number_format($allAuditSum, 2, ',', ' ').'</td></tbody>';
                $oneSumMoneyD = 0;
                $oneSumMoneyA = 0;
                $oneSumMoneyT = 0;
                $oneSumMoneyO = 0;
                $allAuditSum = 0;
                $sumFioAudit = 0;
                $auditМany = null;
                $auditOne = null;
                $audiyForMounth += 1;
            }
            //выводим строку подитог проверки, при множестве 1 проверки
            elseif($same != $auditsProcess['audit'] and $auditМany != null and $auditOne == null){
                //выводим подитог строку
                echo '<td class="sumOneMoney">'.number_format($allAuditSum, 2, ',', ' ').'</td></tbody>';
                $oneSumMoneyA = 0;
                $oneSumMoneyT = 0;
                $oneSumMoneyO = 0;
                $allAuditSum = 0;
                $sumFioAudit = 0;
                $auditМany = null;
                $audiyForMounth += 1;
            }
            // Работа с датой ... Отображение 1 января 2000.
            $dateMonthA = new \DateTime($audits->date_start);
            $dateMonthA = Yii::$app->formatter->asDatetime($dateMonthA, 'M');
            // Проверка
            if ($auditsProcess['audit'] != $dateProcessId){
                $dateProcessId = $auditsProcess['audit'];
                // Определение месяца
                if($dateMonthOne == null) {
                    $dateMonth = new \DateTime($audits->date_start);
                    $dateMonthd = Yii::$app->formatter->asDatetime($dateMonth, 'dd');
                    $dateMonthm = Yii::$app->formatter->asDatetime($dateMonth, 'M');
                    $dateMonthy = Yii::$app->formatter->asDatetime($dateMonth, 'Y');


                    $dateMonthOne = 1;
                }
                // Вывод Проверок за месяц
                elseif ($dateMonthOne != null and $dateMonthA != $dateMonthm){
                    if($dateMonthm != null){
                        $dateMonthm = $arrayMonthR[$dateMonthm];
                    }

                    echo  '<tr style="background-color: rgba(127,253,127,0.5)" ><td>За&nbsp;'.$dateMonthm.'</td><td>Проведено проверок: '.$audiyForMounth.'</td><td>Специалистов: '.$sumFioMonth.'</td><td>Расходы,руб:</td><td>'.number_format($sumAllMoneyMonth, 2, ',', ' ').'</td></tr>';
                    $dateMonth = new \DateTime($audits->date_start);
                    $dateMonthd = Yii::$app->formatter->asDatetime($dateMonth, 'dd');
                    $dateMonthm = Yii::$app->formatter->asDatetime($dateMonth, 'M');
                    $dateMonthy = Yii::$app->formatter->asDatetime($dateMonth, 'Y');
                    $sumFioMonth = 0;
                    $sumAllMoneyMonth = 0;
                    $audiyForMounth = 0;
                    $sumMoneyMonthD = 0;
                    $sumMoneyMonthA = 0;
                    $sumMoneyMonthT = 0;
                    $sumMoneyMonthO = 0;

                }
            }





            //если  переменная $same != проверки процесс  то выводим процесс проверки
            if($same != $auditsProcess['audit']){
                // вывод даты
                // для поля Дата
                $dateF = new \DateTime($audits->date_finish);
                $dateS = new \DateTime($audits->date_start);
                $dateSd = Yii::$app->formatter->asDatetime($dateS, 'dd');
                $dateSm = Yii::$app->formatter->asDatetime($dateS, 'M');
                $dateSy = Yii::$app->formatter->asDatetime($dateS, 'Y');
                $dateFd = Yii::$app->formatter->asDatetime($dateF, 'dd');
                $dateFm = Yii::$app->formatter->asDatetime($dateF, 'M');
                $dateFy = Yii::$app->formatter->asDatetime($dateF, 'Y');
                $dateSm = $arrayMonth[$dateSm];
                $dateFm = $arrayMonth[$dateFm];
                //Подсчет людей и дат
                $sumDateOne= $audits['duration'] ;
                $sumDateRange += $sumDateOne;
                $same = $auditsProcess['audit'];
                $auditOne = $auditsProcess['audit'];
                // вывод даты
                echo '<tbody><tr class="clickpeople"><td><p style="margin: 0;">';
                echo Html::a('С&nbsp;'.$dateSd .'&nbsp;'. $dateSm  .'&nbsp;'. $dateSy . '<br>' . 'по&nbsp;'.$dateFd .'&nbsp;'. $dateFm  .'&nbsp;'. $dateFy . '<br>',
                    ['../audit/audit/view?id='. $auditsProcess->audit . '&from_date=' .$fromDate . '&to_date='. $toDate ],['title'=> 'Перейти к проверке','class'=>'ahref']);
//                echo 'С&nbsp;'.$dateSd .'&nbsp;'. $dateSm  .'&nbsp;'. $dateSy;
//                echo '<br>';
//                echo 'по&nbsp;'.$dateFd .'&nbsp;'. $dateFm  .'&nbsp;'. $dateFy;
//                echo '<br>';

                echo '('.$sumDateOne.'&nbsp;дней)';
                echo '</p></td><td>';

                // вывод Федеральный округ имя
                foreach ($fed_dis as $fed_diss){
                    if ($audits->fed_district == $fed_diss->federal_district_id ){
                        echo '<p>' . $fed_diss->name . '</p>';
                    }
                }
                // вывод Субъект РФ имя
                foreach ($fed_sub as $fed_subs){
                    if ($audits->fed_subject == $fed_subs->federal_subject_id){
                        echo '<p style="margin: 0;">' . $fed_subs->name . '</p>';
                    }
                }
                echo ' </td><td>';
                foreach ($oiv as $oivs){
                    if ($audits->oiv == $oivs->id){
                        echo '<p style="margin: 0;">' . $oivs->name . '</p>';
                    }
                }




                // вывод Субъект РФ имя

                echo ' </td><td>';
                echo '<p>' . $audits->organizer. '</p>';
                $audits->audit_quantity;
                // $sumQuantity = суммируем кол-во проверок
                $sumQuantity += $audits->audit_quantity;


                // вывод тип проверки
                foreach ($auditType as $auditTypes){
                    if($auditTypes['id'] == $audits->audit_type){
                        echo '<p>' .  $auditTypes->type. '</p>';
                    }
                }
                $auditМany = null;
                echo '</td><td class="sumMoney"></td></tr>';
            }
            // если $same = номеру процесса рисуем пустую проверку и записываем в переменную $auditМany номер процесса и обнуляем $auditOne
            else{

                $auditМany = $auditsProcess['audit'];
                $auditOne = null;
            }
            //сумма для 1 человека
            $sumOnePersonal = $auditsProcess->money_daily + $auditsProcess->money_accomod + $auditsProcess->money_transport +  $auditsProcess->money_other ;








            echo '<tr class="peoplehide"><td colspan="5"><table style="width: 100%; margin-left: 50px"><tr>';
            // разбрираем массив проверящий проверок
            foreach ($auditPerson as $auditPersons){
                if ($auditsProcess->audit_person == $auditPersons->id) {
                    foreach ($branch as $branchs){
                        if($auditPersons->branch == $branchs->branch_id){
                            echo '
                            <td style="width: 30%">' . $auditPersons->fio . '<br>(' . $branchs->	name . ') ';
                        }
                    }




                    // Создание массива для таблица Свод по филиалам
                    if($auditPersons->branch == $auditPersonMany and $auditsProcess['audit'] == $auditPersonsNumber){

                        if( !isset($svodBranch[$auditPersons->branch]['people']))  $svodBranch[$auditPersons->branch]['people'] = 1;
                        else $svodBranch[$auditPersons->branch]['people'] += 1;

                        if( !isset($svodBranch[$auditPersons->branch]['money'])) $svodBranch[$auditPersons->branch]['money'] = $sumOnePersonal;
                        else $svodBranch[$auditPersons->branch]['money'] += $sumOnePersonal;

                        $auditPersonMany = $auditPersons->branch;
                    }
                    else{
                        if( !isset($svodBranch[$auditPersons->branch]['audit'])) $svodBranch[$auditPersons->branch]['audit'] = 1;
                        else $svodBranch[$auditPersons->branch]['audit'] += 1;

                        if( !isset($svodBranch[$auditPersons->branch]['people']))  $svodBranch[$auditPersons->branch]['people'] = 1;
                        else $svodBranch[$auditPersons->branch]['people'] += 1;

                        if( !isset($svodBranch[$auditPersons->branch]['money'])) $svodBranch[$auditPersons->branch]['money'] = $sumOnePersonal;
                        else $svodBranch[$auditPersons->branch]['money'] += $sumOnePersonal;

                        $auditPersonMany = $auditPersons->branch;

                    }

                    $auditPersonsNumber = $auditsProcess['audit'] ;

//                    echo ' </td><td>';
//                    echo $auditPersons->position;


                    $sumFio +=1;
                    $sumFioAudit +=1;
                    $sumFioMonth +=1;
                }
            }
            echo '</td><td style="width: 20%" >';

            // вывод даты
            // для поля Дата
            $dateProcS = new \DateTime($auditsProcess->date_start);
            $dateProcF = new \DateTime($auditsProcess->date_finish);
            $dateProcSd = Yii::$app->formatter->asDatetime($dateProcS, 'dd');
            $dateProcSm = Yii::$app->formatter->asDatetime($dateProcS, 'MM');
            $dateProcSy = Yii::$app->formatter->asDatetime($dateProcS, 'Y');
            $dateProcFd = Yii::$app->formatter->asDatetime($dateProcF, 'dd');
            $dateProcFm = Yii::$app->formatter->asDatetime($dateProcF, 'MM');
            $dateProcFy = Yii::$app->formatter->asDatetime($dateProcF, 'Y');
//            $dateProcSm = $arrayMonth[$dateProcSm];
//            $dateProcFm = $arrayMonth[$dateProcFm];
            echo $dateProcSd .'.'. $dateProcSm  .'.'. $dateProcSy;
            echo '-';
            echo $dateProcFd .'.'. $dateProcFm  .'.'. $dateProcFy;
            echo '<br>';
            $DateDuration = date_diff($dateProcF, $dateProcS);
            $DateDuration = $DateDuration->d + 1;
            echo '(' . $DateDuration . '&nbsp;дней)';

            echo ' </td><td style="width: 25%">';

            if ($auditsProcess->remote_mode == 0) echo 'Очно <br>';
            else echo 'Дистанционно <br>';

            echo 'Раздел № ';
            echo $auditsProcess->audit_chapter;
            echo '  ';

            // с помощью условия выводим 2 переменные для передачи их через гет в разделы процесса
            if (Yii::$app->request->get('from_date') == null){
                $from_date = '';
            }
            else{
                $from_date = '&from_date='.Yii::$app->request->get('from_date');
            }

            if (Yii::$app->request->get('to_date') == null){
                $to_date = '';
            }
            else{
                $to_date = '&to_date='.Yii::$app->request->get('to_date');
            }

            // кнопка перехода в раздел процесс
            echo Html::a(
                '<span class="glyphicon glyphicon-book"></span>',
//                            ['/lu/lu-process/index','zakup' => $key],
                ['../audit/audit-process/view?id='. $auditsProcess->id.$from_date.$to_date],
                ['title' => 'Подробнее']);
            echo ' </td><td>';
//  //                       echo number_format($auditsProcess->money_daily, 2, ',', ' '); // $auditsProcess->money_daily;
            // $oneSumMoneyD = сумма Суточные за 1 проверку
            // $sumMoneyD  =  сумма Суточные за все проверку
            $oneSumMoneyD +=  $auditsProcess->money_daily;
            $sumMoneyMonthD +=  $auditsProcess->money_daily;
            $sumMoneyD = $sumMoneyD + $auditsProcess->money_daily;

//  //                       echo ' </td><td>';
//  //                       echo number_format($auditsProcess->money_accomod, 2, ',', ' '); // $auditsProcess->money_accomod;
            // $oneSumMoneyA = сумма Проживание за 1 проверку
            // $sumMoneyA  =  сумма Проживание за все проверку
            $oneSumMoneyA +=  $auditsProcess->money_accomod;
            $sumMoneyMonthA +=  $auditsProcess->money_accomod;
            $sumMoneyA =$sumMoneyA + $auditsProcess->money_accomod;
//  //                      echo ' </td><td>';
//  //                       echo number_format($auditsProcess->money_transport, 2, ',', ' '); // $auditsProcess->money_transport;
            // $oneSumMoneyT = сумма Транспортные  за 1 проверку
            // $sumMoneyT  =  сумма Транспортные  за все проверку
            $oneSumMoneyT +=  $auditsProcess->money_transport;
            $sumMoneyMonthT +=  $auditsProcess->money_transport;
            $sumMoneyT =$sumMoneyT + $auditsProcess->money_transport;
//  //                       echo ' </td><td>';
// //            echo number_format($auditsProcess->money_other, 2, ',', ' '); // $auditsProcess->money_other;
            // $oneSumMoneyO = сумма Прочие за 1 проверку
            // $sumMoneyO  =  сумма Прочие за все проверку
            $oneSumMoneyO +=  $auditsProcess->money_other;
            $sumMoneyMonthO +=  $auditsProcess->money_other;
            $sumMoneyO =$sumMoneyO + $auditsProcess->money_other;
//  //           echo ' </td><td>';
            // $sumOnePersonal = сумма Итого за 1 проверку
            // $allAuditSum  =  сумма Итого за все проверку

            $svodFoSum = $auditsProcess->money_daily + $auditsProcess->money_accomod + $auditsProcess->money_transport +  $auditsProcess->money_other ;
            $sumAllMoneyMonth =$sumAllMoneyMonth + ($auditsProcess->money_daily + $auditsProcess->money_accomod + $auditsProcess->money_transport +  $auditsProcess->money_other) ;
            $allAuditSum += $sumOnePersonal;
            echo "Расходы,руб: <br>";
            echo number_format($sumOnePersonal, 2, ',', ' '); // $sumOnePersonal;
            echo ".руб";

            echo ' </td></tr> </tr></table></td>';
            //Создание таблицы свод по ФО.
            if ($audits->fed_district != $FedSub and $FedSubId != $audits->id){
                if($FedSubOne == null) {
                    $FedSubOne = 1;
                    if( !isset($svodFo[$audits->fed_district]['audit'])) $svodFo[$audits->fed_district]['audit'] = $auditOneFed;
                    else $svodFo[$audits->fed_district]['audit'] += $auditOneFed;
                }
                elseif ($FedSubOne != null){
                    $auditOneFed = 1;
                    if( !isset($svodFo[$audits->fed_district]['audit'])) $svodFo[$audits->fed_district]['audit'] = $auditOneFed;
                    else $svodFo[$audits->fed_district]['audit'] += $auditOneFed;
                }
            }
            elseif ( $FedSubId != $audits->id and $audits->fed_district == $FedSub) {
                $auditOneFed = 1;
                if( !isset($svodFo[$audits->fed_district]['audit'])) $svodFo[$audits->fed_district]['audit'] = $auditOneFed;
                else $svodFo[$audits->fed_district]['audit'] += $auditOneFed;
            }


            $FedSubId = $audits->id;
            $FedSub = $audits->fed_district;



            if( !isset($svodFo[$audits->fed_district]['people'])) $svodFo[$audits->fed_district]['people'] = 1;
            else $svodFo[$audits->fed_district]['people'] += 1;

            if( !isset($svodFo[$audits->fed_district]['money'])) $svodFo[$audits->fed_district]['money'] = $svodFoSum;
            else $svodFo[$audits->fed_district]['money'] += $svodFoSum;

//            else{
//                echo ++$kjs.' 3способ<br>';
//                $data_month = $auditsProcess['audit'];
//            }
        }

    }
}



//выводим последний подитог проверки
echo '<td class="sumOneMoney">'.number_format($allAuditSum, 2, ',', ' ').'</td>';

$audiyForMounth = $audiyForMounth +1;
//выводим последний подитог проверки за месяц
if($dateMonthm != null){
    $dateMonthm = $arrayMonthR[$dateMonthm];
    echo  '<tr style="background-color: rgba(127,253,127,0.5)" ><td>За&nbsp;'.$dateMonthm.'</td><td>Проведено проверок: '.$audiyForMounth.'</td><td>Специалистов: '.$sumFioMonth.'</td><td>Расходы,руб:</td><td>'.number_format($sumAllMoneyMonth, 2, ',', ' ').'</td></tr>';

}

echo '</table>' ;
//Итоги за период
echo '<h3>Итого за период:</h3><table class="table table-striped table-bordered detail-view tableTH"><tr style="background-color: rgba(56,186,56,0.7) ">
         <td> Дней </td>
         <td> Проверок</td>
        
         <td> Сотрудников</td>
         
         <td>Суточные, руб.</td>
         <td>Проживание, руб.</td>
         <td>Транспортные, руб.</td>
         <td>Прочие, руб.</td>
         <td>Расходы, руб. </td>
      </tr> ';
echo  '<tr style="background-color: rgba(56,186,56,0.7) ">
         <td>'. $sumDateRange .'</td><td> ';
echo $sumQuantity;
echo   '</td> <td>';
echo $sumFio;
echo   '</td><td>';
echo number_format($sumMoneyD, 2, ',', ' ');
echo    '</td><td>';
echo number_format($sumMoneyA, 2, ',', ' ');
echo    '</td><td>';
echo number_format($sumMoneyT, 2, ',', ' ');
echo    '</td><td>';
echo number_format($sumMoneyO, 2, ',', ' ');
echo    '</td><td>';
echo number_format($sumAll = $sumMoneyD + $sumMoneyA + $sumMoneyT + $sumMoneyO, 2, ',', ' ');
echo    '</td> 
         </tr></table>';

//Таблица ФО
echo '
<table class="table table-striped table-bordered detail-view tableTH">
<capton>
Свод по федеральным округам
</capton>
      <tr style="background: #bdc0c9">
         <td style="width: 40%">Федеральный округ</td>
         <td style="width: 20%">Количество проверок</td>
         <td style="width: 20%">Количество Людей </td>
         <td style="width: 20%">Расходы,руб</td>
      </tr>';

foreach ($fed_dis as $fed_distr){
    if(isset($svodFo[$fed_distr->federal_district_id]['audit'])) {
        echo '<tr><td>' . $fed_distr->name . '</td><td>';

        if (isset($svodFo[$fed_distr->federal_district_id]['audit'])) echo $svodFo[$fed_distr->federal_district_id]['audit'];
        echo '</td><td>';
        if (isset($svodFo[$fed_distr->federal_district_id]['people'])) echo $svodFo[$fed_distr->federal_district_id]['people'];
        echo '</td><td>';

        if (isset($svodFo[$fed_distr->federal_district_id]['money'])) echo number_format( $svodFo[$fed_distr->federal_district_id]['money'] , 2, ',', ' ');

        echo '</td></tr> ';
    }
}
echo  '</table>';

//Таблица филиалам
echo '
<table class="table table-striped table-bordered detail-view tableTH">
<capton>
Свод по Филиалам
</capton>
      <tr style="background: #bdc0c9">
         <td style="width: 40%">Федеральный округ</td>
         <td style="width: 20%">Количество проверок</td>
         <td style="width: 20%">Количество Людей </td>
         <td style="width: 20%">Расходы,руб</td>
      </tr>';
foreach ($branch as $branchs){
    if(isset($svodBranch[$branchs->branch_id])){
        echo  '<tr><td>';
        echo $branchs->name;
        echo '</td><td>';

        if( isset($svodBranch[$branchs->branch_id]['audit'])) echo $svodBranch[$branchs->branch_id]['audit'];
        echo  '</td><td>';

        if( isset($svodBranch[$branchs->branch_id]['people']))echo $svodBranch[$branchs->branch_id]['people'];
        echo  '</td><td>';

        if( isset($svodBranch[$branchs->branch_id]['money'])) echo number_format( $svodBranch[$branchs->branch_id]['money'] , 2, ',', ' ');
        echo  '</td></tr>';
    }
}



echo '</table>';



$js = <<<JS


  $(".clickpeople").click(function(){
     var  el = event.target ;
     if (el instanceof HTMLAnchorElement) {location.href = el.getAttribute('href') }
     else { $(this).parent().children( ".peoplehide").toggle();}
     return false;
    });
    
 $(".show_all_details").click(function(){
        $(".peoplehide").show();
        return false;
    });

    $(".hide_all_details").click(function(){
        $(".peoplehide").hide();
        return false;
    });
    
   
    // console.log( $('table').children(('td')).children('a')$.html())
    
   

    let i = 0;
    while (i < $(".sumOneMoney").length) { // выводит 0, затем 1, затем 2
        $(".sumOneMoney").parent().parent().find($(".sumMoney:eq("+ i +")")).html($(".sumOneMoney:eq("+ i +")"));
        i++;
    }
// $(".sumOneMoney").parent().parent().find(".sumMoney:eq(30)").text($(".sumOneMoney:eq(30)"));
// console.log($(".sumOneMoney:eq(30)").html())
    
   // $(".t1").parent().parent().prev(".tbodyXS").find(".to1").html($(".t1:eq("+i +")"));
    
JS;


$this->registerJs($js);
?>