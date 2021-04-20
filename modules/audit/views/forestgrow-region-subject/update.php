<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\ForestgrowRegionSubject */

$this->title = 'Редактировать запись: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Forestgrow Region Subjects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="forestgrow-region-subject-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
