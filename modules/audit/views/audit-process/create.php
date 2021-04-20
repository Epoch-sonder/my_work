<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\AuditProcess */

$this->title = 'Ход проверки (добавление)';
$this->params['breadcrumbs'][] = ['label' => 'Ход проверки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="audit-process-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
