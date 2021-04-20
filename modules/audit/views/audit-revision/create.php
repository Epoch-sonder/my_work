<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\AuditRevision */

$this->title = 'Создании ревизии';
$this->params['breadcrumbs'][] = ['label' => 'Audit Revisions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="audit-revision-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
