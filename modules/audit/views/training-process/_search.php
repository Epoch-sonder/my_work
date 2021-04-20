<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\SearchTrainingProcess */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="training-process-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'branch') ?>

    <?= $form->field($model, 'subject') ?>

    <?= $form->field($model, 'forestgrow_region') ?>

    <?= $form->field($model, 'munic_region') ?>

    <?php // echo $form->field($model, 'forestry') ?>

    <?php // echo $form->field($model, 'subforestry') ?>

    <?php // echo $form->field($model, 'quarter') ?>

    <?php // echo $form->field($model, 'strip') ?>

    <?php // echo $form->field($model, 'traininng_forestry') ?>

    <?php // echo $form->field($model, 'training_site_amount') ?>

    <?php // echo $form->field($model, 'training_strip_amount') ?>

    <?php // echo $form->field($model, 'training_contract_num') ?>

    <?php // echo $form->field($model, 'training_date_start') ?>

    <?php // echo $form->field($model, 'training_date_finish') ?>

    <?php // echo $form->field($model, 'person') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
