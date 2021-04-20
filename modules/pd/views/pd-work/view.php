<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pd\models\PdWork */

$this->title = $model->executor . ' - '. $model->workName->work_name;
$this->params['breadcrumbs'][] = ['label' => 'Проектная документация', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pd-work-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<- к общему списку', ['index'], ['class' => 'btn btn-primary']) ?>
        <?php /*= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) */ ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'executor',
            'branch0.name',
            'customer',
            'basedocType.doctype',
            'basedoc_name',
            'basedoc_datasign',
            'basedoc_datefinish',
            'work_cost',
            'work_datastart',
            'federalSubject.name',
            'forestry0.forestry_name',
            'subForestry.subforestry_name',
            'subdivforestry.name',
            'quarter',
            'work_area',
            'workName.work_name',
            'forestUsage.usage_name',
            'comment',
            //'timestamp',
        ],
    ]) ?>

</div>
