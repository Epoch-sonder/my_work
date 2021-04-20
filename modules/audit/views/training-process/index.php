<?php

use app\models\BranchPerson;
use app\modules\audit\models\TrainingPerson;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\audit\models\SearchTrainingProcess */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Тренировочный процесс';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="training-process-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    if (\Yii::$app->user->can('tr_process_edit')){
        echo "<p>";
        echo Html::a('Добавить тренировочный процесс', ['create'], ['class' => 'btn btn-success']);
        echo "</p>";
    }
    ?>
    <p>
        <?= Html::a('Инструкция', ['instruction'], ['class' => 'btn btn-danger']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',

            'branchName',
            'subjectName',
            'forestgrowRegionName',
            'municName',


            // 'personFio',
            //'forestry',
            //'subforestry',
            //'quarter',
            //'strip',
            //'traininng_forestry',
            //'training_site_amount',
            //'training_strip_amount',

          [
            'attribute' => 'personFio',
//            'label' => 'Период тренировки',
            'label' => 'Участник тренировки',
            'format' => 'raw',
            'value' => function($data) use($TrainingPs , $branchPeopleNames){
                $array = '';
                $arrayPeople = $data->person;
                $arrayPeople = explode(",", $arrayPeople);
                $arrayPeople = array_flip($arrayPeople);
                foreach ($branchPeopleNames as $branchPeopleName){
                    if (isset($arrayPeople[$branchPeopleName['id']])){
                        if ($array == null) $array =  $branchPeopleName['fio'] ;
                        else  $array .= '<br>' . $branchPeopleName['fio'] ;
                    }
                }
                foreach ($TrainingPs as $TrainingP){
                    if (isset($arrayPeople[$TrainingP['id'].'(666)'])){
                        if ($array == null) $array = $TrainingP['fio'].' (' .$TrainingP['workplace_other'].')' ;
                        else  $array .= '<br>' . $TrainingP['fio'] .' (' .$TrainingP['workplace_other'].')';
                    }
                }

                return $array;
                },
            ],

            [
                'attribute' => 'date',
                'label' => 'Даты тренировки',
                'format' => 'raw',
                'value' => function($data){
                    $dateS = $data->training_date_start;
                    $dateF = $data->training_date_finish;
                    if ($dateS != null and $dateF != null) {
                        $dateS = new \DateTime($data->training_date_start);
                        $dateF = new \DateTime($data->training_date_finish);
                        $DateAll = date_diff($dateF, $dateS);
                        $sumDate = $DateAll->d + 1;
                        $sumDateAll = "C " . $data->training_date_start . '<br> по ' . $data->training_date_finish . '.<br> Количество дней: ' . $sumDate;
                        return $sumDateAll;

                    }
                    elseif($dateS != null and $dateF == null) {
                        $sumDateAll = "". 'С ' . $data->training_date_start . '.<br> Количество дней: дата конца тренировки не указана';
                        return $sumDateAll;
                    }
                    elseif($dateS == null and $dateF != null) {
                        $sumDateAll = "По ". $data->training_date_finish . '.<br> Количество дней: дата начала тренировки не указана';
                        return $sumDateAll;
                    }
                    elseif($dateS == null and $dateF == null) {
                        return  'Дата начала тренировки и ее конец не указан';
                    }
                },
            ],
            'training_contract_num',

            [
                'attribute' => 'verified',
                'label' => 'Проверено',
                'format' => 'raw',
                'filter' => [ 0 => 'Не проверено', 1 => 'проверено'],
                'value' => function ($model, $key, $index, $column) {
                    $active = $model->{$column->attribute} === 1;
                    return \yii\helpers\Html::tag(
                        'span',
                        $active ? 'проверено' : 'Не проверено',
                        ['class' => 'label label-' . ($active ? 'success' : 'danger'),]
                    );
                },
                'visible' => Yii::$app->user->identity->branch_id == 0,
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'<span class="glyphicon glyphicon-cog"></span>',
                'template' => '{update} {view}', // '{view} {update} {delete}',
                'visible' =>  \Yii::$app->user->can('admin') or \Yii::$app->user->can('tr_process_edit') and  \Yii::$app->user->can('tr_process_view'),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'<span class="glyphicon glyphicon-cog"></span>',
                'template' => '{view}', // '{view} {update} {delete}',
                'visible' =>  \Yii::$app->user->can('tr_process_check'),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}' ,
                'visible' =>\Yii::$app->user->can('tr_process_edit') and !(\Yii::$app->user->can('tr_process_view')) and !(\Yii::$app->user->can('admin')) ,
                'buttons' => [
                    'update' => function ($url, $model,$key ) {
                        if ($model->verified == 1){
                            return Html::a(
                                '<span class="glyphicon glyphicon-eye-open"></span>',
                                // $data->url,
                                ['/audit/training-process/view', 'id' => $key],  // для запроса через GET
                                ['title' => 'Правка']
                            );
                        }
                        else{
                            return Html::a(
                                '<span class="glyphicon glyphicon-pencil"></span>',
                                // $data->url,
                                ['/audit/training-process/update', 'id' => $key],  // для запроса через GET
                                ['title' => 'Просмотр']
                            );
                        }
                    }
                ],

            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}' ,
                'visible' =>(\Yii::$app->user->can('tr_process_view')),

            ],
        ],
    ]); ?>


</div>
