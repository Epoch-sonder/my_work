<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchOoptBinding */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Oopt Bindings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oopt-binding-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Все ООПТ', ['../lu/oopt/' ], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Создание   Oopt Binding', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ooptName',
            'subjectName',
            'municName',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
