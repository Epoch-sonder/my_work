<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\CaCurator */

$this->title = 'Добавление куратора';
$this->params['breadcrumbs'][] = ['label' => 'Ca Curators', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ca-curator-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    
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
