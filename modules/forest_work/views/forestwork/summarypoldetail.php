<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\LinkPager;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use miloschuman\highcharts\Highcharts;


$this->title = "Сведения о выполнении работ по разработке <br> проектов освоения лесов в ".date('Y')." г.";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forest-work-index">

    <p>
        <?= Html::a('Краткая сводка', ['summary-report-pol'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<i class="fas fa-file-pdf"></i> PDF', ['/forest_work/forestwork/summary-report-pol-detail/?format=pdf'], [
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

?>


<!-- <hr> -->
<br>


<div class="show_all_details">Развернуть все &#9660;</div>
<div class="hide_all_details">Cвернуть все &#9650;</div>

  
    <table class="table table-bordered minheight summary-report-pol-detail">
      <thead>
        <tr class="colnumbers">
          <?php // for ($i = 1; $i <= 20; $i++) echo "<td>".$i."</td>"; ?>
          <th>Филиал</th>
          <td>ст.29&nbsp;ЛК&nbsp;РФ</td>
          <td>ст.31&nbsp;ЛК&nbsp;РФ</td>
          <td>ст.32&nbsp;ЛК&nbsp;РФ</td>
          <td>ст.34&nbsp;ЛК&nbsp;РФ</td>
          <td>ст.36&nbsp;ЛК&nbsp;РФ</td>
          <td>ст.38&nbsp;ЛК&nbsp;РФ</td>
          <td>ст.40&nbsp;ЛК&nbsp;РФ</td>
          <td>ст.41&nbsp;ЛК&nbsp;РФ</td>
          <td>ст.42&nbsp;ЛК&nbsp;РФ</td>
          <td>ст.39&nbsp;ЛК&nbsp;РФ</td>
          <td>ст.39.1&nbsp;ЛК&nbsp;РФ</td>
          <td>ст.43&nbsp;ЛК&nbsp;РФ</td>
          <td>ст.44&nbsp;ЛК&nbsp;РФ</td>
          <td>ст.45&nbsp;ЛК&nbsp;РФ</td>
          <td>ст.46&nbsp;ЛК&nbsp;РФ</td>
          <td>ст.47&nbsp;ЛК&nbsp;РФ</td>
          <td>иные виды</td>
          <th>Всего</th>
          <th>Завершено</th>
        </tr>
      </thead>

      <tbody>
        <!-- <tr class="tabheader1">
          <th rowspan="2">Филиал</th>
          <th class="totalpol" colspan="17">Общее количество ПОЛ, находящихся в разработке и разработанных в <?= date('Y') ?> г.</th>
          <th class="completedpol" colspan="17">ПОЛ, работы по которым завершены и сданы заказчику</th>
          <th rowspan="2">Всего проектов</th>
          <th rowspan="2">Завершено и сдано заказчику</th>
        </tr> -->
        <tr class="tabheader2">
          <th><b>Филиал</b></th>

        <?php

        // $usingtype = array(
        //   1 => 'заготовка древесины',
        //   'заготовка живицы',
        //   'заготовка и сбор недревесных лесных ресурсов',
        //   'заготовка пищевых лесных ресурсов и сбор лекарственных растений',
        //   'осуществление видов деятельности в сфере охотничьего хозяйства',
        //   'ведение сельского хозяйства',
        //   'осуществление научно- <br />исследовательской деятельности, образовательной деятельности',
        //   'осуществление рекреационной деятельности',
        //   'создание лесных плантаций и их эксплуатация',
        //   'выращивание лесных плодовых, ягодных, декоративных растений, лекарственных растений',
        //   'выращивание посадочного материала лесных растений (саженцев, сеянцев)',
        //   'выполнение работ по геологическому изучению недр, разработка месторождений полезных ископаемых',
        //   'строительство и эксплуатация водохранилищ и иных искусственных водных объектов, а также гидротехнических сооружений и морских портов, морских терминалов, речных портов, причалов',
        //   'строительство, реконструкция, эксплуатация линейных объектов',
        //   'переработка древесины и иных лесных ресурсов',
        //   'осуществление религиозной деятельности',
        //   'иные виды, определенные в соотвествии с частью 2 статьи 6 Лесного кодекса Российской Федерации'
        // );


        // Сокращенная форма названий столбцов
          $usingtype = array(
          1 => 'заготовка древесины',
          'заготовка живицы',
          'заготовка и сбор недревесных лесных ресурсов',
          'заготовка пищевых лесных ресурсов и сбор лекарственных растений',
          'осуществление видов деятельности в сфере охотничьего хозяйства',
          'ведение сельского хозяйства',
          'осуществление научно- <br />исследовательской деятельности, образовательной деятельности',
          'осуществление рекреационной деятельности',
          'создание лесных плантаций и их эксплуатация',
          'выращивание лесных плодовых, ягодных, декоративных растений, лекарственных растений',
          'выращивание посадочного материала лесных растений (саженцев, сеянцев)',
          'выполнение работ по геологическому изучению недр, разработка месторождений полезных ископаемых',
          'строительство и&nbsp;эксплуатация водохранилищ и иных искусственных водных объектов',
          'строительство, реконструкция, эксплуатация линейных объектов',
          'переработка древесины и иных лесных ресурсов',
          'осуществление религиозной деятельности',
          'иные виды, определенные в соотвествии с частью 2 статьи 6 ЛК РФ'
        );


        for ($i = 1; $i <= 17; $i++) echo "
          <td class='totalpol'><div class='vertical'>".$usingtype[$i]."</div></td>";

        /*for ($i = 1; $i <= 17; $i++) {
          if ($i == 13) {
            echo "
          <td class='completedpol' style='width: 100px; height: 340px'><div class='vertical' style='width: 100px;'>".$usingtype[$i]."</div></td>";
          }
          else echo "
          <td class='completedpol'><div class='vertical'>".$usingtype[$i]."</div></td>";
        }*/

        ?>

          <th>Всего проектов</th>
          <th>Завершено и сдано заказчику</th>
        </tr>

      </tbody>

      <?php
      // Суммарные значения по всем филиалам в отчетном периоде
      $suma = 0; // ВСЕГО по состоянию на текущую неделю
      $sumb = 0; // ВЫПОЛНЕНО по состоянию на текущую неделю

      // Итоговые суммы показателей a1-b17 (suma1-suma17 и sumb1-sumb17) по столбцам по всем филиалам, изначально = 0
      for ($j = 1; $j <= 17; $j++) {
        ${'suma'.$j} = 0; //        echo " \$suma$j = ".${'suma'.$j};
        ${'sumb'.$j} = 0; //        echo " \$sumb$j = ".${'sumb'.$j};
      }


      for( $i = 0; $i < count($branches); $i++) {
        
        //if(!isset($cubik[$i])/* || $branches[$i]->branch_id == 0*/) continue; // Если нет данных по филиалу - пропускаем итерацию, ничего не вывовдим

        // Подсчитываем промежуточные суммы для филиала по регионам и формируем строки таблицы
        $fa = 0; // ВСЕГО по состоянию на текущую неделю
        $fb = 0; // ГОТОВО по состоянию на текущую неделю

        // Суммы показателей a1-b17 (sa1-sa17 и sb1-sb17) по столбцам по всем субъектам филиала, изначально проставляем = 0
        for ($j = 1; $j <= 17; $j++) {
          ${'fa'.$j} = 0;  //       echo " \$fa$j = ".${'fa'.$j};
          ${'fb'.$j} = 0;  //       echo " \$fb$j = ".${'fb'.$j};
        }

        // Подсчет суммарных значений по филиалу (по всем входящим субъектам)
        for ($s=0; $s < count($subjects) ; $s++) { 
          if(!isset($cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id])) continue;
          
          for ($j = 1; $j <= 17; $j++) {
            ${'fa'.$j} += $cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]["a$j"]; // echo " \$fa$j = ".${'fa'.$j};
            ${'fb'.$j} += $cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]["b$j"]; // echo " \$fb$j = ".${'fb'.$j};
          }

          $sa = $cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]['attlcurrent'];
          $fa += $sa;
          $suma += $sa;

          $sb = $cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]['bttlcurrent'];
          $fb += $sb;
          $sumb += $sb;

        } //-------------------

        //echo $fa;
        //echo $fb;

        $project_comleted[$i] = $fb; //заполняем массив завершенными по филиалам
        $project_inwork[$i] = $fa - $fb; //заполняем массив данными в работе по филиалам 

        // Выводим строки с итоговыми значениями
        echo "
      <tbody>
          <tr class='message_head'><td>".$branches[$i]->name."</td>";

          for ($j = 1; $j <= 17; $j++) {
            echo "<td class='totalpoldata'>".${'fa'.$j}."</td>";
            ${'suma'.$j} += ${'fa'.$j}; // Добавляем филиальные своды по a1-a17 в итоговое значение по столбцу
          }



          /*for ($j = 1; $j <= 17; $j++) {
            echo "<td class='completedpoldata'>".${'fb'.$j}."</td>";
            ${'sumb'.$j} += ${'fb'.$j}; // Добавляем филиальные своды по b1-b17 в итоговое значение по столбцу
          }*/


        echo "<td>".$fa."</td><td>".$fb."</td></tr>
      </tbody>"; // Филиал

        echo "
      <tbody class='message_details'>";

        for ($s=0; $s < count($subjects) ; $s++) {

          // если нет данных по субъекту, пропускаем итерацию
          if(!isset($cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id])) continue; 

          echo "
            <tr class='subpart'><td>".$subjects[$s]->name."</td>";

            for ($j = 1; $j <= 17; $j++) echo "<td>".$cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]["a$j"]."</td>";
            /*for ($j = 1; $j <= 17; $j++) echo "<td>".$cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]["b$j"]."</td>";*/

          echo "<td>";
          
          $acurr = (isset($cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]['attlcurrent']) ? $cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]['attlcurrent'] : "0");
          echo $acurr;

          echo "</td><td>";

          $bcurr = (isset($cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]['bttlcurrent']) ? $cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]['bttlcurrent'] : "0");
          echo $bcurr;

          echo "</td></tr>";
        }



      echo "
      </tbody>";
      }
        //  echo '<pre>';
        // var_dump($usingtype);
        // echo '</pre>';
      // echo $suma; //всего проектов по видам работ
      // echo '<br>';
      // echo $sumb; //всего завершенных проектов по видам работ
      ?>

      <tfoot>
        <tr class='sum'>
          <td>ИТОГО:</td>

          <?php
            for ($j = 1; $j <= 17; $j++) {
              echo "<td>".${'suma'.$j}."</td>";
              $type_work[$j] = ${'suma'.$j};
            };
        // echo '<pre>';
        // var_dump($type_work);
        // echo '</pre>';
            /*for ($j = 1; $j <= 17; $j++) echo "<td>".${'sumb'.$j}."</td>";*/
          ?>

          <td><?= $suma ?></td> 
          <td><?= $sumb ?></td>
        </tr>
      </tfoot>
    </table>



