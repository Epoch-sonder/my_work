<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\AuditUnscheduled */

$this->title = 'Добавление внеплановой проверки';
$this->params['breadcrumbs'][] = ['label' => 'Audit Unscheduleds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="audit-unscheduled-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
