<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\AuditPerson */

$this->title = 'Добавление проверяющего специалиста';
$this->params['breadcrumbs'][] = ['label' => 'Специалист', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="audit-person-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
