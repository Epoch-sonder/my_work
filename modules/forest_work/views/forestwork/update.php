<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\forest_work\models\ForestWork */

$this->title = 'Update Forest Work: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Forest Works', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="forest-work-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
