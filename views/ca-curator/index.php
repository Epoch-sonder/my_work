<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchCaCurator */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Кураторы филиалов РЛИ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ca-curator-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить куратора филиала', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'branch_kod',
            'branchName',
            // 'person_kod',
            'personName',
            'comment',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
