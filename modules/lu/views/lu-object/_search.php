<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\SearchLuObject */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lu-object-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'zakup') ?>

    <?= $form->field($model, 'land_cat') ?>

    <?= $form->field($model, 'fed_subject') ?>

    <?= $form->field($model, 'region') ?>

    <?php // echo $form->field($model, 'region_subdiv') ?>

    <?php // echo $form->field($model, 'taxation_way') ?>

    <?php // echo $form->field($model, 'taxwork_cat') ?>

    <?php // echo $form->field($model, 'taxwork_vol') ?>

    <?php // echo $form->field($model, 'stage_prepare_vol') ?>

    <?php // echo $form->field($model, 'stage_prepare_year') ?>

    <?php // echo $form->field($model, 'stage_field_vol') ?>

    <?php // echo $form->field($model, 'stage_field_year') ?>

    <?php // echo $form->field($model, 'stage_cameral_vol') ?>

    <?php // echo $form->field($model, 'stage_cameral_year') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
