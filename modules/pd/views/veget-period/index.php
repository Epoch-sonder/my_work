<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pd\models\SearchVegetPeriod */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Вегетационные периоды по субъектам РФ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="veget-period-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить вегетационный период', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            'id',
            // 'subject_id',
            'subjectName',
            'veget_start',
            'veget_finish',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
