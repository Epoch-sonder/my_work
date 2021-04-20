<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\SearchZakupCard */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zakup-card-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'zakup_num') ?>

    <?= $form->field($model, 'zakup_link') ?>

    <?= $form->field($model, 'contest_type') ?>

    <?= $form->field($model, 'date_placement') ?>

    <?php // echo $form->field($model, 'price_start') ?>

    <?php // echo $form->field($model, 'contract_type') ?>

    <?php // echo $form->field($model, 'contract_num') ?>

    <?php // echo $form->field($model, 'finsource_type') ?>

    <?php // echo $form->field($model, 'customer_name') ?>

    <?php // echo $form->field($model, 'land_cat') ?>

    <?php // echo $form->field($model, 'fed_subject') ?>

    <?php // echo $form->field($model, 'region') ?>

    <?php // echo $form->field($model, 'region_subdiv') ?>

    <?php // echo $form->field($model, 'dzz_type') ?>

    <?php // echo $form->field($model, 'dzz_resolution') ?>

    <?php // echo $form->field($model, 'dzz_request_sent') ?>

    <?php // echo $form->field($model, 'dzz_cost') ?>

    <?php // echo $form->field($model, 'smp_attraction') ?>

    <?php // echo $form->field($model, 'timestamp') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
