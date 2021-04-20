<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\Cityregion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cityregion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'subject_kod')->textInput() ?>

    <?= $form->field($model, 'cityregion_kod')->textInput() ?>

    <?= $form->field($model, 'cityregion_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
