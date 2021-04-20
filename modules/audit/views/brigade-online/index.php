<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\audit\models\SearchBrigadeOnline */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Brigade Onlines';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brigade-online-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Brigade Online', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'brigade_number',
            'date_report',
            'remark',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
