<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SearchNsiInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nsi-info-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'soli_id') ?>

    <?= $form->field($model, 'attr_name') ?>

    <?= $form->field($model, 'maket_numb') ?>

    <?= $form->field($model, 'pole_numb') ?>

    <?= $form->field($model, 'winplp') ?>

    <?php // echo $form->field($model, 'pl') ?>

    <?php // echo $form->field($model, 'topol') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
