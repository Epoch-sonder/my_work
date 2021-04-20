<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\lu\models\SearchLuProcessStep */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Шаги для стадий лесоустройств';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lu-process-step-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создание шага', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'sort_order',
            'step_number',
            'step_name',

            [
                'attribute' => 'StPhases',
                'label' => 'Номер фазы',
            ],
            'max_duration',
           

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',],
        ],
    ]); ?>


</div>
