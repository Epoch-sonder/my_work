<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\audit\models\SearchMunicRegion */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Муниципальные районы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="munic-region-index">

    <h1><?= Html::encode($this->title) ?></h1>
     <?php if (\Yii::$app->user->can('admin')){ ?>
        <p>
            <?= Html::a('Добавить муниципальный район', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php }?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'federalSubjectName',
            'forestgrowRegionName',
            'name',
            'full_name',

            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'<span class="glyphicon glyphicon-cog"></span>',
                'template' => '{view} {update} {delete}', // '{view} {update} {delete}',
                'visible' => \Yii::$app->user->can('admin'),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}' ,
                'visible' => \Yii::$app->user->can('munic_view'),

            ]
        ],
    ]); ?>


</div>
