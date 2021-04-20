<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\lu\models\SearchLuPhase */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Фазы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lu-phase-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать фазу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'phase_number',
            'phase_name',
            'sort_order',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',],
        ],
    ]);
    ?>


</div>
