<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\NsiInfo */

$this->title = 'Update Nsi Info: ' . $model->soli_id;
$this->params['breadcrumbs'][] = ['label' => 'Nsi Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->soli_id, 'url' => ['view', 'id' => $model->soli_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="nsi-info-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
