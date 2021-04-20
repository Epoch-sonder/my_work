<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\LinkPager;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;


$this->title = "Сведения о выполнении работ по разработке <br> проектов освоения лесов в ".date('Y')." г.";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forest-work-index">

    <p>
        <?= Html::a('Подробный отчет', ['summary-report-pol-detail'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<i class="fas fa-file-pdf"></i> PDF', ['/forest_work/forestwork/summary-report-pol/?format=pdf'], [
            'class'=>'btn btn-danger', 
            'target'=>'_blank', 
            'data-toggle'=>'tooltip', 
            'title'=>'PDF-файл будет сгенерирован в новом окне'
        ]) ?>
    </p>


<div class="rli_logo"><img src="/img/rli_logo.png"></div>
<h1><?= $this->title ?></h1>


<?php
  
  if (!isset($_GET['format'])) {

    echo '<div id="custom_date_request">';

    $form = ActiveForm::begin();

    echo $form->field($reportDate_model, 'reportDate')->widget(DatePicker::classname(),
        [
          'language' => 'ru-RU',
          'removeButton' => false,
          'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true,
            'orientation' => 'top right',
          ]
        ]);

    echo Html::submitButton('Запросить отчет', ['class' => 'btn btn-success']);

    ActiveForm::end();

  echo "</div>";

  echo "<div class='report_date_description' style='text-align: center; '>Отчет по состоянию на " . $reportDate_model->reportDate . "</div>";

  }



  // if (isset($repDate)) echo "<p class='report_date_description' style='text-align: center; '>Отчет на " . $repDate . "</p>";

?>



<?php
// *************************//
// Тесты по работе с датами
// *************************//
// $d = getdate();
// var_dump($d);
// echo "<br>";
// echo $d['wday']."<br>"; // номер дня недели
// $dat = date("Y-m-d");
// echo 'Дата: '.$dat."<br>";
// echo 'Номер дня недели: '.date('w', strtotime($dat))."<br>";

// echo "<br>Первый вариант: номер дня недели ";
// $time = new DateTime('2020-09-12'); // $time = new DateTime(); // без параметра - текущая дата
// var_dump($time);
// $weekDayNum = $time->format('w');
// echo $weekDayNum;

// echo "<br>Второй вариант: номер дня недели ";
// $time = strtotime('2020-09-12'); //Перевод даты в timestamp
//     $date = date('w', $time);
//     echo $date;


// $reportDate = isset($_GET['reportDate']) ? $_GET['reportDate'] : '';

// $isdate = date('Y-m-d',strtotime($reportDate));
// echo "Является ли наша дата датой: ".$isdate;
// if ( !$isdate ) { $reportDate = ''; }

// $mydate = '2020-09-';
// $isDate = is_numeric(strtotime($reportDate));
// if ( !$isDate || strlen($reportDate) != 10 ) {  
//   echo "&laquo;" . $reportDate . "&raquo; - это нифига не дата, поэтому используем текущую дату и пустое значение для \$reportDate, а не эту хрень &laquo;".$reportDate."&raquo;";
//   $reportDate = '';
// }
// else echo $reportDate . " - это дата";


// $ourdate = new DateTime($reportDate); // $time = new DateTime(); // без параметра - текущая дата
// // var_dump($ourdate);
// $weekDayNum = $ourdate->format('w');
// echo "<br>Номер дня недели: " . $weekDayNum;

// if ($weekDayNum != 0) {
//   $ourdate->modify('next sunday');
// }

// echo "<br>Текущая неделя:";
// $cursunday = $ourdate->format('Y-m-d');
// echo "<br>ВС: " . $cursunday;
// $curmonday = $ourdate->modify('previous monday')->format('Y-m-d');
// echo "<br>ПН: " . $curmonday;


// echo "<br>Предыдущая неделя:";
// $prevsunday = $ourdate->modify('previous sunday')->format('Y-m-d');
// echo "<br>ВС: " . $prevsunday;
// $prevmonday = $ourdate->modify('previous monday')->format('Y-m-d');
// echo "<br>ПН: " . $prevmonday;

// **************************//
// /Тесты по работе с датами
// **************************//
?>


<!-- <hr> -->
<br>

<div class="show_all_details">Развернуть все &#9660;</div>
<div class="hide_all_details">Cвернуть все &#9650;</div>
<div class="markers" title="Скрыть/показать маркеры">Маркеры &#9899;</div>

<?php
// Отладка, массивы с переданными исходными данными
// echo "<br>";
// echo $prev;

