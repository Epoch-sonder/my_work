<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\SearchGpsTracking */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gps-tracking-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'branch') ?>

    <?= $form->field($model, 'contract') ?>

    <?= $form->field($model, 'specialist') ?>

    <?= $form->field($model, 'april_recd') ?>

    <?php // echo $form->field($model, 'april_check') ?>

    <?php // echo $form->field($model, 'may_recd') ?>

    <?php // echo $form->field($model, 'may_check') ?>

    <?php // echo $form->field($model, 'june_recd') ?>

    <?php // echo $form->field($model, 'june_check') ?>

    <?php // echo $form->field($model, 'july_recd') ?>

    <?php // echo $form->field($model, 'july_check') ?>

    <?php // echo $form->field($model, 'august_recd') ?>

    <?php // echo $form->field($model, 'august_check') ?>

    <?php // echo $form->field($model, 'september_recd') ?>

    <?php // echo $form->field($model, 'september_check') ?>

    <?php // echo $form->field($model, 'october_recd') ?>

    <?php // echo $form->field($model, 'october_check') ?>

    <?php // echo $form->field($model, 'november_recd') ?>

    <?php // echo $form->field($model, 'november_check') ?>

    <?php // echo $form->field($model, 'party_leader') ?>

    <?php // echo $form->field($model, 'fio_responsible') ?>

    <?php // echo $form->field($model, 'date_create') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
