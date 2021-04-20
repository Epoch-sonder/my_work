<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\SearchAudit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="audit-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'date_start') ?>

    <?= $form->field($model, 'date_finish') ?>

    <?= $form->field($model, 'fed_district') ?>

    <?= $form->field($model, 'fed_subject') ?>

    <?php // echo $form->field($model, 'oiv') ?>

    <?php // echo $form->field($model, 'organizer') ?>

    <?php // echo $form->field($model, 'audit_type') ?>

    <?php // echo $form->field($model, 'audit_quantity') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
