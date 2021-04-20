<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pd\models\PdWorkProcess */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pd Work Processes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pd-work-process-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'pd_work',
            'pd_object',
            'report_date',
            'pd_step',
            'step_startplan',
            'step_finishplan',
            'progress_status',
            'comment',
            'resultdoc_name',
            'resultdoc_num',
            'resultdoc_date',
            'resultdoc_file',
            'person_responsible',
            'timestamp',
        ],
    ]) ?>

</div>
