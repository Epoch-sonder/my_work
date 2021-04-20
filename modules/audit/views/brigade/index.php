<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\audit\models\SearchBrigade */
/* @var $dataProvider yii\data\ActiveDataProvider */


$personalLes = \app\models\BranchPerson::find()->all();


$this->title = 'Бригада';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brigade-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    if (\Yii::$app->user->can('brigade_edit')){
        echo "<p>";
        echo Html::a('Добавить бригаду', ['create'], ['class' => 'btn btn-success']) ;
        echo "</p>";
    }
    ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'branchName',
            'subjectName',
            'forestgrowRegionName',
            'object_work',
            'contract',
            'date_begin',
            'brigade_number',
            [
                'attribute' => 'person',
                'label' => 'ФИО работников',
                'format' => 'raw',
                'value' => function ($data) use ($personalLes){
                    $personbranchs = explode(",", $data->person);
                    foreach ($personbranchs as $personbranch){
                        foreach ($personalLes as $personalLe){
                            if ($personalLe['id'] == $personbranch){
                                return $personalLe['fio'];
                            }
                        }
                    }
                },
            ],
            [
                'attribute' => 'date',
                'label' => 'Отчеты:',
                'format' => 'raw',
                'value' => function ($data) {
                    $brigadeOnline = \app\modules\audit\models\BrigadeOnline::find()->where(['=','brigade_number',"$data->id"])->orderBy(['date_report' => SORT_DESC])->select('date_report')->asArray()->one();

                    $dateThis = date_default_timezone_get();
                    $dateThis = new \DateTime($dateThis);

                    if ($dateThis->format('Y-m-d') == $dateThis->modify('monday')->format('Y-m-d')) $thisWeekStart = $dateThis->format('Y-m-d');
                    else $thisWeekStart = $dateThis->modify('previous monday')->format('Y-m-d');


                    $thisStart = new \DateTime($thisWeekStart);
                    $minusDayWeekStart = $thisStart->modify('-7 day')->format('Y-m-d');

                    $minusDayWeekFinish = $dateThis->modify('sunday')->modify('-7 day')->format('Y-m-d');
                    $thisWeekEnd = $dateThis->modify('next sunday')->format('Y-m-d');


                     if ($brigadeOnline['date_report'] >= $thisWeekStart and $brigadeOnline['date_report'] <= $thisWeekEnd)
                         return '';

                     elseif (!($brigadeOnline['date_report'] >= $thisWeekStart and $brigadeOnline['date_report'] <= $thisWeekEnd)
                         and !($brigadeOnline['date_report'] >= $minusDayWeekStart and $brigadeOnline['date_report'] <= $minusDayWeekFinish))
                         return '<span title="Нет отчёта более недели" style="color: red">⚫</span>';

                     elseif ($brigadeOnline['date_report'] >= $minusDayWeekStart and $brigadeOnline['date_report'] <= $minusDayWeekFinish)
                         return '<span title="Нет еженедельного отчёта" style="color: orange">⚫</span>';

                     else return '';
                },
            ],
            'remark',


            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'<span class="glyphicon glyphicon-cog"></span>',
                'template' => '{view} {update} {delete}', // '{view} {update} {delete}',
                'visible' => \Yii::$app->user->can('admin'),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'<span class="glyphicon glyphicon-cog"></span>',
                'template' => '{view} {update}', // '{view} {update} {delete}',
                'visible' => \Yii::$app->user->can('brigade_edit') and !\Yii::$app->user->can('admin'),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}' ,
                'visible' => \Yii::$app->user->can('brigade_view') ,
            ]
        ],
    ]); ?>


</div>
