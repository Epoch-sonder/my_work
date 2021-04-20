<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pd\models\SearchPdWork */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pd-work-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'executor') ?>

    <?= $form->field($model, 'branch') ?>

    <?= $form->field($model, 'customer') ?>

    <?= $form->field($model, 'basedoc_type') ?>

    <?php // echo $form->field($model, 'basedoc_name') ?>

    <?php // echo $form->field($model, 'basedoc_datasign') ?>

    <?php // echo $form->field($model, 'basedoc_datefinish') ?>

    <?php // echo $form->field($model, 'work_cost') ?>

    <?php // echo $form->field($model, 'work_datastart') ?>

    <?php // echo $form->field($model, 'federal_subject') ?>

    <?php // echo $form->field($model, 'forestry') ?>

    <?php // echo $form->field($model, 'subforestry') ?>

    <?php // echo $form->field($model, 'subdivforestry') ?>

    <?php // echo $form->field($model, 'quarter') ?>

    <?php // echo $form->field($model, 'work_area') ?>

    <?php // echo $form->field($model, 'work_name') ?>

    <?php // echo $form->field($model, 'work_othername') ?>

    <?php // echo $form->field($model, 'forest_usage') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'timestamp') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
