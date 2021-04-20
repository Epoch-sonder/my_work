<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\audit\models\SearchTrainingPerson */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Участники коллективной тренировки';
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="training-person-index">

    <h1><?= Html::encode($this->title) ?></h1>
     <?php if (\Yii::$app->user->can('tr_person_edit')){ ?>
        <p>
            <?= Html::a('Добавить нового обучающего', ['create'], ['class' => 'btn btn-success']) ?>

        </p>
     <?php }?>
    <?= Html::a('Инструкция', ['/audit/training-process/instruction'], ['class' => 'btn btn-danger']) ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'fio',
            'position',
            [
                'attribute' => 'workplace_other',
                'label' => 'Место работы',
                'format' => 'raw',
                'value' => function($data){
                    if ($data->workplace_rli == 666){
                        return $data->workplace_other;
                    }
                    else{
                        $BranchName = \app\models\Branch::find()
                            ->select('name')
                            ->where(['branch_id'=> $data->workplace_rli ])
                            ->one();
                        return $BranchName['name'];
                    }
                },
            ],
//            'workplace_rli',
//            'workplace_other',

            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'<span class="glyphicon glyphicon-cog"></span>',
                'template' => '{view} {update}', // '{view} {update} {delete}',
                'visible' => \Yii::$app->user->can('tr_person_edit') and !\Yii::$app->user->can('admin'),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}' ,
                'visible' => \Yii::$app->user->can('admin'),

            ]
        ],
    ]); ?>


</div>
