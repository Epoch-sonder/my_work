<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pd\models\PdWorktype */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pd-worktype-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'work_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'average_cost')->textInput() ?>

    <?= $form->field($model, 'average_humanday')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