// echo "<pre>";
// print_r($cubik);
// echo "</pre>";
?>
  <table class="table table-bordered summary-report-pol">
    <thead>                  
      <tr class="tabheader2">
        <th rowspan="2" width="36%">Филиал</th>
        <th rowspan="2" width="32%">По итогам прошлой недели</th>
        <th colspan="2" width="32%">По итогам текущей недели</th>
      </tr>
      <tr class="tabheader2">
        <th width="16%">всего</th>
        <th width="16%">завершено и сдано</th>
      </tr>
    </thead>
    

      <?php

      // Суммарные значения по всем филиалам в отчетном периоде
      $sumaprev = 0; // ВСЕГО по состоянию на прошлую неделю
      $sumacurr = 0; // ВСЕГО по состоянию на текущую неделю
      $sumbcurr = 0; // ВЫПОЛНЕНО по состоянию на текущую неделю

      for( $i = 0; $i < count($branches); $i++) {
        
        //if(!isset($cubik[$i])/* || $branches[$i]->branch_id == 0*/) continue; // Если нет данных по филиалу - пропускаем итерацию, ничего не вывовдим

        // Подсчитываем промежуточные суммы для филиала по регионам и формируем строки таблицы
        $faprev = 0; // ВСЕГО по состоянию на прошлую неделю
        $facurr = 0; // ВСЕГО по состоянию на текущую неделю
        $fbcurr = 0; // ГОТОВО по состоянию на текущую неделю

        for ($s=0; $s < count($subjects) ; $s++) { 
          if(!isset($cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id])) continue;
          
          $redmark = '';


          if(isset($cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]['attlprevious'])) {
            $aprev = $cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]['attlprevious'];
          } 
          else {
            $aprev = 0;
            $redmark .= " <span class='markerRed' title='Отчет за предыдущую неделю не предоставлен!'>&#128276;</span>";
          }

          $faprev += $aprev;
          $sumaprev += $aprev;
          

          if(isset($cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]['attlcurrent'])) {
            $acurr = $cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]['attlcurrent'];
          } 
          else {
            if (isset($cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]['attlprevious'])) $acurr = $cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]['attlprevious'];
            else $acurr = 0;
            $redmark .= " <span class='markerRed' title='Отчет за текущую неделю не предоставлен!'>&#128276;</span>";
          }

          $facurr += $acurr;
          $sumacurr += $acurr;



          if(isset($cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]['bttlcurrent'])) {
            $bcurr = $cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]['bttlcurrent'];
          } 
          else {
            if (isset($cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]['bttlprevious'])) $bcurr = $cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]['bttlprevious'];
            else $bcurr = 0;
          }

          $fbcurr += $bcurr;
          $sumbcurr += $bcurr;
          

        } //-------------------

        // Выводим строки с итоговыми значениями
        echo "
    <tbody>
          <tr class='message_head'><td>".$branches[$i]->name;
          if(isset($cubik[$branches[$i]->branch_id])) echo /*" <span class='markerGreen'>&#9660;</span> ".*/$redmark;
          else echo " <span class='markerRed' title='2 недели нет отчетов!'>&#9899;</span> ";
          echo "</td><td>".$faprev."</td><td>".$facurr."</td><td>".$fbcurr."</td></tr>
    </tbody>"; // Филиал

        echo "
    <tbody class='message_details'>";

        for ($s=0; $s < count($subjects) ; $s++) { 

          // если нет данных по субъекту, пропускаем итерацию
          if(!isset($cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id])) continue; 
          
          // Если нет данных за текущую неделю, формируем предупреждение в виде маркера
          $redmarkcurr = (!isset($cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]['attlcurrent'])) ? " <span class='markerRed' title='Отчет по субъекту за текущую неделю не предоставлен!'>&#9888;</span>" : "";
          $redmarkprev = (!isset($cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]['attlprevious'])) ? " <span class='markerRed' title='Отчет по субъекту за предыдущую неделю не предоставлен!'>&#9888;</span>" : "";
          
          echo "
            <tr class='subpart'><td>";
            echo ($redmarkprev || $redmarkcurr) ? $redmarkprev.$redmarkcurr : "<span class='markerGreen'>&#10004;</span>";
            echo " ".$subjects[$s]->name."</td>"; // Выводим Субъект
          
          echo "<td> ";

          $aprev = (isset($cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]['attlprevious']) ? $cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]['attlprevious'] : "0");
          echo $aprev;

          echo "</td><td>";
          
          $acurr = (isset($cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]['attlcurrent']) ? $cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]['attlcurrent'] : "0");
          echo $acurr;

          echo "</td><td> ";

          $bcurr = (isset($cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]['bttlcurrent']) ? $cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]['bttlcurrent'] : "0");
          echo $bcurr;

          echo "</td></tr>";
        }

      echo "
    </tbody>";

        
      }
      ?>

    <tfoot>
      <tr class='sum'>
        <td>ИТОГО:</td>
        <td><?= $sumaprev ?></td>
        <td><?= $sumacurr ?></td>
        <td><?= $sumbcurr ?></td>
      </tr>
    </tfoot>
  </table>


</div>