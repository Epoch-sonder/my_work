<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\LuProcessStep */

$this->title = 'Создание шага для стадии';
$this->params['breadcrumbs'][] = ['label' => 'Lu Process Steps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lu-process-step-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
