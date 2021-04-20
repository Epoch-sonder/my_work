<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

if ($dateAll = Yii::$app->request->get('request_date'))
    $dateY = date("Y", strtotime(Yii::$app->request->get('request_date') . ""));

else
    $dateY = date('Y');

$this->title = "Сведения о выполнении работ по разработке <br> проектов освоения лесов в ".$dateY." г.";
$this->params['breadcrumbs'][] = $this->title;



?>
<div class="forest-work-index">

    <p>
        <?= Html::a('<- Лесному планированию', ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fas fa-file-pdf"></i> PDF',
            ['/pd/pd-work/summary-pol/?request_date='. $dateAll.'&format=pdf'],[
            'class'=>'btn btn-danger',
            'target'=>'_blank',
            'data-toggle'=>'tooltip',
            'title'=>'PDF-файл будет сгенерирован в новом окне'
        ]) ?>
    </p>
    <div class="rli_logo"><img src="/img/rli_logo.png"></div>
    <h1><?= $this->title ?></h1>
    <?php
    if (Yii::$app->request->get('request_date') == null){
        $dataChange = '';
    }
    else{
        $dataChange = Yii::$app->request->get('request_date') ;
    }
    // ****************
    $form = ActiveForm::begin(['method'=>'get','action'=>['summary-pol'], 'options' => ['class' => 'form-inline']]);
    echo '<div class="form-group mb-2" style="padding:0 10px">Сформировать за </div>';

    echo $form = DatePicker::widget([
        'removeButton' => false,
        'options' => [
            'class' => 'requestDate mb-2'],
        'value'=>"$dataChange",
        'name' => 'request_date',
        'pluginOptions' => [
            'format' => 'yyyy-mm',
            'autoclose' => true,
            'minViewMode' => 1,
        ],
    ]);

    echo Html::submitButton('Запросить', ['class' => 'btn btn-success formDateBT mb-2']);
    ActiveForm::end();
    // **********************

    ?>




    <?php



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
            <th>Новые</th>
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

            <th><div class='vertical' style="text-align: left;">Проектов в работе</div></th>
            <th><div class='vertical' style="text-align: left;">Завершено и сдано заказчику</div></th>
            <th><div class='vertical' style="text-align: left;">Новые</div></th>
        </tr>

        </tbody>

        <?php

        for( $i = 0; $i < count($branches); $i++) {

            // Выводим строки с итоговыми значениями
            echo "
      <tbody>
          <tr class='message_head'><td>".$branches[$i]->name."</td>";
            if (isset($cubik[$branches[$i]->branch_id])){
                for ($w = 1; $w <= 17; $w++) echo '<td class="totalpoldata">'. (isset($cubik[$branches[$i]->branch_id]["sum_by_branch"][$w]) ? $cubik[$branches[$i]->branch_id]["sum_by_branch"][$w] : 0 ) .'</td>';
                echo '<td class="message_head">'.(isset($cubik[$branches[$i]->branch_id]['sum_by_branch']["work"]) ? $cubik[$branches[$i]->branch_id]['sum_by_branch']["work"] : 0)  .'</td>';
                echo '<td class="message_head">'.(isset($cubik[$branches[$i]->branch_id]['sum_by_branch']["completed"]) ? $cubik[$branches[$i]->branch_id]['sum_by_branch']["completed"] : 0)  .'</td>';
                echo '<td class="message_head">'.(isset($cubik[$branches[$i]->branch_id]['sum_by_branch']["new"]) ? $cubik[$branches[$i]->branch_id]['sum_by_branch']["new"] : 0)  .'</td>';
            }

            else{
                for ($w = 1; $w <= 17; $w++) echo '<td class="totalpoldata">'. 0 .'</td>';
                echo '<td class="message_head">'. 0 .'</td>';
                echo '<td class="message_head">'. 0 .'</td>';
                echo '<td class="message_head">'. 0 .'</td>';
            }



          echo "</tr>
      </tbody>"; // Филиал

            echo "
      <tbody class='message_details'>";

            for ($s=0; $s < count($subjects) ; $s++) {
                // если нет данных по субъекту, пропускаем итерацию
                if(!isset($cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id])) continue;
//                if(!isset($cubik[$branches[$branches[$i]->branch_id]->branch_id][$subjects[$s]->federal_subject_id])) continue;

                echo "<tr class='subpart'>
                    <td>".$subjects[$s]->name."</td>";
                for ($w = 1; $w <= 17; $w++) echo '<td class="totalpoldata">'. (isset($cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id][$w]) ? $cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id][$w] : 0 ) .'</td>';
                echo '<td class="message_head">'.(isset($cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]["work"]) ? $cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]["work"] : 0)  .'</td>';
                echo '<td class="message_head">'.(isset($cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]["completed"]) ? $cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]["completed"] : 0)  .'</td>';
                echo '<td class="message_head">'.(isset($cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]["new"]) ? $cubik[$branches[$i]->branch_id][$subjects[$s]->federal_subject_id]["new"] : 0)  .'</td>';
            echo "</tr>";
            }

            echo "
      </tbody>";
        }

        ?>

        <tfoot>
        <tr class='sum'>
            <td>ИТОГО:</td>
            <?php
            for ($w = 1; $w <= 17; $w++) echo '<td>'. (isset($cubik["all_branch"][$w]) ? $cubik["all_branch"][$w] : 0 ) .'</td>';
            echo '<td>'.(isset($cubik['all_branch']["work"]) ? $cubik['all_branch']["work"] : 0)  .'</td>';
            echo '<td>'.(isset($cubik['all_branch']["completed"]) ? $cubik['all_branch']["completed"] : 0)  .'</td>';
            echo '<td>'.(isset($cubik['all_branch']["new"]) ? $cubik['all_branch']["new"] : 0)  .'</td>';


            ?>
        </tr>
        </tfoot>
    </table>



</div>


<br><br>