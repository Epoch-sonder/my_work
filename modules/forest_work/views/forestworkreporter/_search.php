<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\forest_work\models\SearchForestWorkReporter */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="forest-work-reporter-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'reporter_id') ?>

    <?= $form->field($model, 'reporter_fio') ?>

    <?= $form->field($model, 'reporter_position') ?>

    <?= $form->field($model, 'reporter_tel') ?>

    <?= $form->field($model, 'reporter_branch') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
