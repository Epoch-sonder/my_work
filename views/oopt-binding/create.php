<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OoptBinding */

$this->title = 'Создание Oopt Binding';
$this->params['breadcrumbs'][] = ['label' => 'Oopt Bindings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oopt-binding-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
