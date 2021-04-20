<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pd\models\SearchPdWork */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Проектная документация';
$this->params['breadcrumbs'][] = $this->title;
$sumAll['work'] = 0;
$sumAll['completed'] = 0;
$sumAll['new'] = 0;

$dateNow = date_default_timezone_get();
$dataDefoldY = date("Y", strtotime($dateNow . ""));
$dataDefoldM = date("m", strtotime($dateNow . ""));
$dataDefold = $dataDefoldY.'-'.$dataDefoldM;

function percent($work,$expired,$completed,$new){
    $percent = 0;
    if (!isset($work))  $work = 0;
    if (!isset($completed))  $completed = 0;
    if (!isset($new))  $new = 0;
    if (!isset($expired))  $expired = 0;

    $b = $work - $expired;

    $work > 0 ? $percent += 20 : $percent += 0;
    $completed > 0 ? $percent += 20 : $percent += 0;
    $new > 0 ? $percent += 10 : $percent += 0;
    $b > 0 ? $percent += 50 : $percent += 0;

    return $percent;


}


?>

<p>
    <?= Html::a('<- Лесному планированию', ['index'], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('<i class="fas fa-file-pdf"></i> PDF', ['/pd/pd-work/summary-project/?request_date='.
        $dataDefold.'&format=pdf'], [
        'class'=>'btn btn-danger',
        'target'=>'_blank',
        'data-toggle'=>'tooltip',
        'title'=>'PDF-файл будет сгенерирован в новом окне'
    ]) ?>
    <a class="btn btn-info">Сформировать за квартал</a>
</p>
<!--Выбор квартала-->
<?php $form = ActiveForm::begin(['method'=>'get','action'=>['summary-project']]);?>
<div style="width: 50%;border-radius: 15px;background: rgba(102,106,91,0.05)" class="row hides">
    <div class="col-md-12"><h4>Сформировать за квартал</h4></div>
    <div class="col-md-8">
        <label for="quarter">Выберите квартал:</label>
        <?= $form = '<select id="quarter" name="quarter" class="form-control">
            <option value="1">Первый квартал</option>
            <option value="2">Второй квартал</option>
            <option value="3">Третий квартал</option>
            <option value="4">Четвертый квартал</option>
         </select>'?>
         <br>
    </div>
    <div class="col-md-4">
        <label for="year">Год:</label>
        <?= $form = DatePicker::widget([
            'options' => ['class' => 'formDateR'],
            'removeButton' => false,
//            'value'=>"$toDate",
            'name' => 'year',
            'pluginOptions' => [
                'format' => 'yyyy',
                'autoclose' => true,
                'minViewMode' => 2,
            ]
        ]); ?>
    </div>
    <div class="col-md-6"><?= Html::submitButton('Запросить', ['class' => 'btn btn-success formDateBT'])?></div>
</div>
<?php ActiveForm::end();?>

<?php
if (Yii::$app->request->get('request_date') == null){
    $dataChange = $dataDefold;
}
else{
    $dataChange = Yii::$app->request->get('request_date') ;
}
// ****************
$form = ActiveForm::begin(['method'=>'get','action'=>['summary-project'], 'options' => ['class' => 'form-inline']]);
echo '<div class="form-group mb-2" style="padding:0 10px"><h4>Сформировать отчет</h4></div><br>';
echo '<div class="form-group mb-2" style="padding:0 10px">за </div>';

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
<br>
<table class="table table-bordered minheight summary-report-pol-detail">

    <thead>
    <tr class="tabheader2">
        <td style="text-align: center"><b>Филиал</b></td>

        <?php
        // Сокращенная форма названий столбцов
        $usingtype = array(
            1 => 'Лесной план',
            'Лесохозяйственный регламент',
            4=>'Проект освоения лесов (ПОЛ)',
            3=>'Проектная документация лесного участка (приказ МПР № 54)',
            'Проект рекультивации нарушенных земель',
            'Лесная декларация',
            'Отчет об использовании (защите, воспроизводстве) лесов',
            'Проект лесовосстановления (лесоразведения)',
            'Проект по изменению целевого назначения лесов (ст. 81 ЛК РФ)',
            'Проект по проектированию особо защитных участков лесов',
            'Проект установления (изменения) границ лесопарковых и зеленых зон',
            'Установление лесопаркового зеленого пояса',
            'Проект планирования территории',
            'Проект межевания территории',
            'Перевод из состава земель лесного фонда',
            'Концепция инвестиционного проекта',
            'Проект противопожарного обустройства лесов',
            'Проект организации охотничьего хозяйства',
            'Проект организации территории ООПТ',
            'Проект реконструкции усадебного парка',
            'Проект оценки воздействия на окружающую среду (ОВОС)',
            'Проект организации санитарно-защитной зоны',
            'Проект нормативов предельно допустимых выбросов (ПДВ)',
            'Проект нормативов образования отходов и лимитов на их размещение (ПНООЛР)',
            'Прочие проекты',

        );
        for ($i = 1; $i <= 25; $i++)
            echo " <td class='totalpol'><div class='verticals vertical'>".$usingtype[$i]."</div></td>";

        ?>
        <td colspan=2 style="background:#f6f6f6bf;vertical-align: bottom!important;text-align: center"><div class=''>В&nbsp;работе</div></td>
        <td><div class='verticals vertical'>Завершено</div></td>
        <td><div class='verticals vertical'>Новые</div></td>
        <td><div class='verticals vertical'>Оценка</div></td>
    </tr>
    <tr>
        <td colspan = 1></td>
        <td colspan = 25 style="background: #fffc99;"></td>
        <td style="background:#f6f6f6bf"><div >Всего</div></td>
        <td style="background:#f6f6f6bf"><div >Просрочка</div></td>
        <td colspan = 3></td>
    </tr>
    </thead>

    <?php
    foreach ($branchs as $branch){
        echo '<tbody>
                <tr class="">
                    <td><b>'.$branch['name'].'</b></td>';
        for ($p = 1; $p <= 25; $p++){
            if (isset($cubic[$branch['branch_id']][$p])){

                if (isset($sumAll[$p])) $sumAll[$p] += $cubic[$branch['branch_id']][$p];
                else  $sumAll[$p] = $cubic[$branch['branch_id']][$p];

                echo '<td class="totalpoldata">'.$cubic[$branch['branch_id']][$p].'</td>';
            }
            else  echo '<td class="totalpoldata"> 0 </td>';
        }

        if (isset($cubic[$branch['branch_id']]['work'])) $sumAll['work'] += $cubic[$branch['branch_id']]['work'];
        if (isset($cubic[$branch['branch_id']]['completed'])) $sumAll['completed'] += $cubic[$branch['branch_id']]['completed'];
        if (isset($cubic[$branch['branch_id']]['new'])) $sumAll['new'] += $cubic[$branch['branch_id']]['new'];


        if (isset($cubic[$branch['branch_id']]['work'])) echo '<td style="background:#f6f6f6bf">'.$cubic[$branch['branch_id']]['work'].'</td>';
        else echo '<td style="background:#f6f6f6bf">'.'0'.'</td>';
        if (isset($cubic[$branch['branch_id']]['expired'])) echo '<td style="background:#f6f6f6bf">'.$cubic[$branch['branch_id']]['expired'].'</td>';
        else echo '<td style="background:#f6f6f6bf">'.'0'.'</td>';
        if (isset($cubic[$branch['branch_id']]['completed'])) echo '<td>'.$cubic[$branch['branch_id']]['completed'].'</td>';
        else echo '<td>'.'0'.'</td>';
        if (isset($cubic[$branch['branch_id']]['new'])) echo '<td>'.$cubic[$branch['branch_id']]['new'].'</td>';
        else echo '<td>'.'0'.'</td>';

        echo '<td>'.
            percent(
                    isset($cubic[$branch['branch_id']]['work'])?$cubic[$branch['branch_id']]['work']:0,
                    isset($cubic[$branch['branch_id']]['expired'])?$cubic[$branch['branch_id']]['expired']:0,
                    isset($cubic[$branch['branch_id']]['completed'])?$cubic[$branch['branch_id']]['completed']:0,
                    isset($cubic[$branch['branch_id']]['new'])?$cubic[$branch['branch_id']]['new']:0).
            '%</td>';

        echo '</tr></tbody>';
    }
    echo '<tbody>
                <tr class="sum">
                    <td><b>Итог:</b></td>';
    for ($p = 1; $p <= 25; $p++){
        if (isset($sumAll[$p])) echo '<td>'.$sumAll[$p].'</td>';
        else echo '<td>'.'0'.'</td>';


    }
    if ($sumAll['work']) echo '<td>'.$sumAll['work'].'</td>';
    else echo '<td>'.'0'.'</td>';
    if ($cubic['expired']) echo '<td>'.$cubic['expired'].'</td>';
    else echo '<td>'.'0'.'</td>';
    if ($sumAll['completed']) echo '<td>'.$sumAll['completed'].'</td>';
    else echo '<td>'.'0'.'</td>';
    if ($sumAll['new']) echo '<td>'.$sumAll['new'].'</td>';
    else echo '<td>'.'0'.'</td>';
    echo '<td></td></tr></tbody>';
    echo '<tbody> <tr class="sum"> <td><b>В том числе заключенные Центральным аппаратом:</b></td>';
    for ($p = 1; $p <= 25; $p++){
        if (isset($ca[$p])) echo '<td>'.$ca[$p].'</td>';
        else echo '<td>'.'0'.'</td>';
    }
    if ($ca['work']) echo '<td>'.$ca['work'].'</td>';
    else echo '<td>'.'0'.'</td>';
    if ($ca['expired']) echo '<td>'. $ca['expired'].'</td>';
    else echo '<td>'.'0'.'</td>';
    if ($ca['completed']) echo '<td>'.$ca['completed'].'</td>';
    else echo '<td>'.'0'.'</td>';
    if ($ca['new']) echo '<td>'.$ca['new'].'</td>';
    else echo '<td>'.'0'.'</td>';
    echo '<td></td></tr></tbody>';


    ?>
</table>

<?php

echo "<div class='delete'><h4>Краткая сводка</h4>";
// Аналитика: количество проектной документации по типам
echo "Общее количество: <b>".($ttl_pd+$ttlc_pd)."</b>";
//    " <span style='color:#aaa'>(всего ".($ttl_pd+$ttlc_pd).")</span>";
echo "<br>Лесных планов: <b>". ($ttl_lp+$ttlc_lp)."</b>";
//<span style='color:#aaa'>(всего ".($ttl_lp+$ttlc_lp).")</span>";
echo "<br>Лесохозяйственных регламентов: <b>".($ttl_lhr+$ttlc_lhr)."</b> (в ".($lhr_contracts+$lhrc_contracts)." контрактах) ";
//<span style='color:#aaa'>(всего ".($ttl_lhr+$ttlc_lhr)." в ".($lhr_contracts+$lhrc_contracts)." контрактах)</span>";
echo "<br>Проектов освоения лесов: <b>".($ttl_pol+$ttlc_pol)."</b> ";
//<span style='color:#aaa'>(всего ".($ttl_pol+$ttlc_pol).")</span>";
echo "<br>Иной документации: <b>".($ttl_other+$ttlc_other)."</b></div> ";
//<span style='color:#aaa'>(всего ".($ttl_other+$ttlc_other).")</span></div>";

if (!Yii::$app->request->get('quarter'))

?>

    <script>
        var quarter = <?= (!Yii::$app->request->get('quarter')?1:Yii::$app->request->get('quarter')) ?>;
        var year = <?= (!Yii::$app->request->get('year')?date("Y", strtotime( date_default_timezone_get() . "")):Yii::$app->request->get('year')) ?>;
    </script>

<?php
$js = <<< JS
    $('.hides').css('display','none')
    if (quarter) { $('#quarter').val(quarter) }
    if (year) { $('#w1').val(year) }
    
    
    
    $('.btn-info').on('click',function (){
        $('.hides').slideToggle()
    })
   
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($js, yii\web\View::POS_END);
?>