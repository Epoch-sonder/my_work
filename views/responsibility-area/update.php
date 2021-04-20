<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ResponsibilityArea */

$this->title = 'Изменение Зоны ответственности: ' . $model->responsibility_area_id;
$this->params['breadcrumbs'][] = ['label' => 'Зоны ответственности', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->responsibility_area_id, 'url' => ['view', 'id' => $model->responsibility_area_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="responsibility-area-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
