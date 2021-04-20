<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\SearchAuditProcess */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="audit-process-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'audit') ?>

    <?= $form->field($model, 'audit_person') ?>

    <?= $form->field($model, 'audit_chapter') ?>

    <?= $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'proposal') ?>

    <?php // echo $form->field($model, 'mooney_daily') ?>

    <?php // echo $form->field($model, 'money_accomod') ?>

    <?php // echo $form->field($model, 'money_transport') ?>

    <?php // echo $form->field($model, 'money_other') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
