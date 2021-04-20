<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BranchPerson */

$this->title = 'Обновление информации о работнике:' . $model->fio;
$this->params['breadcrumbs'][] = ['label' => 'Branch People', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

?>
<div class="branch-person-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
