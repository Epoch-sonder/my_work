<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SearchBranchPerson */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="branch-person-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fio') ?>

    <?= $form->field($model, 'position') ?>

    <?= $form->field($model, 'branch') ?>

    <?= $form->field($model, 'division') ?>

    <?php // echo $form->field($model, 'subdivision') ?>

    <?php // echo $form->field($model, 'lu_dzz') ?>

    <?php // echo $form->field($model, 'lu_tax_eye') ?>

    <?php // echo $form->field($model, 'lu_tax_aero') ?>

    <?php // echo $form->field($model, 'lu_tax_actual') ?>

    <?php // echo $form->field($model, 'lu_cameral1') ?>

    <?php // echo $form->field($model, 'lu_cameral2') ?>

    <?php // echo $form->field($model, 'lu_plot_allocation') ?>

    <?php // echo $form->field($model, 'lu_park_inventory') ?>

    <?php // echo $form->field($model, 'gil_field') ?>

    <?php // echo $form->field($model, 'gil_cameral') ?>

    <?php // echo $form->field($model, 'gil_ozvl_quality') ?>

    <?php // echo $form->field($model, 'gil_remote_monitoring') ?>

    <?php // echo $form->field($model, 'education') ?>

    <?php // echo $form->field($model, 'specialization') ?>

    <?php // echo $form->field($model, 'academic_degree') ?>

    <?php // echo $form->field($model, 'experience_specialty') ?>

    <?php // echo $form->field($model, 'experience_work') ?>

    <?php // echo $form->field($model, 'date_admission') ?>

    <?php // echo $form->field($model, 'date_dismissial') ?>

    <?php // echo $form->field($model, 'remark') ?>

    <?php // echo $form->field($model, 'num_brigade') ?>

    <?php // echo $form->field($model, 'training_process_1') ?>

    <?php // echo $form->field($model, 'training_process_2') ?>

    <?php // echo $form->field($model, 'training_process_3') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
