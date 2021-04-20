<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\map3\models\OivSubject */

$this->title =  $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Oiv Subjects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="oiv-subject-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
