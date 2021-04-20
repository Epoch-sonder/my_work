<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\pd\models\SearchPdWork */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Свод по филиалам';
$this->params['breadcrumbs'][] = $this->title;

$ttl_fr_sum = 0;
$ttl_fr_sum_all = 0;
$ttl_sum_all =0;
$sumWorkFrAll = 0;


echo '<div style="width: 20%" >
            <div>
                 <h3>Вывести свод за определенный год</h3>
            </div>
            <div>';
$form = ActiveForm::begin(['method'=>'get','action'=>['summary-branch']]);
echo $form = DatePicker::widget([
    'options' => [
        'class' => 'requestDate'],
    'value'=>"$dataChange",
    'name' => 'request_date',
    'pluginOptions' => [
        'format' => 'yyyy',
        'autoclose' => true,
        'minViewMode' => 2,
    ],
]);

echo '   </div><div style="margin-top: 3%; margin-bottom: 3%">';
echo Html::submitButton('Запросить', ['class' => 'btn btn-success formDateBT']);
ActiveForm::end();
echo '   </div></div>';



?>
<div class="show_all_details">Развернуть все &#9660;</div>
<div class="hide_all_details">Cвернуть все &#9650;</div>
<table class="table table-striped table-bordered detail-view tableTH">
        <capton>
                Свод по филиалам
        </capton>
    <thead style="background:ghostwhite;">
    <tr class="tabheader2">
        <th rowspan="2" width="20%">Субъект РФ</th>
        <th rowspan="2" width="12%">Зона отвественности</th>
        <th colspan="3" width="24%" style="text-align: center"> Проектная документация</th>
        <th colspan="5" width="32%" style="text-align: center"> Проектная документация по видам</th>
        <th rowspan="2" width="12%">Федеральный округ</th>
    </tr>
    <tr class="tabheader2">
        <th width="8%">В работе</th>
        <th width="8%">Завершено</th>
        <th width="8%">Итого</th>
        <th width="8%">Лесных планов</th>
        <th width="8%">Лесохозяйственных регламентов</th>
        <th width="8%">Проектов освоения лесов</th>
        <th width="8%">Иной документации</th>
        <th width="8%">Всего документации</th>
    </tr>
    </thead>
