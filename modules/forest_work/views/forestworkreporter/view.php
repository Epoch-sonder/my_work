<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\forest_work\models\ForestWorkReporter */

$this->title = $model->reporter_id;
$this->params['breadcrumbs'][] = ['label' => 'Forest Work Reporters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="forest-work-reporter-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->reporter_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->reporter_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'reporter_id',
            'reporter_fio',
            'reporter_position',
            'reporter_tel',
        //    [
        //        'label' => 'Филиал',
        //        'value' => $model->branch->name,
        //    ],
            'reporterBranch.name',
        ],
    ]) ?>

</div>
