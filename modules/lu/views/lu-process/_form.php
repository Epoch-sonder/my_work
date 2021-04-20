<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\LuProcess */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lu-process-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'lu_object')->textInput() ?>

    <?= $form->field($model, 'step_process')->textInput() ?>

    <?= $form->field($model, 'person_responsible')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'volume')->textInput() ?>

    <?= $form->field($model, 'staff')->textInput() ?>

    <?= $form->field($model, 'mtr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_finish')->textInput() ?>

    <?= $form->field($model, 'reporter')->textInput() ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
