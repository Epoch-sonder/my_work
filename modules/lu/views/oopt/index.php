<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\lu\models\SearchOopt */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Oopts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oopt-index">

    <h1><?= Html::encode($this->title) ?></h1>
     <?php if (\Yii::$app->user->can('admin')){ ?>
        <p>
            <?= Html::a('Create Oopt', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php }?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
//            'subject_kod',
//            'oopt_kod',
            'oopt_name',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}' ,
                'visible' => \Yii::$app->user->can('admin'),

            ]
        ],
    ]); ?>


</div>
