<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\map3\models\OivSubject */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oiv-subject-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //= $form->field($model, 'fed_subject')->textInput() ?>

    <?= $form->field($model, 'fed_subject')->dropDownList(ArrayHelper::map(app\modules\audit\models\FederalSubject::find()->orderBy('name ASC')->all(), 'federal_subject_id', 'name'))

    // dropDownList(ArrayHelper::map(app\modules\map3\models\Federalsubject::find()->orderBy(['federal_subject.name' => SORT_ASC])->all(), 'federal_subject_id', 'federalSubject.name')) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
