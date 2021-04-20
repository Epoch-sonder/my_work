<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\audit\models\SearchAuditPerson */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Проверяющие специалисты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="audit-person-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<- вернуться к проверкам', ['../audit/audit/' ], ['class' => 'btn btn-primary']);?>
        <?= Html::a('Добавить специалиста', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Инструкция', ['/audit/audit/instruction'], ['class' => 'btn btn-danger']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'fio',
            'position',
            // 'branch',
            'branchName',
            'phone',
            'email',
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'<span class="glyphicon glyphicon-cog"></span>',
                'template' => '{update} {delete}', // '{view} {update} {delete}',
                'visible' => \Yii::$app->user->can('admin'),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'<span class="glyphicon glyphicon-cog"></span>',
                'template' => '{view}', // '{view} {update} {delete}',
                'visible' => \Yii::$app->user->can('tr_person_view'),
            ],
            [
                 'class' => 'yii\grid\ActionColumn',
                'template' => '{update}' ,
                'visible' =>\Yii::$app->user->can('tr_person_edit'),

            ]
        ],
    ]); ?>


</div>
