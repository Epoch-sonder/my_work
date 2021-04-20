<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\AuditType */

$this->title = 'Добавить тип проверки';
$this->params['breadcrumbs'][] = ['label' => 'Audit Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="audit-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
