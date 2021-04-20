<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\lu\models\SearchLuProcess */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'План-график закупки';
$this->params['breadcrumbs'][] = $this->title;
$userID = Yii::$app->user->identity->id;
$id_st= 0;
$id_st3 = 0;
$id_st6 = 0;
$id_widget = 1;
$id_date_widget = 1;
$zakupka = app\modules\lu\models\ZakupCard::find()->where(['=', 'id', Yii::$app->request->get('zakup') ])->one();
$zakupkaNum = $zakupka['zakup_num'];





?>
<?php

if(empty($dataSTARTING)){
    echo Html::a('<- вернуться к закупке', ['../lu/zakup-card' ], ['class' => 'btn btn-primary']);
    echo '<br>';
    echo '<br>';
    echo '<br>';
    echo '<h4>Вы зашли в не сушествующую закупку</h4>';
}
else{

    echo Html::a('<- вернуться к закупке', ['../lu/lu-object/create' , 'zakup' => Yii::$app->request->get('zakup')], ['class' => 'btn btn-primary']);
    echo ' ';
    echo Html::a('<i class="fas fa-file-pdf"></i> PDF', [Yii::$app->request->url . '&format=pdf'], [
        'class' => 'btn btn-danger',
        'target' => '_blank',
        'data-toggle' => 'tooltip',
        'title' => 'Сгенерировать текущий отчет в формате PDF'
    ]);


 ?>
    <style>

        pre{
            display: none;
        }
        .date_start_1, .date_start_2 , .date_start_3 , .date_start_4 , .date_start_5, .date_start_6, .date_start_7, .date_start_8, .date_start_9, .date_start_10 ,
        .date_start_11, .date_start_12, .date_start_13 , .date_start_14 , .date_start_15, .date_start_16, .date_start_17, .date_start_18, .date_start_19, .date_start_20 ,
        .date_start_21, .date_start_22, .date_start_23 , .date_start_24 , .date_start_25, .date_start_26, .date_start_27, .date_start_28, .date_start_29, .date_start_30 ,
        .date_start_31, .date_start_32, .date_start_33 , .date_start_34 , .date_start_35, .date_start_36, .date_start_37, .date_start_38, .date_start_39, .date_start_40 ,
        .date_start_41, .date_start_42, .date_start_43 , .date_start_44 , .date_start_45, .date_start_46, .date_start_47, .date_start_48, .date_start_49, .date_start_50,
        .date_start_51, .date_start_52, .date_start_53 , .date_start_54 , .date_start_55, .date_start_56, .date_start_57, .date_start_58, .date_start_59, .date_start_60,
        .date_start_61, .date_start_62, .date_start_63 , .date_start_64 , .date_start_65, .date_start_66, .date_start_67, .date_start_68, .date_start_69, .date_start_70 {
            display: none;
        }
        .input-group.date {    width: 152px;}
    </style>







<?php
    echo '<table class="plan-schedule logo" > 
            <tr>
             <th class="logotip">';
    echo ' <img src="/img/rli_logo.png">';
    echo '</th></tr><tr>
             <th>Закупка: ';
    echo $zakupka->zakup_num;
    echo '</th> </tr><tr>
             <th> Субъект РФ: ';
    echo app\modules\lu\models\FederalSubject::find()->where(['=', 'federal_subject_id', $zakupka->fed_subject])->one()->name ;
    echo '</th> </tr><tr>
             <th> ';
    echo  app\modules\lu\models\Land::find()->where(['=', 'land_id', $zakupka->land_cat ])->one()->name ;
    echo '</th> </tr><tr>
           </tr></table> <br> ';


    ?>

<div class="lu-process-index">

    <table class="plan-schedule">
        <caption>
            <h2 class = "caption">План-график</h2>
        </caption>
        <tr>
            <th>№ п/п</th>
            <th>Вид работ</th>
            <th>Начало работ</th>
            <th>Конец работ</th>
            <th>ФИО ответственного</th>
            <th>Объем</th>
            <th>Кадровые</th>
            <th>Материально-технические ресурсы (спецодежда, инструменты и др.)</th>
            <th>Дата окончания фактическая. <h6>формат <br> год-месяц-день</h6></th>
            <th>Действия</th>
        </tr>

        <?php
        for ($i=0;$i<7;$i++) {
            echo '<tr class="name-phase"><td class="name-phase-botton" >';
            echo $stphase[$i]->phase_number ;
            echo '</td><td class="name-phase-botton">';
            echo $stphase[$i]->phase_name ;
            echo '</td>
                  <td class="name-phase-botton"> </td>
                  <td class="name-phase-botton"> </td>
                  <td class="name-phase-botton"> </td>
                  <td class="name-phase-botton"> </td>
                  <td class="name-phase-botton"> </td>
                  <td class="name-phase-botton"> </td>
                  <td class="name-phase-botton"></td> 
                  <td class="name-phase-botton"></td> 
                  </tr>';



            foreach ($stepproces as $stepprocess){

             if($stepprocess['step_phase'] == $stphase[$i]->phase_number){

                 //Подсчеты начальной даты
                    if($dateST == 0) { // Если начало графика то берем дату из базы данных
                        if ($dataSTARTING['date_contract_start'] == null){ // если базы значение null то фиксированная дата
                            $dateST = "2001-01-01";
                        }
                        else{
                            $dateST = $dataSTARTING['date_contract_start']; // берется от объекта
                        }
                    }
                    else {   // если стадия пренадлежит case, то берем сохраненную дату стадии
                        switch ($stepprocess['id']) {
                        case 5:
                            $dateST = $dataEnd101 ;
                            break;
                        case 7:
                            $dateST = $dataEnd103;
                            break;
                        case 13:
                            $dateST = $dataEnd104;
                            break;
                        case 15:
                            $dateST = $dataEnd104;
                            break;
                        case 16:
                            $dateST = $dataEnd104;
                            break;
                        case 19:
                            $dateST = $dataEnd104;
                            break;
                        case 11:
                            $dateST = $dataEnd206;
                            break;
                        case 12:
                            $dateST = $dataEnd206;
                            break;
                        case 20:
                            $dateST = $dataEnd210;
                            break;
                        case 23:
                            if ($zakupka->date_field != null){
                                $dateST= $zakupka->date_field;
                                $dateST = Yii::$app->formatter->asDatetime($dateST, 'Y');
                                $dateST = $dateST.'-05-01';
                            }

                            break;
                        case 26:
                            $dateST = $dataEnd301;
                            break;
                        case 32:
                            $dateST = $dataEnd308;
                            break;
                        case 33:
                            $dateST = $dataEnd308;
                            break;
                        case 36:
                            $dateST = $dataEnd403;
                            break;
                        default:
                            $dateST = $dateSTend;

                            break;
                        }
                    }
                 //Подсчеты дат
                 $max_dur= $stepprocess->max_duration; // мах дир из базы данных
                 $dateSTend = date("Y-m-d", strtotime($dateST . "+" . $max_dur . "days"));// дата конца формируется из начала + дней
                 // если стадия номер 27 и значение из контракта не = 0, то меняем дату конца
                 if ($stepprocess['id'] == 27 and $zakupka->date_field != null){  $dateSTend = $zakupka->date_field;}
                 // если стадия номер 28 и значение из контракта не = 0, то меняем дату начала
                 if ($stepprocess['id'] == 28 and $zakupka->date_field != null){   $dateST = $dataEnd304; $dateSTend = $zakupka->date_field; }
                 //с помощью массива достаем все процессы и ищем, фио записываем в переменную, дата конца из бд тоже записываем в переменную
                 foreach ($check_process as $checkProcess) {
                     // если стадия фазы = фазы  и LuProcess номер = номер стадии шага , то записываем в переменные отвественного и дату конца
                     if ($stepprocess['step_phase'] == $stphase[$i]->phase_number and $checkProcess['step_process'] == $stepprocess ['id']) {
                         $fio_or_branch = $checkProcess->person_responsible;
                         //Подсчеты дат
                         $dateSTend = $checkProcess->date_finish;
                     }
                 }
                    // Сохранение конечной даты
                    switch ($stepprocess['id']){
                        case 1:
                            $dataEnd101 = $dateSTend;
                            break;
                        case 3:
                            $dataEnd103 = $dateSTend;
                            break;
                        case 4:
                            $dataEnd104 = $dateSTend;
                            break;
                        case 10:
                            $dataEnd206 = $dateSTend;
                            break;
                        case 14:
                            $dataEnd210 = $dateSTend;
                            break;
                        case 23:
                            $dataEnd301 = $dateSTend;
                            break;
                        case 26:
                            $dataEnd304 = $dateSTend;
                            break;
                        case 30:
                            $dataEnd308 = $dateSTend;
                            break;
                        case 34:
                            $dataEnd403 = $dateSTend;
                            break;
                    }
                 // если стадия номер 22 и значение из контракта не = 0, то меняем дату конца
                    if($stepprocess['id'] == 22 and $zakupka->date_preparatory != null){$dateSTend = $zakupka->date_preparatory;}
                    // если стадия номер 31 и значение из контракта не = 0, то меняем дату конца и дату начала - 15 дней
                    elseif ($stepprocess['id'] == 31 and $zakupka->date_field != null){ $dateSTend = $zakupka->date_field; $dateST = date("Y-m-d", strtotime($dateSTend . "-15 days"));}
                    // если стадия номер 29 и значение из контракта не = 0, то меняем дату конца
                    elseif ($stepprocess['id'] == 39 and $zakupka->date_cameral != null){$dateSTend = $zakupka->date_cameral;}

                    //вывод строчек внутри фаз
                    echo'<tr class="name-step"><td>';
                    echo $stepprocess->step_number; //номер шага
                    echo'</td><td>';


                    // если номера стадии шага совпадает , то выводим план-факт
                    if(19 == $stepprocess ['id']
                    or 27 == $stepprocess ['id']
                    or 32 == $stepprocess ['id']
                    or 33 == $stepprocess ['id']
                    or 34 == $stepprocess ['id']
                    ){
                        echo $stepprocess->step_name; //название шага
                            echo '<br>';
                            echo  Html::a('Перейти к заполнению план-факта',
                                ['../lu/lu-object-process/index', 'zakup' => Yii::$app->request->get('zakup'), 'step' => $stepprocess ['id']
//                                    , 'object' =>  $object_zakups['id']
                                ],
                                ['class' => 'btn btn-primary']);
                    }
                    else{
                        echo $stepprocess->step_name; //название шага
                    }
?>

                    <div class="docs_PDF<?=$stepprocess ['id']?>">
                        <div class="file_list"></div>
                        <?php
                        $docdir = 'docs/lu/zakupki/'.$zakupkaNum.'/';
                        $docNameMask_docsStep = 'docs_PDF_'.$stepprocess ['ids'].'_*';
                        ?>
                    </div>

                    <script type="text/javascript">
                        // Переменные для функции опроса директории с файлами
                        var docDir = '<?= $docdir ?>';
                        var zakupNum = '<?= $zakupkaNum ?>';
                        var docNameMask_docsStep<?= $stepprocess ['id'] ?> = '<?= $docNameMask_docsStep ?>';
                        var listDiv_docsStep<?= $stepprocess ['id'] ?> = '.docs_PDF<?=$stepprocess ['id']?> .file_list';
                    </script>

<?php


                    //ввывод даты
                    $dateSd = Yii::$app->formatter->asDatetime($dateST, 'dd');
                    $dateSm = Yii::$app->formatter->asDatetime($dateST, 'M');
                    $dateSy = Yii::$app->formatter->asDatetime($dateST, 'Y');
                    $dateFd = Yii::$app->formatter->asDatetime($dateSTend, 'dd');
                    $dateFm = Yii::$app->formatter->asDatetime($dateSTend, 'M');
                    $dateFy = Yii::$app->formatter->asDatetime($dateSTend, 'Y');
                    $dateSm = $arrayMonth[$dateSm];
                    $dateFm = $arrayMonth[$dateFm];
                    // если массив План графика пустой, то просто выводим дату
                     if ($process_empty == 1){
                         echo '</td><td><div class="date_initial">' .' C '. $dateSd .'<br>'. $dateSm  .'<br>'. $dateSy ;
                     }
                     // если массив План графика не пустой
                     else{
                         // если стадия шага == 1, то записываем дату начала в массив и выводим дату
                         if ($stepprocess['id'] == 1) {
                             $massivDate = array( $stepprocess['id'] => $dateST);
                             echo '</td><td><div class="date_initial">' .' C '. $dateSd .'<br>'. $dateSm  .'<br>'. $dateSy ;
                         }
                         else{
                             // foreach моссив с измененными датами
                                 foreach ($changeDateS as $changesDateS) {
                                     // если стадия шага = стадия шага измененной даты и номер закупки одинаковый
                                     if($stepprocess['id'] == $changesDateS['process_step'] and $changesDateS['zakup_card'] == $zakup_id) {
                                         // начальную дату меняем из массива с измененными датами и $max_dur берем из План-графика
                                         $dateST =$changesDateS['date_start'] ;
                                         $max_dur= $stepprocess['max_duration'];
                                         //Подсчеты дат
                                         $dateSTend = date("Y-m-d", strtotime($dateST . "+" . $max_dur . "days"));
                                         $massivDate += array( $stepprocess['id'] => $dateST);
                                         $dateSd = Yii::$app->formatter->asDatetime($dateST, 'dd');
                                         $dateSm = Yii::$app->formatter->asDatetime($dateST, 'M');
                                         $dateSy = Yii::$app->formatter->asDatetime($dateST, 'Y');
                                         $dateFd = Yii::$app->formatter->asDatetime($dateSTend, 'dd');
                                         $dateFm = Yii::$app->formatter->asDatetime($dateSTend, 'M');
                                         $dateFy = Yii::$app->formatter->asDatetime($dateSTend, 'Y');
                                         $dateSm = $arrayMonth[$dateSm];
                                         $dateFm = $arrayMonth[$dateFm];
                                     }

                                 }
                            // Добавление в массив начальных дат
                             foreach ($check_process as $checks_process) {
                                     if ($stepprocess['id'] == $checks_process['step_process'] and $checks_process['lu_zakup_card'] == $zakup_id){
                                         $massivDate += array( $stepprocess['id'] => $dateST);
                                     }
                             }

                             //вывод даты
                             echo '</td><td><div class="date_initial_' . $stepprocess['id'] . '">' . ' C ' . $dateSd . '<br>' . $dateSm . '<br>' . $dateSy;
                             //Если мы не нашли дату в массиве, то выводим форму и карандаш
                             if (empty($massivDate[$stepprocess['id'] ])){
                                     echo Html::a('<span><span class="glyphicon glyphicon-pencil"></span><span style="display: none">'.$stepprocess['id'].'</span></span></div>', ['index?zakup='.$zakupka['id'] ]);
                                     echo '<div class = date_start_'.$stepprocess['id'].'>';
                                     $form3 = ActiveForm::begin([
                                         'options' => ['class' => 'date_start_form'],
                                         'fieldConfig' => [
                                             'options' => [
                                                 'tag' => false,
                                                 'label'=> false,
                                             ]
                                         ],
                                     ]);
                                     echo $form3->field($model3, 'process_step')->hiddenInput([
                                         'value' => $stepprocess['id'],
                                         'options' => [
                                             'class' => "none"],
                                     ])->label(false) ;
                                     echo  $form3->field($model3, 'zakup_card')->hiddenInput([
                                         'value' => $zakup_id,
                                         'options' => [
                                             'class' => "none"],
                                     ])->label(false) ;
                                     echo $form3->field($model3, 'date_start')->widget(DatePicker::classname(),
                                         [
                                             'language' => 'ru-RU',
                                             'removeButton' => false,
                                             'options'=>  [
                                                 'class' => 'data_start_lu_process',
                                                 'id' => "$id_date_widget".'date',
                                                 'value'=>$dateST,],
                                             'pluginOptions' => [
                                                 'autoclose' => true,
                                                 'format' => 'yyyy-mm-dd',
                                                 // 'format' => 'dd-mm-yyyy',
                                                 'todayHighlight' => true,
                                                 'orientation' => 'top right',

                                             ],

                                         ])->label(false);
                                     $id_date_widget++;
                                     echo Html::submitButton('Сохранить', ['class' => 'btn btn-success' ]);
                                     ActiveForm::end();
                                     echo '</div>';
                                 }

                         }

                     }
                     echo '</td>';


                    echo '<td>' .' По '. $dateFd .'<br>'. $dateFm  .'<br>'. $dateFy;
//                    echo '</td><td>' . $dateST  . '</td> <td>'. $dateSTend;


                    //если в базе данных нет строк к опр объекту, выводим форму для 1 значения
                    if($process_empty == 1){
                        if($stepprocess['sort_order'] == 1){
                            //форма
                            $form = ActiveForm::begin([
                                'options' => ['class' => 'processLU'],
                                'fieldConfig' => [
                                    'options' => [
                                        'tag' => false,
                                        'label'=> false,
                                    ]
                                ],
                                'id' => 'login-form',
                            ]);


                            echo $form->field($model, 'step_process')->hiddenInput([
                                'value' => $stepprocess['id'],
                                'options' => [
                                    'class' => "none"],
                            ])->label(false) ;
                            echo $form->field($model, 'reporter')->hiddenInput([
                                'value' => $userID,
                                'options' => [
                                    'class' => "none"],
                            ])->label(false) ;
                            echo  $form->field($model, 'lu_zakup_card')->hiddenInput([
                                'value' => $zakup_id,
                                'options' => [
                                    'class' => "none"],
                                 ])->label(false) ;
                            echo '</td> <td>';
                            echo $form->field($model, 'person_responsible') ;
                            echo'</td><td>';
                            echo $form->field($model, 'volume') ;
                            echo'</td><td>';
                            echo $form->field($model, 'staff') ;
                            echo'</td><td>';
                            echo $form->field($model, 'mtr') ;
                            echo'</td><td>';
                            echo $form->field($model, 'date_finish')->widget(DatePicker::classname(),
                                [
                                    'language' => 'ru-RU',
                                    'removeButton' => false,
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'format' => 'yyyy-mm-dd',
                                        // 'format' => 'dd-mm-yyyy',
                                        'todayHighlight' => true,
                                        'orientation' => 'top right',
                                    ]
                                ]) ;
                            echo'</td><td>';
                            echo Html::submitButton('Сохранить', ['class' => 'btn btn-success top-margin' ]);
                            echo'</td><td>';
                            ActiveForm::end();

                        }
                    }
                    elseif ($process_empty == 0){
                    // парсим массив процессы для определенного объекта
                    foreach ($check_process as $checkProcess) {
                        //если id_step_process равен id шага,то вывод информации из нее + запись $id_st для вывода формы
                        if($checkProcess['step_process'] == $stepprocess ['id']){
                            echo '<td>';
                            echo $fio_or_branch;
                            echo '</td> <td>';
                            echo $checkProcess['volume'];
                            echo '</td> <td>';
                            echo $checkProcess['staff'];
                            echo '</td> <td>';
                            echo $checkProcess['mtr'];
                            echo '</td> <td>';
                            echo date("d.m.Y", strtotime($checkProcess['date_finish']));
                            echo '</td> <td>';
                            echo '</td></tr>';
                            $id_st = $checkProcess['step_process'] + 1;
                        }

                        // если шаг равен 1 и  id_step_process равен 5, то $id_st3 = 3 и $id_st6 = 6 для вывода формы для этих шагов
                        if ($checkProcess['step_process'] == 1 ){
                            $id_st201 = 5;
                        }
                        if ($checkProcess['step_process'] == 3 ){
                            $id_st203 = 7;
                        }
                        if ($checkProcess['step_process'] == 4 ){
                            $id_st209 = 13;
                            $id_st211 = 15;
                            $id_st212 = 16;
                            $id_st215 = 19;
                        }
                        if ($checkProcess['step_process'] == 10 ){
                            $id_st207 = 11;
                            $id_st208 = 12;
                        }
                        if ($checkProcess['step_process'] == 14 ){
                            $id_st216 = 20;
                        }
                        if ($checkProcess['step_process'] == 23 ){
                            $id_st304 = 26;
                        }
                        if ($checkProcess['step_process'] == 30 ){
                            $id_st401 = 32;
                            $id_st402 = 33;}
                        if ($checkProcess['step_process'] == 34 ){
                            $id_st405 = 36;}


                        if ($checkProcess['step_process']  ==   $id_st201){
                            $id_st201 = 0;
                        }
                        elseif ($checkProcess['step_process']  ==   $id_st203){
                            $id_st203 = 0;
                        }
                        elseif ($checkProcess['step_process']  ==   $id_st209){
                            $id_st209 = 0;
                        }
                        elseif ($checkProcess['step_process']  ==   $id_st211){
                            $id_st211 = 0;
                        }
                        elseif ($checkProcess['step_process']  ==   $id_st207){
                            $id_st207 = 0;
                        }
                        elseif ($checkProcess['step_process']  ==   $id_st208){
                            $id_st208 = 0;
                        }
                        elseif ($checkProcess['step_process']  ==   $id_st216){
                            $id_st216 = 0;
                        }
                        elseif ($checkProcess['step_process']  ==   $id_st304){
                            $id_st304 = 0;
                        }
                        elseif ($checkProcess['step_process']  ==   $id_st401){
                            $id_st401 = 0;
                        }
                        elseif ($checkProcess['step_process']  ==   $id_st402){
                            $id_st402 = 0;
                        }
                        elseif ($checkProcess['step_process']  ==   $id_st405){
                            $id_st405 = 0;
                        }
                    }

                    //если стадия = номеру переменной , то выводим форму
                    if($stepprocess ['sort_order'] ==  $id_st
                        or $id_st201 == $stepprocess ['sort_order']
                        or $id_st203 == $stepprocess ['sort_order']
                        or $id_st209 == $stepprocess ['sort_order']
                        or $id_st210 == $stepprocess ['sort_order']
                        or $id_st211 == $stepprocess ['sort_order']
                        or $id_st214 == $stepprocess ['sort_order']
                        or $id_st207 == $stepprocess ['sort_order']
                        or $id_st208 == $stepprocess ['sort_order']
                        or $id_st216 == $stepprocess ['sort_order']
                        or $id_st304 == $stepprocess ['sort_order']
                        or $id_st401 == $stepprocess ['sort_order']
                        or $id_st402 == $stepprocess ['sort_order']
                        or $id_st405 == $stepprocess ['sort_order']
                    ){
                        //форма
                        $form = ActiveForm::begin([
                            'options' => ['class' => 'processLU'],
                            'fieldConfig' => [
                                'options' => [
                                    'tag' => false,
                                    'label'=> false,
                                ]
                            ],
                            'id' => 'login-form',
                        ]);

                        echo $form->field($model, 'step_process')->hiddenInput([
                            'value' => $stepprocess['id'],
                            'options' => [
                                'class' => "none"],
                        ])->label(false) ;
                        echo $form->field($model, 'reporter')->hiddenInput([
                            'value' => $userID,
                            'options' => [
                                'class' => "none"],
                        ])->label(false) ;
                        echo  $form->field($model, 'lu_zakup_card')->hiddenInput([
                            'value' => $zakup_id,
                            'options' => [
                                'class' => "none"],
                        ])->label(false) ;
                        echo '<td>';

                        echo $form->field($model, 'person_responsible') ;
                        echo'</td><td>';
                        echo $form->field($model, 'volume') ;
                        echo'</td><td>';
                        echo $form->field($model, 'staff') ;
                        echo'</td><td>';
                        echo $form->field($model, 'mtr') ;
                        echo'</td><td>';
                        echo $form->field($model, 'date_finish')->widget(DatePicker::classname(),
                            [

                                'options' => [
                                        'class' => 'data_finish_lu_process',
                                        'id' => "$id_widget"],
                                'language' => 'ru-RU',
                                'removeButton' => false,
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd',
                                    // 'format' => 'dd-mm-yyyy',
//                                    'dateFormat'=>'dd-MM-yyyy',
                                    'orientation' => 'top right',
                                ],
                            ]);
                        $id_widget ++;
                        echo'</td><td>';

//                        echo Html::submitButton('Загрузить документы',  ['class' => 'btn' , 'style'=>' background: #71a4bd; color: white;' ]);
                        echo Html::submitButton('Сохранить', ['class' => 'btn btn-success top-margin' ]);
                        echo'</td><td></tr>';
                        ActiveForm::end();

                        echo'<tr><td></td><td></td><td></td><td></td></td><td><td>';
                        if (isset($model2)) {
                            echo '<div style="max-width: 600px;">
                            </td><td><h4>Загрузить</h4></td><td><h4> файлы</h4>';
                            $form2 = ActiveForm::begin(['options' => ['class'=> 'docsStep', 'id' => 'fileFormPDF'.$stepprocess ['id'], 'enctype' => 'multipart/form-data']]);
                            echo $form2->field($model2, 'step_num')->hiddenInput(['class'=> 'stepNumber','value' => $stepprocess ['ids'], 'readonly' => true])->label(false);
                            echo $form2->field($model2, 'numID')->hiddenInput(['class'=> 'numID','value' => $stepprocess ['id'], 'readonly' => true])->label(false);
                            echo '</td><td><div style="float: right"  class="infoall">';
                            echo $form2->field($model2, 'docsStep')->fileInput(['class'=> 'docsStep'.$stepprocess ['id'],'id' => 'docsStep'.$stepprocess ['id']])->label('DOCS (.pdf)') .'</div>';
                            echo '<div style="float: left">';
                            echo $form2->field($model2, 'zakup_num')->hiddenInput(['value' => $zakupkaNum, 'readonly' => true])->label(false);
                            echo '</div></td><td>';
                            echo '<br>';
                            echo Html::submitButton('Загрузить файлы', ['class' => 'btn btn-primary btn-upl-file fileload']);
                            ActiveForm::end();
                            echo '</td></div> <br>';
                        }








//                        if (isset($model2)) {
//                            echo '<div style="max-width: 600px;">
//                            <h4>Загрузить</h4></td><td><h4> файлы</h4></td><td>';
//
//                            $form2 = ActiveForm::begin(['options' => ['class'=> 'docsStep', 'id' => 'fileFormPDF'.$stepprocess ['id'], 'enctype' => 'multipart/form-data']]);
//                            echo $form2->field($model2, 'step_num')->hiddenInput(['class'=> 'stepNumber','value' => $stepprocess ['id'], 'readonly' => true])->label(false);
//                            echo '<div style="float: right"  class="infoall">';
//                            echo $form2->field($model2, 'docsStep')->fileInput(['class'=> 'docsStep'.$stepprocess ['id'],'id' => 'docsStep'.$stepprocess ['id']])->label('DOCS (.pdf)');
//                            echo '</div></td><td>';
//                            echo '<div style="float: left">';
//                            echo $form2->field($model2, 'zakup_num')->hiddenInput(['value' => $zakupkaNum, 'readonly' => true])->label(false);
//                            echo '</div></td><td>';
//                            echo '<br>';
//                            echo Html::submitButton('Загрузить файлы', ['class' => 'btn btn-primary btn-upl-file fileload']);
//                            ActiveForm::end();
//                            echo '</td></div> <br>';
//                        }
                        echo'</td></tr>';



                    }
                }
                }
            }

        } ?>
    </table>
