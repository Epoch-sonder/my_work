<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\CaCurator */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ca-curator-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //= $form->field($model, 'branch_kod')->textInput() ?>
    <?= $form->field($model, 'branch_kod')->dropDownList(ArrayHelper::map(app\models\Branch::find()->orderBy(['name' => SORT_ASC])->all(), 'branch_id', 'name')) ?>

    <?php //= $form->field($model, 'person_kod')->textInput() ?>
    <?= $form->field($model, 'person_kod')->dropDownList(ArrayHelper::map(app\models\User::find()->where('branch_id=0')->orderBy(['fio' => SORT_ASC])->all(), 'id', 'fio')) ?>

    <?= $form->field($model, 'comment')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
