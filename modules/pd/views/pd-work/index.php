<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\modules\pd\models\PdWork;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\pd\models\SearchPdWork */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Проектная документация';
$this->params['breadcrumbs'][] = $this->title;

$session = Yii::$app->session;
$session->open();
$session->set('pd_url',  Url::to());
$session->close();


?>
<div class="pd-work-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <p>
        <?php
        if(\Yii::$app->user->can('pd_edit') or \Yii::$app->user->can('pd_ca'))
            echo Html::a('Создать проект', ['create'], ['class' => 'btn btn-success']);
        ?>
        <?= Html::a('Инструкция', ['instruction-pd'], ['class' => 'btn btn-danger']) ?>
        <?php
            if(!$completed) 
                echo Html::a('Завершенные', ['index', 'completed' => 1], ['class' => 'btn btn-primary']);
            else 
                echo Html::a('В работе', ['index'], ['class' => 'btn btn-primary']);
        ?>
        <?php
            if(\Yii::$app->user->can('pd_view') and Yii::$app->user->identity->branch_id == 0 or \Yii::$app->user->can('pd_ca')){
                echo Html::a('Отчет о работе филиалов', ['/pd/pd-work/summary-project'], ['class' => 'btn btn-primary']);
                echo ' ';
                echo Html::a('Свод по ПОЛ', ['/pd/pd-work/summary-pol'], ['class' => 'btn btn-primary']);
            }
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
if (\Yii::$app->user->can('pd_ca')) {
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
if (\Yii::$app->user->can('pd_ca') or \Yii::$app->user->can('pd_view') and Yii::$app->user->identity->branch_id == 0) {

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
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
//        'options'=>['style' => 'white-space:nowrap;'],
        'pager' => [
            'firstPageLabel' => '<<',
            'lastPageLabel'  => '>>'
        ],
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id',
                'label'=>'№',
            ],
            // [
            //     'attribute' => 'workName.work_name',
            //     'label' => 'Наименование работ',
            // ],

            [
                'attribute' => 'pdWorkName',
                'filter' => ArrayHelper::map(app\modules\pd\models\PdWorktype::find()->asArray()->orderBy(['id' => SORT_ASC])->all(), 'work_name', 'work_name'),
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->work_name == 25)
                        $return =  $model->pdWorkName .': '. $model->work_othername;
                    else
                        $return =  $model->pdWorkName;

                    if ( !($model->work_name == 1 or $model->work_name == 2 ) and $model->forest_usage){
                        $usage_forest = \app\modules\pd\models\ForestUsage::find()->where(['=','id',$model->forest_usage])->select(['articles'])->asArray()->one();
                        $return .= '-ст.'. $usage_forest['articles'];
                    }

                    $one_forestry = '';
                    if ($model->forestry){
                        $list_forestry =explode(" ", trim($model->forestry));
                        $findforestry = \app\modules\lu\models\Forestry::find()
                            ->where(['=','subject_kod',$model->federal_subject])
                            ->andWhere(['forestry_kod'=>$list_forestry])
                            ->select(['forestry_name'])
                            ->asArray()->all();
                        foreach ($findforestry as $findforestr){
                            if (isset($view_forestry))
                                $view_forestry .= ', '.$findforestr["forestry_name"];
                            else {
                                $view_forestry = $findforestr["forestry_name"];
                                $one_forestry = $findforestr["forestry_name"];
                            }
                        }
                    }
                    else $view_forestry =  '';
                    if (strpos($view_forestry,','))
                        $return .= ' '.$one_forestry.'<span style="color:green" class="glyphicon glyphicon-tree-deciduous" title="'.$view_forestry.'"></span>';
                    else  $return .= ' '. $one_forestry;
                    return $return;
                },
            ],
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

            [
                'attribute' => 'federalSubjectName',
                'filter' => ArrayHelper::map(app\modules\pd\models\FederalSubject::find()->asArray()->orderBy(['name' => SORT_ASC])->all(), 'name', 'name'),
            ],
            [
                'attribute' => 'branchName',
                'label' => 'Филиал',
                'filter' => ArrayHelper::map(app\modules\pd\models\Branch::find()->asArray()->orderBy(['name' => SORT_ASC])->all(), 'name', 'name'),
                'visible' => \Yii::$app->user->can('pd_ca'),
            ],

            // [
            //     'attribute' => 'branch0.name',
            //     'label' => 'Филиал РЛИ',
            // ],
            [
                'attribute' => 'customer',
            ],
            
            // 'basedoc_type',
            // [
            //     'attribute' => 'basedocType.doctype',
            //     'label' => 'Документ',
            // ],
//             [
//                 'attribute' => 'basedoc_name',
//                 'label' => 'Номер документа',
//             ],
//             'baseDocName',



