<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\audit\models\SearchAudit */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Проверки переданных полномочий';
$this->params['breadcrumbs'][] = $this->title;

?>

<style>
    .form-inline{
        margin-top: 15px;
        margin-bottom: 30px;
    }

</style>
<div class="audit-index">
    <p>
        <?php
        if (\Yii::$app->user->can('audit__edit')){
            echo Html::a('Добавить проверку', ['create'], ['class' => 'btn btn-success']) . ' ' ;
            echo Html::a('Перейти к добавлению специалистов', ['../audit/audit-person/'], ['class' => 'btn btn-primary']);

        }
        ?>

        <?= Html::a('Перейти в ход проверок', ['../audit/audit-process/' ], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Перейти к своду', ['../audit/audit/summary' ], ['class' => 'btn btn-primary']) . '<br><br>'?>

        <?= Html::a('Инструкция', ['instruction'], ['class' => 'btn btn-danger']) ?>
    </p>

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
    $form = ActiveForm::begin(['method'=>'get','action'=>['index'], 'options' => ['class' => 'form-inline']]);

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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'date_start',
            'date_finish',
            'duration',
            // 'fed_district',
            'fedDistrictName',
            // 'fed_subject',
            'fedSubjectName',
            'oivSubjectName',
            'organizer',
            // 'audit_type',
            'auditTypeName',
            // 'audit_quantity',





            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'<span class="glyphicon glyphicon-cog"></span>',
                'template' => '{update}{delete}',
                'buttons' => [
                    'update' => function ($url,$model,$key) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                        ['/audit/audit/update', 'id' => $key , 'process'=>'1']);
                    },
                ],
                'visible' => \Yii::$app->user->can('admin'),
            ],


            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}' ,
                'buttons' => [
                    'update' => function ($url,$model,$key) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            ['/audit/audit/update', 'id' => $key , 'process'=>'1']);
                    },
                ],
                'visible' => \Yii::$app->user->can('audit__edit') and !\Yii::$app->user->can('admin'),

            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}' ,
                'buttons' => [
                    'update' => function ($url,$model,$key) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-eae"></span>',
                            ['/audit/audit/view', 'id' => $key , 'process'=>'1']);
                    },
                ],
                'visible' => \Yii::$app->user->can('audit__view'),

            ]
        ],
    ]); ?>


</div>
