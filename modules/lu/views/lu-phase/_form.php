<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\LuPhase */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lu-phase-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'phase_name')->textInput(['maxlength' => true]) ?>
    <br> <br> <br> <br>  <br> <br>
    <?= $form->field($model, 'phase_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort_order')->textInput() ?>

    <br> <br> <br> <br>  <br> <br>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