//            'fullDocName',


            [
                'attribute' => 'basedoc_name',
                'visible' => \Yii::$app->user->can('pd_ca') or \Yii::$app->user->can('pd_view'),
            ],
             [
                 'attribute' => 'fullDocName',
                 'label' => 'Документ-основание',
                 'visible' => \Yii::$app->user->can('pd_edit'),
             ],
            // 'basedoc_datasign',
            [
                'attribute' => 'basedoc_datefinish',
                'format' => 'raw',
                'value' => function ($model) {
                    $dateNow = new \DateTime(date_default_timezone_get());
                    $dateOrange = $dateNow->modify('+21 days')->format('Y-m-d');
                    $dateNow = $dateNow->modify('-21 days')->format('Y-m-d');
                    
                    if($model->basedoc_datefinish <= $dateNow)
                        $share = '<span title="Просрочено" class="fas fa-circle"  style="color:red"></span>';

                    elseif($model->basedoc_datefinish > $dateNow)
                        if ($model->basedoc_datefinish <= $dateOrange)
                            $share = '<span title="До даты завершения менее 3 недель" class="fas fa-circle" style="color:#ec862e"></span>';
                        else
                            $share = '';

                    else
                        $share = '';

                    return $model->basedoc_datefinish .' '.$share;
                },
            ],
            [
                'attribute' => 'work_datastart',
                'header' => "Дата начала<br>(факт)</a>",
//                'header' => (Yii::$app->request->get('sort') == '-work_datastart')? '<a class="desc" href="/pd/pd-work/index?sort=-work_datastart" data-sort="work_datastart">Дата начала<br>(факт)</a>' : '<a class="asc" href="/pd/pd-work/index?sort=work_datastart" data-sort="work_datastart">Дата начала<br>(факт)</a>',
                'format' => 'raw',
                'visible' => \Yii::$app->user->can('pd_ca'),
            ],
            [
                'attribute' => 'fact_datefinish',
                'label' => 'Завершено(факт)',
                'format' => 'raw',
                'visible' => Yii::$app->request->get('completed') == 1,
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
                'value' => function ($model) {
                        return $model->fact_datefinish;
                },
            ],
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
//            'forest_usage',
            // [
            //     'attribute' => 'executor',
            //     'label' => 'СИ',
            // ],
            // [
            //     'attribute' => 'in_complex',
            //     'label' => 'К',
            // ],
            // 'warning',

//            [
//                'attribute' => 'warning',
//                'label' => 'Ошибки',
//                'encodeLabel' => false,
//                'format' => 'raw',
////                'visible' => Yii::$app->user->identity->role_id <= '3',
//                /**
//                 * Переопределяем отображение фильтра.
//                 * Задаем выпадающий список с заданными значениями вместо поля для ввода
//                 */
//                // 'filter' => [
//                //     0 => 'Просрочено',
//                //     1 => 'Ожидаем',
//                // ],
//                /**
//                 * Переопределяем отображение самих данных.
//                 * Вместо 1 или 0 выводим Yes или No соответственно.
//                 * Попутно оборачиваем результат в span с нужным классом
//                 */
//                'value' => function ($model, $key, $index, $column) {
//
//                    return \yii\helpers\Html::tag(
//                        'span',
//                        ($model->warning ? '&#9899;' : '&#10004;'),
//                        [
//                            'style' => 'color: ' . ($model->warning ? 'red' : 'green'),
//                            'title' => ($model->warning ? 'есть ошибки' : 'нет ошибок'),
//                        ]
//                    );
//
//                },
//                // 'filter' => [ 0 => 'нет', 1 => 'есть'],
//            ],
            [
                'attribute' => 'no_report',
                'header' => 'Новый <br> договор',
                'format' => 'raw',
                'filter' => ['0' => 'Действующий', '1' => 'Новый'],
                'value' => function ($model) {
                    return \yii\helpers\Html::tag(
                        'i',
                        '',
                        [
                            'style' => 'color: ' . ($model->no_report ? 'green' : ''),
                            'title' => ($model->no_report ? 'нет отчетов' : ''),
                            'class' => ($model->no_report ? 'fas fa-circle' : ''),
                        ]
                    );

                },
            ],


            [
                 'format' => 'raw',
                 'attribute' => 'comment',
            ],
            //'comment',
            [
                 'format' => 'raw',
                 'attribute' => 'remark',
                 'header' => "Примечания <br> филиала",
            ],
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
                'visible' => \Yii::$app->user->can('pd_ca') or \Yii::$app->user->can('pd_edit'),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=> 'Действия', // Действия
                'headerOptions' => ['width' => '80'],
                'template' => '{view} <br> {link}', // '{view} {update} {link}',
                'buttons' => [
                    'view' => function ($url,$model,$key) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span> Карточка',
                            // $data->url,
                            ['/pd/pd-work/view', 'id' => $key],  // для запроса через GET
                            ['title' => 'Просмотр отчёта']
                        );
                    },
                    'link' => function ($url,$model,$key) {
                        return Html::a(
                        '<span class="glyphicon glyphicon-tasks"></span> Отчёт',
                        // $data->url,
                        ['/pd/pd-work-process/create', 'pd_work' => $key],  // для запроса через GET
                        ['title' => 'Процесс']
                        );
                    },
                ],
                'visible' => \Yii::$app->user->can('pd_view'),
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
                'visible' => \Yii::$app->user->can('pd_ca') or \Yii::$app->user->can('pd_view'),
            ],
            [
                'attribute' => 'code_1C',
                'visible' => \Yii::$app->user->can('pd_ca'),
            ],


           /* [
            'format' => 'html',
            'value' => function ($url) {
                return Html::a('процесс', ['/pd/pd-work-process/index', 'pd_work' => $url->id], ['class' => 'btn btn-success']);
                },
            ],*/
        ],
    ]); ?>


</div>
