<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\modules\pd\models\PdWork;
use miloschuman\highcharts\Highcharts;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\pd\models\SearchPdWork */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Проектная документация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pd-chart-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <p>
        <?= Html::a('Создать проект', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Инструкция', ['instruction-pd'], ['class' => 'btn btn-danger']) ?>
        <?php
            if(!$completed) 
                echo Html::a('Завершенные', ['index', 'completed' => 1], ['class' => 'btn btn-primary']);
            else 
                echo Html::a('В работе', ['index'], ['class' => 'btn btn-primary']);
        ?>
    </p>


<?php
    if(!$completed) {
        echo "<h1>Проектная документация в работе</h1>";
        // Аналитика: количество проектной документации по типам
        echo "Общее количество: <b>".$ttl_pd."</b> <span style='color:#aaa'>(всего ".($ttl_pd+$ttlc_pd).")</span>";
        echo "<br>Лесных планов: <b>".$ttl_lp."</b> <span style='color:#aaa'>(всего ".($ttl_lp+$ttlc_lp).")</span>";
        echo "<br>Лесохозяйственных регламентов: <b>".$ttl_lhr."</b> (в ".$lhr_contracts." контрактах) <span style='color:#aaa'>(всего ".($ttl_lhr+$ttlc_lhr)." в ".($lhr_contracts+$lhrc_contracts)." контрактах)</span>";
        echo "<br>Проектов освоения лесов: <b>".$ttl_pol."</b> <span style='color:#aaa'>(всего ".($ttl_pol+$ttlc_pol).")</span>";
        echo "<br>Иной документации: <b>".$ttl_other."</b> <span style='color:#aaa'>(всего ".($ttl_other+$ttlc_other).")</span>";
    }
    else {
        echo "<h1>Завершенная проектная документация </h1>";
        // Аналитика: количество проектной документации по типам


        $dataDefold = date_default_timezone_get();
        $dataDefold = date("Y", strtotime($dataDefold . ""));
        if (Yii::$app->request->get('request_date') == null){
            $dataChange = $dataDefold;
        }
        elseif (Yii::$app->request->get('request_date') > $dataDefold){
            $dataChange = $dataDefold + 1 ;
        }
        elseif (Yii::$app->request->get('request_date') < 1999){
            $dataChange = 2000;
        }
        else{
            $dataChange = Yii::$app->request->get('request_date') ;
        }


        // ****************
            $form = ActiveForm::begin(['method'=>'get','action'=>['index?completed=1'], 'options' => ['class' => 'form-inline']]);

            echo '<div class="form-group mb-2" style="padding:0 10px">за год</div>';

            echo $form = DatePicker::widget([
                'removeButton' => false,
                'options' => [
                    'class' => 'requestDate mb-2'],
                'value'=>"$dataChange",
                'name' => 'request_date',
                'pluginOptions' => [
                    'format' => 'yyyy',
                    'autoclose' => true,
                    'minViewMode' => 2,
                ],
            ]);

            echo Html::submitButton('Запросить', ['class' => 'btn btn-success formDateBT mb-2']);
            ActiveForm::end();
        // **********************

        echo "<br>Общее количество: <b>".$ttlc_pd."</b>";
        echo "<br>Лесных планов: <b>".$ttlc_lp."</b>";
        echo "<br>Лесохозяйственных регламентов: <b>".$ttlc_lhr."</b> (в ".$lhrc_contracts." контрактах)";
        echo "<br>Проектов освоения лесов: <b>".$ttlc_pol."</b>";
        echo "<br>Иной документации: <b>".$ttlc_other."</b>";

}




// Вывод поля выбора фио для эмуляции работы в нем
if (Yii::$app->user->identity->branch_id == 0) {
    if (Yii::$app->request->get('completed') == 1){
        if (Yii::$app->request->get('onlymy') == 1){
            echo '<br><br>';
            echo Html::a('Вернуться ко всем филиалам', ['index?completed=1'], ['class' => 'btn btn-success ']) ;
        }
        else{
            echo '<br><br>';
            echo Html::a('Посмотреть мои филиалы', ['index?onlymy=1&completed=1'], ['class' => 'btn btn-success']) ;
        }

    }
    else{
        if (Yii::$app->request->get('onlymy') == 1){
            echo '<br><br>';
            echo Html::a('Вернуться ко всем филиалам', ['index'], ['class' => 'btn btn-success']) ;
        }
        else{
            echo '<br><br>';
            echo Html::a('Посмотреть мои филиалы', ['index?onlymy=1'], ['class' => 'btn btn-success']) ;
        }
    }
}

// Вывод поля выбора филиала для эмуляции работы в нем
if (Yii::$app->user->identity->branch_id == 0) {

    echo '<br><br><div id="brach_emulation">';

    $form = ActiveForm::begin(); // ['options' => ['class' => 'form-inline']]

    echo $form->field($branchEmul_model, 'branchEmul')->dropDownList(ArrayHelper::map(app\modules\pd\models\Branch::find()->orderBy(['name' => SORT_ASC])->all(), 'branch_id', 'name'));

    echo Html::submitButton('Применить', ['class' => 'btn btn-success']);

    ActiveForm::end();

    echo "</div>";
}

?>

    <br><br>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'firstPageLabel' => '<<',
            'lastPageLabel'  => '>>'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // [
            //     'attribute' => 'workName.work_name',
            //     'label' => 'Наименование работ',
            // ],
            
            'pdWorkName',
            // [
            //     'attribute' => 'pdWorkName',
            //     'label' => 'Наименование работ',
            // ],
            [
                'attribute' => 'work_area',
                'label' => 'площадь, га',
            ],
            //'id',
            // 'executor',
            // 'branch',
            'federalSubjectName',
            'branchName',
            // [
            //     'attribute' => 'branch0.name',
            //     'label' => 'Филиал РЛИ',
            // ],
            'customer',
            
            // 'basedoc_type',
            // [
            //     'attribute' => 'basedocType.doctype',
            //     'label' => 'Документ',
            // ],
            // 'basedoc_name',
            // [
            //     'attribute' => 'basedoc_name',
            //     'label' => 'Номер документа',
            // ],
            // 'baseDocName',
            'fullDocName',
            // [
            //     'attribute' => 'fullDocName',
            //     'label' => 'Документ-основание',
            // ],
            // 'basedoc_datasign',
            'basedoc_datefinish',
            //'work_cost',
            //'work_datastart',
            // 'federalSubject.name',
            
            // 'forestry',
            // [
            //     'attribute' => 'forestry0.forestry_name',
            //     'label' => 'Лесничество',
            // ],
            //'subforestry',
            //'subdivforestry',
            //'quarter',
            // 'work_area',
            // 'work_name',
            //'forest_usage',
            // [
            //     'attribute' => 'executor',
            //     'label' => 'СИ',
            // ],
            // [
            //     'attribute' => 'in_complex',
            //     'label' => 'К',
            // ],
            // 'warning',

            [
                'attribute' => 'warning',
                'label' => 'Ошибки',
                'encodeLabel' => false,
                'format' => 'raw',
                /**
                 * Переопределяем отображение фильтра.
                 * Задаем выпадающий список с заданными значениями вместо поля для ввода
                 */
                // 'filter' => [
                //     0 => 'Просрочено',
                //     1 => 'Ожидаем',
                // ],
                /**
                 * Переопределяем отображение самих данных.
                 * Вместо 1 или 0 выводим Yes или No соответственно.
                 * Попутно оборачиваем результат в span с нужным классом
                 */
                'value' => function ($model, $key, $index, $column) {

                    return \yii\helpers\Html::tag(
                        'span',
                        ($model->warning ? '&#9899;' : '&#10004;'),
                        [
                            'style' => 'color: ' . ($model->warning ? 'red' : 'green'),
                            'title' => ($model->warning ? 'есть ошибки' : 'нет ошибок'),
                        ]
                    );

                },
            ],

            //'comment',
            'remark',
            //'timestamp',


                // ['class' => 'yii\grid\ActionColumn'],

            [
                'class' => 'yii\grid\ActionColumn',
                'header'=> 'Действия', // Действия
                'headerOptions' => ['width' => '80'],
                'template' => '{update} <br> {link}', // '{view} {update} {link}',
                'buttons' => [
                    'update' => function ($url,$model,$key) {
                        return Html::a(
                        '<span class="glyphicon glyphicon-pencil"></span> Правка', 
                        // $data->url,
                        ['/pd/pd-work/update', 'id' => $key],  // для запроса через GET
                        ['title' => 'Правка']
                        );
                    },
                    'link' => function ($url,$model,$key) {
                        return Html::a(
                        '<span class="glyphicon glyphicon-tasks"></span> Отчёт', 
                        // $data->url,
                        ['/pd/pd-work-process/create', 'pd_work' => $key],  // для запроса через GET
                        ['title' => 'Процесс']
                        

                        // для запроса через POST
                        // ['/pd/pd-work-process/index'],
                        // [
                        //     'data-method' => 'POST',
                        //     'data-params' => [
                        //         'pd_work' => $key,
                        //         // 'csrf_param' => \Yii::$app->request->csrfParam,
                        //         // 'csrf_token' => \Yii::$app->request->csrfToken,
                        //     ],
                        //     'title' => 'Процесс',
                        //     // 'target' => '_blank'
                        // ]
                        );
                    },
                ],
            ],


            // 'signed_by_ca',
            [
                'attribute' => 'signed_by_ca',
                'label' => 'ЦА',
                'format' => 'raw',
                'filter' => [ 0 => 'не ЦА', 1 => 'ЦА'],
                'value' => function ($model, $key, $index, $column) {
                    $active = $model->{$column->attribute} === 1;
                    return \yii\helpers\Html::tag(
                        'span',
                        $active ? 'ЦА' : 'не ЦА',
                        ['class' => 'label label-' . ($active ? 'success' : 'danger'),]
                    );
                },
                'visible' => Yii::$app->user->identity->branch_id == 0,
            ],


           /* [
            'format' => 'html',
            'value' => function ($url) {
                return Html::a('процесс', ['/pd/pd-work-process/index', 'pd_work' => $url->id], ['class' => 'btn btn-success']);
                },
            ],*/
        ],
    ]); 


$vertik = Highcharts::widget ([
        'options' => [
        'chart' => ['height' => 700],
        'title' => ['text' => 'Проектная документация'],
        'credits' => ['enabled' => false],
        'xAxis' => ['categories' => $name],
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
                'data' => $docw,
                'color' => '#F00'
            ],
            [
                'type' => 'bar',
                'name' => 'Завершенно',
                'data' => $docc,
                'color' => '#0a0'
            ]           
            
        ]

    ]

]);

echo '<hr>';
echo $vertik; //вывод диаграммы 




    ?>


</div>
