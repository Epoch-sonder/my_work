<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BranchPerson */

$this->title = 'Информации о работнике: ' . $model->fio;
$this->params['breadcrumbs'][] = ['label' => 'Branch People', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="branch-person-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'fio',
            'position',
            'branch',
            'division',
            'subdivision',
            'lu_tax_eye',
            'lu_tax_aero',
            'lu_tax_actual',
            'lu_cameral1',
            'lu_cameral2',
            'lu_plot_allocation',
            'lu_park_inventory',
            'gil_field',
            'gil_cameral',
            'gil_ozvl_quality',
            'gil_remote_monitoring',
            'education',
            'specialization',
            'academic_degree',
            'experience_specialty',
            'experience_work',
            'date_admission',
            'date_dismissial',
            'remark',
            'num_brigade',
            'training_process_1',
            'training_process_2',
            'training_process_3',
        ],
    ]) ?>

</div>