</div>
<?php }

$js = <<<JS
        $(".glyphicon-pencil" ).click(function(e){
            var numberid = $(this).next().text();
             $('.date_initial_'+ numberid).css({
                'display': 'none',
            });
             $('.date_start_'+ numberid).css({
                'display': 'block',
            });
             return false; 
        });


       $(".docsStep" ).on('beforeSubmit', function( e){
           var numid = $(this).find( $(".numID")).val();
           var formData = new FormData($(this).get(0));
           $.ajax(   {
            url: '/lu/lu-process/upload',
            type: 'POST',
            data: formData,
            cache: false,
            dataType: 'json',
            processData: false, // Не обрабатываем файлы (Don't process the files)
            contentType: false, // Так jQuery скажет серверу что это строковой запрос
            success: function(data){ // удачное завершение запроса к серверу, в переменной data ответ сервера
                if(data){
                    var answer;
                    if(data == 'nofiles') answer = 'Файлы не выбраны';
                    else answer = 'файлы ' + data + ' загружены';
                    console.log(answer);
                    $('#docsStep' +  numid ).val('');
                    // обновляем списки загруженных файлов в заявках и ПД после загрузки нового
                   fileListRequestLU(docDir, window["docNameMask_docsStep" + numid], zakupNum, window["listDiv_docsStep" + numid]);
                }
            },
            error: function(){
              var status = '<span style="color: red;">Ошибка при загрузке файла</span>';
              $('.help-block').html(status); 
              console.log('Ошибка при загрузке файла');
            },
          });
          return false;        
         });



    
    
    function fileListRequestLU(docDir, docNameMask, zakupNum, listDiv) {
        $.ajax({
            url: '/lu/lu-process/file-list-request',
            type: 'POST',
            data: {'docDir' : docDir, 'docNameMask' : docNameMask, 'zakupNum' : zakupNum },
            success: function(data){
                if(data){
                    $(listDiv).html(data);
                    // console.log(data);
                }
            }
        });
    }
    
    if(typeof docDir !== 'undefined') {
        for (let i = 1; i < 43; i++) {
        fileListRequestLU(docDir, window["docNameMask_docsStep" + i], zakupNum, window["listDiv_docsStep" + i]);
       }
    }

JS;


$this->registerJs($js);
?>