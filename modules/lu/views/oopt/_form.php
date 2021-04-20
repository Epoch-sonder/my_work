<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\Oopt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oopt-form">

    <?php $form = ActiveForm::begin(); ?>

    <? // echo $form->field($model, 'subject_kod')->textInput() ?>

    <?// echo $form->field($model, 'oopt_kod')->textInput() ?>

    <?= $form->field($model, 'oopt_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
