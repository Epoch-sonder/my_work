<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\pd\models\SearchPdWork */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cвод по ФО';
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
$form = ActiveForm::begin(['method'=>'get','action'=>['summary-district']]);
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
                Свод по федеральным округам
        </capton>
    <thead style="background:ghostwhite;">
    <tr class="tabheader2">
        <th rowspan="2" width="20%">Субъект РФ</th>
        <th colspan="3" width="24%" style="text-align: center"> Проектная документация</th>
        <th colspan="5" width="32%" style="text-align: center"> Проектная документация по видам</th>
        <th rowspan="2" width="12%">Зона ответственности</th>
        <th rowspan="2" width="12%">Факт. филиал</th>
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
        foreach ($districts as $district){
            $fo = $district->federal_district_id;
            if(isset($summaryFo[$fo])) {
                $districtId=$district->federal_district_id;
                    echo ' <tbody class="tbodyXS"><tr class="message_head" style="background: #fff" >
                                        <td colspan="1" >' . $district->name . '</td>
                                        <td class="to1"></td>
                                        <td class="to2"></td>
                                        <td class="to3"></td>
                                        <td class="ttl1"></td>
                                        <td class="ttl2"></td>
                                        <td class="ttl3"></td>
                                        <td class="ttl4"></td>
                                        <td class="ttl5"></td>
                                        <td COLSPAN="2"></td>
                                        </tr></tbody><tbody class="message_details" style="display: none">';
                    foreach ($subjects as $subject){
                        $fs = $subject->federal_subject_id;

                        if ($fo == $subject->federal_district_id){
                            echo '<tr style=" padding-left: 30px;color: #999999; background: #fafafa;" ><td>';
                            echo $summaryFo[$fo][$fs]['namesub']; //выводит название субъекта
                            echo '</td><td>';
                            echo $summaryFo[$fo][$fs]['work']; //выводит количество проектной докуменцаии в работе по субъекту
                            $total_work = $total_work + $summaryFo[$fo][$fs]['work']; //считает общее количество проектной докуменцаии в работе по ФО
                            echo '</td><td>';
                            echo $summaryFo[$fo][$fs]['completed']; //выводит количество завершенной проектной по субъекту
                            $total_completed = $total_completed + $summaryFo[$fo][$fs]['completed']; //считает общее количество завершенной проектной документации по ФО
                            echo '</td><td>';
                            echo $summaryFo[$fo][$fs]['summary']; //выводит количество всей проектной документации по субъекту
                            $total_sum = $total_sum + $summaryFo[$fo][$fs]['summary']; //считает общее количество всей проектной документации по ФО
                            echo '</td><td>';
                            echo $summaryFo[$fo][$fs]['forest_plans']; //выводит количество лесных планов по субъекту
                            $ttl_fp_sum = $ttl_fp_sum + $summaryFo[$fo][$fs]['forest_plans']; //считает общее количество лесных планов по ФО
                            echo '</td> <td>';
                            if (!isset($summaryFo[$fo][$fs]['forestry_regulations_all'])) $summaryFo[$fo][$fs]['forestry_regulations_all'] = 0;
                            if (!isset($summaryFo[$fo][$fs]['forestry_regulations'])) $summaryFo[$fo][$fs]['forestry_regulations'] = 0;
                            $ttl_fr_sum_all = $ttl_fr_sum_all + $summaryFo[$fo][$fs]['forestry_regulations_all']; //считает общее количество всего
//                            $ttl_fr_sum = $ttl_fr_sum + $summaryFo[$fo][$fs]['forestry_regulations']; //считает общее количество лесхоз. регламентов по ФО (документов)
                            echo $summaryFo[$fo][$fs]['forestry_regulations_all'];//выводит количество лесхоз. регламентов по субъекту
//                            echo ' ('.$summaryFo[$fo][$fs]['forestry_regulations'].')';//выводит количество лесхоз. регламентов по субъекту ( документов)
                            echo '</td><td>';
                            echo $summaryFo[$fo][$fs]['forest_projects']; //выводит количество проектов освоения лесов по субъекту
                            $ttl_fpr_sum = $ttl_fpr_sum + $summaryFo[$fo][$fs]['forest_projects']; //считает общее количество проектов освоения лесов по ФО
                            echo '</td><td>';
                            echo $summaryFo[$fo][$fs]['other_documentation']; //выводит количество иной документации по субъекту
                            $ttl_od_sum = $ttl_od_sum + $summaryFo[$fo][$fs]['other_documentation']; //считает общее количество иной документации по ФО
                            echo '</td><td>';
                            $SumOneAll = $summaryFo[$fo][$fs]['forest_plans'] + $summaryFo[$fo][$fs]['forestry_regulations_all'] + $summaryFo[$fo][$fs]['forest_projects'] + $summaryFo[$fo][$fs]['other_documentation'];
                            echo $SumOneAll ;
                            $ttl_sum_all += $SumOneAll;//выводит Всего документации
                            echo '</td><td>';
                            echo $summaryFo[$fo][$fs]['area_responsibility']; //выводит зону ответственности
                            echo '</td><td>';
                            if (!isset($summaryFo[$fo][$fs]['actual_branch'])) {
                                echo 'Работы не ведутся ';
                            }
                            else{
                                foreach ($branchs as $branch){
                                    if (isset($summaryFo[$fo][$fs]['actual_branch'][$branch->branch_id])){  
                                        echo $summaryFo[$fo][$fs]['actual_branch'][$branch->branch_id].'<br>' ; //выводится актуальный филиал
                                    }
                                }
                            }
                            echo '</td></tr>';
                        }
                    }
                    echo '<tr class="ttAll">
                        <td class = "t1">' .$total_work.'</td>
                        <td class = "t2">'.$total_completed.'</td>
                        <td class = "t3 ">'.$total_sum.'</td>
                        <td class = "tt1 ">'.$ttl_fp_sum.'</td>
                        <td class = "tt2 ">'.$ttl_fr_sum_all; //.' ('.$ttl_fr_sum.')
                    echo '</td>
                        <td class = "tt3 ">'.$ttl_fpr_sum.'</td>
                        <td class = "tt4 ">'.$ttl_od_sum.'</td>
                        <td class = "tt5 ">'.$ttl_sum_all.'</td></tr>
                        ';
                    echo '</tbody>';
            }
            $sumWorkFo +=$total_work; //подсчет общего числа проектной документации в работе всего
            $sumCompFo +=$total_completed; //подсчет общего числа завершенной проектной документации всего
            $sumAllFo +=$total_sum; //подсчет общего числавсей проектной документации всего
            $sumWorkFp +=$ttl_fp_sum; //подсчет общего числа лесных планов всего
            $sumWorkFr +=$ttl_fr_sum; //подсчет общего числа лесхоз. регламентов всего
            $sumWorkFrAll += $ttl_fr_sum_all;
            $sumWorkFpr +=$ttl_fpr_sum; //подсчет общего числа проектов освоения лесов всего
            $sumWorkod +=$ttl_od_sum; //подсчет общего числа иной документации всего
            $sumAllDocs = ($sumWorkFp+$sumWorkFrAll+$sumWorkFpr+$sumWorkod);
            $sumDocs = ($sumWorkFp+$sumWorkFr+$sumWorkFpr+$sumWorkod);
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
//вывод итого
 //.' ('.$ttl_fr_sum.')




        echo '<tr> 
                <th>Итого по всем округам</th>
                <th>'.$sumWorkFo.'</th> 
                <th>'.$sumCompFo.'</th>
                <th>'.$sumAllFo.'</th>
                <th>'.$sumWorkFp.'</th>
                <th>'.$sumWorkFrAll;//.' ('.$sumWorkFr.')</th>
                echo '<th>'.$sumWorkFpr.'</th>
                <th>'.$sumWorkod.'</th>
                <th>'.$sumAllDocs; //.' ('.$sumDocs.')';
                echo '</th> <th colspan="2"></th>
               </tr>';
        echo  '</table>';





?>