<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\audit\models\SearchAuditProcess */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ход проверок';
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="audit-process-index">

    <h1><?= Html::encode($this->title) ?></h1>
 <?php

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
    $form = ActiveForm::begin(['method'=>'get','action'=>['index?completed=1'], 'options' => ['class' => 'form-inline','style'=>'margin-bottom: 20px;
}']]);

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





    ?>
    <p>

        <?php if (!( \Yii::$app->user->can('audit_process_edit') or \Yii::$app->user->can('audit_process_view') )){
            echo Html::a('<- вернуться к проверкам', ['../audit/audit/'], ['class' => 'btn btn-primary']) . ' ';
            echo Html::a('Добавить процесс проверки', ['create'], ['class' => 'btn btn-success']) . ' ';
            echo Html::a('Инструкция', ['/audit/audit/instruction'], ['class' => 'btn btn-danger']) ;
        }?>


    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
//            'audit',
//            'audit_person',

            [
                'attribute' => 'federalSubjectName',
                'label' => 'Проверка по субьекту',
                'filter' => ArrayHelper::map(app\modules\pd\models\FederalSubject::find()->asArray()->orderBy(['name' => SORT_ASC])->all(), 'name', 'name'),
                'format' => 'raw',
                'value' => function($data){
                    $chapter_a = Html::a(
                            "$data->federalSubjectName",
                            ['../audit/audit/view?id='. $data->audit],
                            ['title' => 'Подробнее']);
                    return $chapter_a;
                    // return "<strong style='color:red'>123</strong>";
                    // return Html::a('X', ['create'], ['class' => 'btn btn-success']) ;
                },
            ],
            [
                'attribute' => 'auditFio',
                'label' => 'Проверяющий специалист',
//                'format' => 'raw',
//                'value' => function($data){
//                    $chapter_a = Html::a(
//                        "$data->auditFio",
//                        ['../audit/audit-person/view?id='. $data->audit_person],
//                        ['title' => 'Подробнее']);
//                    return $chapter_a;
//                    // return "<strong style='color:red'>123</strong>";
//                    // return Html::a('X', ['create'], ['class' => 'btn btn-success']) ;
//                },
            ],
            [
                'attribute' => 'audit_chapter',
                'label' => 'Раздел',
                'format' => 'raw',
                'value' => function($data){
                    $chapter_a = Html::a(
                            '<span class="glyphicon glyphicon-book"></span>',
//                            ['/lu/lu-process/index','zakup' => $key],
                            ['../audit/audit-process/view?id='. $data->id .'&process=1'],
                            ['title' => 'Подробнее']). ' '.$data->audit_chapter;
                    return $chapter_a;
                    // return "<strong style='color:red'>123</strong>";
                    // return Html::a('X', ['create'], ['class' => 'btn btn-success']) ;
                      },
            ],
            'date_start',
            'date_finish',
            [
                'label' => 'Дни',
                'value' => function($data) {
                    $dateS = $data->date_start;
                    $dateF = $data->date_finish;
                    if ($dateS != null and $dateF != null) {
                        $dateF = new \DateTime($data->date_finish);
                        $dateS = new \DateTime($data->date_start);
                        $DateAll = date_diff($dateS, $dateF);
                        $sumDate = $DateAll->d + 1;
                        $sumDateAll = $sumDate;
                        return $sumDateAll;
                    }
                    else{
                        return '';
                    }


                },
            ],
            'money_daily',
            'money_accomod',
            'money_transport',
            'money_other',
            [
                'label' => 'Все расходы, руб.',
                'value' => function($data){
                 $sumMoney = $data->money_daily + $data->money_accomod + $data->money_transport + $data->money_other;
                    return $sumMoney; },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'<span class="glyphicon glyphicon-cog"></span>',
                'template' => '{update} {delete}', // '{view} {update} {delete}',
                'visible' => \Yii::$app->user->can('admin') ,
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}' ,
                'visible' =>  \Yii::$app->user->can('audit_process_edit') ,

            ]
        ],
    ]); ?>


</div>
