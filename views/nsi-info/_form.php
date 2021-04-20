<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\NsiInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nsi-info-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'soli_id')->textInput() ?>

    <?= $form->field($model, 'attr_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'maket_numb')->textInput() ?>

    <?= $form->field($model, 'pole_numb')->textInput() ?>

    <?= $form->field($model, 'winplp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pl')->textInput() ?>

    <?= $form->field($model, 'topol')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