</div>

<?php

$branch = ['Амурский', 'Архангельский', 'Башкирский', 'Бурятский', 'Воронежлеспроект', 'Вотсиблеспроект', 'Вятский', 'Дальлеспроект', 'Заплеспроект', 'Запсиблеспроект', 'Казанский', 'Камчатский', 'Кареллеспроект', 'Мослеспроект', 'Омский', 'Пензенский', 'Пермский', 'Поволжский', 'Прибайкаллеспроект', 'Приморский', 'Рязанский', 'Северо-Кавказский', 'Севзаплеспроект', 'Севлеспроект', 'Тамбовский', 'Тверской', 'Томский', 'Тюменский', 'Ульяновский', 'Уральский', 'Филиал по Респ. Коми', 'Филиал по Респ. Марий Эл', 'Ханты-Мансийский', 'Центрлеспроект', 'Читинский', 'Южный', 'Якутский'];

$vertik = Highcharts::widget ([
        'options' => [
        'chart' => ['height' => 700],
        'title' => ['text' => 'Сведения о выполнении работ'],
        'credits' => ['enabled' => false],
        'xAxis' => ['categories' => $branch],
        'yAxis' => [
            'min' => 0,
            'title' => ['text' => 'Количество проектов']
            ],
            
        'legend' => ['reversed' => true],
        'plotOptions' => ['series' => ['stacking' => 'normal']],
        'series' => [
            [
                'type' => 'bar',
                'name' => 'В работе',
                'data' => $project_inwork,
                'color' => '#F00'
            ],
            [
                'type' => 'bar',
                'name' => 'Завершенно',
                'data' => $project_comleted,
                'color' => '#0a0'
            ]           
            
        ]

    ]

]);

