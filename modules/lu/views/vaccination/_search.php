<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\SearchVaccination */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vaccination-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'person_id') ?>

    <?= $form->field($model, 'first_vaccination') ?>

    <?= $form->field($model, 'second_vaccination') ?>

    <?= $form->field($model, 'third_vaccination') ?>

    <?php // echo $form->field($model, 'url_docs') ?>

    <?php // echo $form->field($model, 'verified') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
