<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\SearchLuProcess */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lu-process-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'lu_object') ?>

    <?= $form->field($model, 'step_process') ?>

    <?= $form->field($model, 'person_responsible') ?>

    <?= $form->field($model, 'volume') ?>

    <?php // echo $form->field($model, 'staff') ?>

    <?php // echo $form->field($model, 'mtr') ?>

    <?php // echo $form->field($model, 'date_finish') ?>

    <?php // echo $form->field($model, 'reporter') ?>

    <?php // echo $form->field($model, 'timestamp') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