echo '<hr>';
echo $vertik; //вывод диаграммы 


//Круговая диаграмма по видам работ для всех филиалов
$round = Highcharts::widget ([
    'options' => [
        'title' => ['text' => 'Виды работ'],
        'credits' => ['enabled' => false],
        'plotOptions' => [
            'pie' => [
                'allowPointSelect' => true,
                'cursor' => 'pointer',
                'dataLabels' => ['enabled' => false],
                'showInLegend' => true
                ]
        ],
        'legend' => [
            'layout' => 'vertical',
            'align' => 'right',
            'x' => 0,
            'y' => 0
            ],    
        'series' => [
            [
                'name' => 'Количество проектов',
                'type' => 'pie',
                'colorByPoint' => true,
                'data' =>[    
                    [
                        'name' => $usingtype [1],
                        'y' => $type_work[1]
                    ],
                    [
                        'name' => $usingtype [2],
                        'y' => $type_work[2]
                    ],
                    [
                        'name' => $usingtype [3],
                        'y' => $type_work[3]
                    ],
                    [
                        'name' => $usingtype [4],
                        'y' => $type_work[4]
                    ],
                    [
                        'name' => $usingtype [5],
                        'y' => $type_work[5]
                    ],
                    [
                        'name' => $usingtype [6],
                        'y' => $type_work[6]
                    ],
                    [
                        'name' => $usingtype [7],
                        'y' => $type_work[7]
                    ],
                    [
                        'name' => $usingtype [8],
                        'y' => $type_work[8]
                    ],
                    [
                        'name' => $usingtype [9],
                        'y' => $type_work[9]
                    ],
                    [
                        'name' => $usingtype [10],
                        'y' => $type_work[10]
                    ],
                    [
                        'name' => $usingtype [11],
                        'y' => $type_work[11]
                    ],
                    [
                        'name' => $usingtype [12],
                        'y' => $type_work[12]
                    ],
                    [
                        'name' => $usingtype [13],
                        'y' => $type_work[13]
                    ],
                    [
                        'name' => $usingtype [14],
                        'y' => $type_work[14]
                    ],
                    [
                        'name' => $usingtype [15],
                        'y' => $type_work[15]
                    ],
                    [
                        'name' => $usingtype [16],
                        'y' => $type_work[16]
                    ],
                    [
                        'name' => $usingtype [17],
                        'y' => $type_work[17]
                    ],
                ],
            ],
        ],
    ],
]);

echo '<hr>';
echo $round;

?>

<br><br>