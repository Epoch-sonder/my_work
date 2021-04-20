<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\TaxationWay */

$this->title = 'Update Taxation Way: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Taxation Ways', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="taxation-way-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
