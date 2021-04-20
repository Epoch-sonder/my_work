<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\audit\models\SearchForestgrowRegionSubject */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Субъекты РФ и лесорастительные районы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forestgrow-region-subject-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'regionName',
            'subjectName',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
