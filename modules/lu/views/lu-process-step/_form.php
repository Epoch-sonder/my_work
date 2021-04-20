<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\LuProcessStep */
/* @var $form yii\widgets\ActiveForm */





?>

<div class="lu-process-step-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'step_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'step_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'step_phase')->dropDownList(ArrayHelper::map(app\modules\lu\models\LuPhase::find()->all(), 'id', 'phase_name' )) ?>

    <?= $form->field($model, 'max_duration')->textInput() ?>

    <?= $form->field($model, 'sort_order')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
