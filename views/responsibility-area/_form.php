<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\ResponsibilityArea */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="responsibility-area-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //= $form->field($model, 'federal_subject_id')->textInput() ?>
    <?= $form->field($model, 'federal_subject_id')->dropDownList(ArrayHelper::map(app\models\FederalSubject::find()->orderBy(['name' => SORT_ASC])->all(), 'federal_subject_id', 'name')) ?>

    <?php //= $form->field($model, 'branch_id')->textInput() ?>
    <?= $form->field($model, 'branch_id')->dropDownList(ArrayHelper::map(app\models\Branch::find()->orderBy(['name' => SORT_ASC])->all(), 'branch_id', 'name')) ?>

    <?php //= $form->field($model, 'with_order')->textInput() ?>
    <?= $form->field($model, 'with_order')->dropDownList(['0' => 'Нет', '1' => 'Да']); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
