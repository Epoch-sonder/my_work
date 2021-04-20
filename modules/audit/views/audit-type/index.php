<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\audit\models\SearchAuditType */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Типы проверок';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="audit-type-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить тип проверки', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'type',

            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'<span class="glyphicon glyphicon-cog"></span>',
                'template' => '{update} {delete}', // '{view} {update} {delete}',
                'visible' => \Yii::$app->user->can('admin'),
            ],
//            [
//                'class' => 'yii\grid\ActionColumn',
//                'template' => '{update}' ,
//
//
//            ]
        ],
    ]); ?>


</div>
