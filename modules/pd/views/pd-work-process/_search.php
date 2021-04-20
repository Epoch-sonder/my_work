<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pd\models\SearchPdWorkProcess */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pd-work-process-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'pd_work') ?>

    <?= $form->field($model, 'pd_object') ?>

    <?= $form->field($model, 'report_date') ?>

    <?= $form->field($model, 'pd_step') ?>

    <?php // echo $form->field($model, 'step_startplan') ?>

    <?php // echo $form->field($model, 'step_finishplan') ?>

    <?php // echo $form->field($model, 'progress_status') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'resultdoc_name') ?>

    <?php // echo $form->field($model, 'resultdoc_num') ?>

    <?php // echo $form->field($model, 'resultdoc_date') ?>

    <?php // echo $form->field($model, 'resultdoc_file') ?>

    <?php // echo $form->field($model, 'person_responsible') ?>

    <?php // echo $form->field($model, 'timestamp') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
