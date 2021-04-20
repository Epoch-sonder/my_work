<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SearchNsiContent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nsi-content-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'soli_id') ?>

    <?= $form->field($model, 'class') ?>

    <?= $form->field($model, 'cod') ?>

    <?= $form->field($model, 'attr_textval') ?>

    <?php // echo $form->field($model, 'class_01') ?>

    <?php // echo $form->field($model, 'cod_01') ?>

    <?php // echo $form->field($model, 'class_02') ?>

    <?php // echo $form->field($model, 'cod_02') ?>

    <?php // echo $form->field($model, 'class_03') ?>

    <?php // echo $form->field($model, 'cod_03') ?>

    <?php // echo $form->field($model, 'class_04') ?>

    <?php // echo $form->field($model, 'cod_04') ?>

    <?php // echo $form->field($model, 'class_05') ?>

    <?php // echo $form->field($model, 'cod_05') ?>

    <?php // echo $form->field($model, 'class_06') ?>

    <?php // echo $form->field($model, 'cod_06') ?>

    <?php // echo $form->field($model, 'class_07') ?>

    <?php // echo $form->field($model, 'cod_07') ?>

    <?php // echo $form->field($model, 'class_08') ?>

    <?php // echo $form->field($model, 'cod_08') ?>

    <?php // echo $form->field($model, 'class_09') ?>

    <?php // echo $form->field($model, 'cod_09') ?>

    <?php // echo $form->field($model, 'class_10') ?>

    <?php // echo $form->field($model, 'cod_10') ?>

    <?php // echo $form->field($model, 'class_11') ?>

    <?php // echo $form->field($model, 'cod_11') ?>

    <?php // echo $form->field($model, 'class_12') ?>

    <?php // echo $form->field($model, 'cod_12') ?>

    <?php // echo $form->field($model, 'class_13') ?>

    <?php // echo $form->field($model, 'cod_13') ?>

    <?php // echo $form->field($model, 'class_14') ?>

    <?php // echo $form->field($model, 'cod_14') ?>

    <?php // echo $form->field($model, 'class_15') ?>

    <?php // echo $form->field($model, 'cod_15') ?>

    <?php // echo $form->field($model, 'class_16') ?>

    <?php // echo $form->field($model, 'cod_16') ?>

    <?php // echo $form->field($model, 'class_17') ?>

    <?php // echo $form->field($model, 'cod_17') ?>

    <?php // echo $form->field($model, 'class_18') ?>

    <?php // echo $form->field($model, 'cod_18') ?>

    <?php // echo $form->field($model, 'class_19') ?>

    <?php // echo $form->field($model, 'cod_19') ?>

    <?php // echo $form->field($model, 'class_20') ?>

    <?php // echo $form->field($model, 'cod_20') ?>

    <?php // echo $form->field($model, 'class_21') ?>

    <?php // echo $form->field($model, 'cod_21') ?>

    <?php // echo $form->field($model, 'class_22') ?>

    <?php // echo $form->field($model, 'cod_22') ?>

    <?php // echo $form->field($model, 'class_23') ?>

    <?php // echo $form->field($model, 'cod_23') ?>

    <?php // echo $form->field($model, 'class_24') ?>

    <?php // echo $form->field($model, 'cod_24') ?>

    <?php // echo $form->field($model, 'class_25') ?>

    <?php // echo $form->field($model, 'cod_25') ?>

    <?php // echo $form->field($model, 'class_26') ?>

    <?php // echo $form->field($model, 'cod_26') ?>

    <?php // echo $form->field($model, 'class_27') ?>

    <?php // echo $form->field($model, 'cod_27') ?>

    <?php // echo $form->field($model, 'class_28') ?>

    <?php // echo $form->field($model, 'cod_28') ?>

    <?php // echo $form->field($model, 'class_29') ?>

    <?php // echo $form->field($model, 'cod_29') ?>

    <?php // echo $form->field($model, 'class_30') ?>

    <?php // echo $form->field($model, 'cod_30') ?>

    <?php // echo $form->field($model, 'class_31') ?>

    <?php // echo $form->field($model, 'cod_31') ?>

    <?php // echo $form->field($model, 'class_32') ?>

    <?php // echo $form->field($model, 'cod_32') ?>

    <?php // echo $form->field($model, 'class_33') ?>

    <?php // echo $form->field($model, 'cod_33') ?>

    <?php // echo $form->field($model, 'class_34') ?>

    <?php // echo $form->field($model, 'cod_34') ?>

    <?php // echo $form->field($model, 'class_35') ?>

    <?php // echo $form->field($model, 'cod_35') ?>

    <?php // echo $form->field($model, 'class_36') ?>

    <?php // echo $form->field($model, 'cod_36') ?>

    <?php // echo $form->field($model, 'class_37') ?>

    <?php // echo $form->field($model, 'cod_37') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