<?php

        foreach ($branchs as $branch){

            echo '<tbody class="tbodyXS" ><tr class="message_head" style="background: #fff" >
                        <td colspan="2" >' . $branch->name . '</td>
                                                            <td class="to1"></td>
                                                            <td class="to2"></td>
                                                            <td class="to3"></td>
                                                            <td class="ttl1"></td>
                                                            <td class="ttl2"></td>
                                                            <td class="ttl3"></td>
                                                            <td class="ttl4"></td>
                                                            <td class="ttl5"></td>
                                                            <td COLSPAN="1"></td>
                                                            </tr></tbody><tbody class="message_details" style="display: none">';

            $branchId = $branch->branch_id;
            if(isset($sumBranch[$branchId])) {

                foreach ($subjects as $subject) {

                    $fs = $subject->federal_subject_id;
                    if ( isset($sumBranch[$branchId][$fs])){

                        echo '<tr style=" padding-left: 30px;color: #999999; background: #fafafa;"><td>';
                        echo $sumBranch[$branchId][$fs]['name']; //вывод названия субъекта
                        echo '</td><td>';
                        echo $sumBranch[$branchId][$fs]['area_resp']; //вывод зоны ответсвенности
                        echo '</td><td>';
                        if (isset($sumBranch[$branchId][$fs]['work'])) {
                            echo $sumBranch[$branchId][$fs]['work']; //вывод количества проектной документации
                            $total_work = $total_work + $sumBranch[$branchId][$fs]['work']; //подсчет общего количества проектной документации в работе по филиалу
                        }
                        else echo '0';


                        echo '</td><td>';
                        if (isset($sumBranch[$branchId][$fs]['completed'])){
                            echo $sumBranch[$branchId][$fs]['completed']; //вывод
                            $total_completed = $total_completed + $sumBranch[$branchId][$fs]['completed']; //подсчет общего количества завершенной проектной документации по филиалу 
                        }
                        else echo '0';


                        echo '</td><td>';
                        if (isset($sumBranch[$branchId][$fs]['summary'])){
                            echo $sumBranch[$branchId][$fs]['summary']; //вывод количества всей проектной документации
                            $total_sum = $total_sum + $sumBranch[$branchId][$fs]['summary']; //подсчет общего количества всей проектной документации по филиалу
                        }
                        else echo '0';

                        echo '</td><td>';
                        if (isset($sumBranch[$branchId][$fs]['forest_plans'])){
                            echo $sumBranch[$branchId][$fs]['forest_plans']; //вывод количества лесных планов
                            $ttl_fp_sum = $ttl_fp_sum + $sumBranch[$branchId][$fs]['forest_plans']; //подсчет общего количества лесных планов по филиалу
                        }
                        else{
                            $sumBranch[$branchId][$fs]['forest_plans'] = 0;
                            echo '0';
                        }

                        echo '</td> <td>';






                        if(isset($sumBranch[$branchId][$fs]['forestry_regulations_all'])){

                            echo $sumBranch[$branchId][$fs]['forestry_regulations_all'];//выводит количество лесхоз. регламентов по субъекту
                            $ttl_fr_sum_all = $ttl_fr_sum_all + $sumBranch[$branchId][$fs]['forestry_regulations_all']; //считает общее количество всего
                        }
                        else{
                            $sumBranch[$branchId][$fs]['forestry_regulations_all'] = 0;
                            echo '0';
                        }
//                        if (isset($sumBranch[$branchId][$fs]['forestry_regulations'])){
////                            echo ' ('.$sumBranch[$branchId][$fs]['forestry_regulations'].')';//выводит количество лесхоз. регламентов по субъекту
//                            $ttl_fr_sum = $ttl_fr_sum + $sumBranch[$branchId][$fs]['forestry_regulations']; //считает общее количество лесхоз. регламентов по ФО.3
//                        }
//                        else echo ' (0)';



                        echo '</td><td>';
                        if (isset($sumBranch[$branchId][$fs]['forest_projects'] )){
                            echo $sumBranch[$branchId][$fs]['forest_projects']; //вывод количества проектов освоения лесов
                            $ttl_fpr_sum = $ttl_fpr_sum + $sumBranch[$branchId][$fs]['forest_projects']; //подсчет общего количества проектов освоения лесов по филиалу
                        }
                        else {
                            $sumBranch[$branchId][$fs]['forest_projects'] = 0;
                            echo '0';
                        }

                        echo '</td><td>';
                        if (isset($sumBranch[$branchId][$fs]['other_documentation'] )){
                            echo $sumBranch[$branchId][$fs]['other_documentation']; //вывод количества иной документации
                            $ttl_od_sum = $ttl_od_sum + $sumBranch[$branchId][$fs]['other_documentation']; //подсчет общего количества иной документации по филиалу
                        } //по филиалу
                        else {
                            $sumBranch[$branchId][$fs]['other_documentation'] = 0;
                            echo '0';
                        }


                        echo '</td><td>';
                        $SumOneAll = $sumBranch[$branchId][$fs]['forest_plans'] + $sumBranch[$branchId][$fs]['forestry_regulations_all'] + $sumBranch[$branchId][$fs]['forest_projects'] + $sumBranch[$branchId][$fs]['other_documentation'];
                        echo $SumOneAll ;
                        $ttl_sum_all += $SumOneAll;//выводит Всего документации
                        echo '</td><td>';
                        echo $sumBranch[$branchId][$fs]['Fo']; //вывод названия ФО
                        echo '</td></tr>';
                    }
                }
                $sumWorkFo +=$total_work; //подсчет общего количества проектной документации в работе всего
                $sumCompFo +=$total_completed; //подсчет общего количества завершенной проектной документации всего
                $sumAllFo +=$total_sum; //подсчет общего количества всей проектной документации всего
                $sumWorkFp +=$ttl_fp_sum; //подсчет общего количества лесных планов всего
                $sumWorkFr +=$ttl_fr_sum; //подсчет общего числа лесхоз. регламентов всего
                $sumWorkFrAll += $ttl_fr_sum_all;
                $sumWorkFpr +=$ttl_fpr_sum; //подсчет общего количества проектов освоения лесов всего
                $sumWorkod +=$ttl_od_sum; //подсчет общего количества иной документации всего
                $sumAllDocs = ($sumWorkFp+$sumWorkFrAll+$sumWorkFpr+$sumWorkod);
                $sumDocs = ($sumWorkFp+$sumWorkFr+$sumWorkFpr+$sumWorkod);


//вывод общих количеств различной документации по филиалам
                echo '<tr class="ttAll"><td class = "t1">' .$total_work.'</td>
                    <td class = "t2">'.$total_completed.'</td>
                    <td class = "t3">'.$total_sum.'</td>
                    <td class = "tt1">'.$ttl_fp_sum.'</td>
                    <td class = "tt2 ">'.$ttl_fr_sum_all;//.' ('.$ttl_fr_sum.');
                echo '  </td> 
                    <td class = "tt3">'.$ttl_fpr_sum.'</td>
                    <td class = "tt4">'.$ttl_od_sum.'</td>
                    <td class = "tt5 ">'.$ttl_sum_all.'</td>
                    </tr></tbody>';

                $total_work = 0;
                $total_completed = 0;
                $total_sum = 0;
                $ttl_fp_sum = 0;
                $ttl_fr_sum = 0;
                $ttl_fpr_sum = 0;
                $ttl_od_sum = 0;
                $ttl_fr_sum_all = 0;
                $ttl_sum_all = 0;

            }
            else{
                echo '<tr style=" padding-left: 30px;color: #999999; background: #fafafa;">
                <td colspan="2"> Нет работ по филиалу</td>
                <td colspan="1"> 0</td>
                <td colspan="1"> 0</th>
                <td colspan="1"> 0</td>
                <td colspan="1"> 0</td>
                <td colspan="1"> 0</td>
                <td colspan="1"> 0</td>
                <td colspan="1"> 0</td>
                <td colspan="1"> 0</td>
                <td colspan="1"></td></tr>';


        echo '<td class = "t1">0</td>
              <td class = "t2">0</td>
              <td class = "t3">0</td>
              <td class = "tt1">0</td>
              <td class = "tt2">0</td>
              <td class = "tt3">0</td>
              <td class = "tt4">0</td>
              <td class = "tt5">0</td>
              </tbody>';

            }
            }

 //вывод итогов
        echo '<tr>
                <th colspan="2">Итого по всем округам</th>
                <th>'.$sumWorkFo.'</th>
                <th>'.$sumCompFo.'</th>
                <th>'.$sumAllFo.'</th>
                <th>'.$sumWorkFp.'</th>
                <th>'.$sumWorkFrAll ; //.' ('.$sumWorkFr.')
                echo '</th>
                <th>'.$sumWorkFpr.'</th>
                <th>'.$sumWorkod.'</th>
                <th>'.$sumAllDocs ; //.' ('.$sumDocs.')
                echo '</th>
                <th ></th>
               </tr>';
        echo  '</table>';


?>
