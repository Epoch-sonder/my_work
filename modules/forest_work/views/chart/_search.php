<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\forest_work\models\SearchForestWork */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="forest-work-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'branch_id') ?>

    <?= $form->field($model, 'federal_subject_id') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'reporter') ?>

    <?php // echo $form->field($model, 'a1') ?>

    <?php // echo $form->field($model, 'a2') ?>

    <?php // echo $form->field($model, 'a3') ?>

    <?php // echo $form->field($model, 'a4') ?>

    <?php // echo $form->field($model, 'a5') ?>

    <?php // echo $form->field($model, 'a6') ?>

    <?php // echo $form->field($model, 'a7') ?>

    <?php // echo $form->field($model, 'a8') ?>

    <?php // echo $form->field($model, 'a9') ?>

    <?php // echo $form->field($model, 'a10') ?>

    <?php // echo $form->field($model, 'a11') ?>

    <?php // echo $form->field($model, 'a12') ?>

    <?php // echo $form->field($model, 'a13') ?>

    <?php // echo $form->field($model, 'a14') ?>

    <?php // echo $form->field($model, 'a15') ?>

    <?php // echo $form->field($model, 'a16') ?>

    <?php // echo $form->field($model, 'a17') ?>

    <?php // echo $form->field($model, 'b1') ?>

    <?php // echo $form->field($model, 'b2') ?>

    <?php // echo $form->field($model, 'b3') ?>

    <?php // echo $form->field($model, 'b4') ?>

    <?php // echo $form->field($model, 'b5') ?>

    <?php // echo $form->field($model, 'b6') ?>

    <?php // echo $form->field($model, 'b7') ?>

    <?php // echo $form->field($model, 'b8') ?>

    <?php // echo $form->field($model, 'b9') ?>

    <?php // echo $form->field($model, 'b10') ?>

    <?php // echo $form->field($model, 'b11') ?>

    <?php // echo $form->field($model, 'b12') ?>

    <?php // echo $form->field($model, 'b13') ?>

    <?php // echo $form->field($model, 'b14') ?>

    <?php // echo $form->field($model, 'b15') ?>

    <?php // echo $form->field($model, 'b16') ?>

    <?php // echo $form->field($model, 'b17') ?>

    <?php // echo $form->field($model, 'timestamp') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
