<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\NsiContent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nsi-content-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'soli_id')->dropDownList(ArrayHelper::map(app\models\NsiInfo::find()->orderBy(['soli_id' => SORT_ASC])->all(), 'soli_id', 'attr_name'))->label("Код справочника (soli)") ?>

    <?= $form->field($model, 'class')->textInput() ?>

    <?= $form->field($model, 'cod')->textInput() ?>

    <?= $form->field($model, 'attr_textval')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'class_01')->textInput() ?>

    <?= $form->field($model, 'cod_01')->textInput() ?>

    <?= $form->field($model, 'class_02')->textInput() ?>

    <?= $form->field($model, 'cod_02')->textInput() ?>

    <?= $form->field($model, 'class_03')->textInput() ?>

    <?= $form->field($model, 'cod_03')->textInput() ?>

    <?= $form->field($model, 'class_04')->textInput() ?>

    <?= $form->field($model, 'cod_04')->textInput() ?>

    <?= $form->field($model, 'class_05')->textInput() ?>

    <?= $form->field($model, 'cod_05')->textInput() ?>

    <?= $form->field($model, 'class_06')->textInput() ?>

    <?= $form->field($model, 'cod_06')->textInput() ?>

    <?= $form->field($model, 'class_07')->textInput() ?>

    <?= $form->field($model, 'cod_07')->textInput() ?>

    <?= $form->field($model, 'class_08')->textInput() ?>

    <?= $form->field($model, 'cod_08')->textInput() ?>

    <?= $form->field($model, 'class_09')->textInput() ?>

    <?= $form->field($model, 'cod_09')->textInput() ?>

    <?= $form->field($model, 'class_10')->textInput() ?>

    <?= $form->field($model, 'cod_10')->textInput() ?>

    <?= $form->field($model, 'class_11')->textInput() ?>

    <?= $form->field($model, 'cod_11')->textInput() ?>

    <?= $form->field($model, 'class_12')->textInput() ?>

    <?= $form->field($model, 'cod_12')->textInput() ?>

    <?= $form->field($model, 'class_13')->textInput() ?>

    <?= $form->field($model, 'cod_13')->textInput() ?>

    <?= $form->field($model, 'class_14')->textInput() ?>

    <?= $form->field($model, 'cod_14')->textInput() ?>

    <?= $form->field($model, 'class_15')->textInput() ?>

    <?= $form->field($model, 'cod_15')->textInput() ?>

    <?= $form->field($model, 'class_16')->textInput() ?>

    <?= $form->field($model, 'cod_16')->textInput() ?>

    <?= $form->field($model, 'class_17')->textInput() ?>

    <?= $form->field($model, 'cod_17')->textInput() ?>

    <?= $form->field($model, 'class_18')->textInput() ?>

    <?= $form->field($model, 'cod_18')->textInput() ?>

    <?= $form->field($model, 'class_19')->textInput() ?>

    <?= $form->field($model, 'cod_19')->textInput() ?>

    <?= $form->field($model, 'class_20')->textInput() ?>

    <?= $form->field($model, 'cod_20')->textInput() ?>

    <?= $form->field($model, 'class_21')->textInput() ?>

    <?= $form->field($model, 'cod_21')->textInput() ?>

    <?= $form->field($model, 'class_22')->textInput() ?>

    <?= $form->field($model, 'cod_22')->textInput() ?>

    <?= $form->field($model, 'class_23')->textInput() ?>

    <?= $form->field($model, 'cod_23')->textInput() ?>

    <?= $form->field($model, 'class_24')->textInput() ?>

    <?= $form->field($model, 'cod_24')->textInput() ?>

    <?= $form->field($model, 'class_25')->textInput() ?>

    <?= $form->field($model, 'cod_25')->textInput() ?>

    <?= $form->field($model, 'class_26')->textInput() ?>

    <?= $form->field($model, 'cod_26')->textInput() ?>

    <?= $form->field($model, 'class_27')->textInput() ?>

    <?= $form->field($model, 'cod_27')->textInput() ?>

    <?= $form->field($model, 'class_28')->textInput() ?>

    <?= $form->field($model, 'cod_28')->textInput() ?>

    <?= $form->field($model, 'class_29')->textInput() ?>

    <?= $form->field($model, 'cod_29')->textInput() ?>

    <?= $form->field($model, 'class_30')->textInput() ?>

    <?= $form->field($model, 'cod_30')->textInput() ?>

    <?= $form->field($model, 'class_31')->textInput() ?>

    <?= $form->field($model, 'cod_31')->textInput() ?>

    <?= $form->field($model, 'class_32')->textInput() ?>

    <?= $form->field($model, 'cod_32')->textInput() ?>

    <?= $form->field($model, 'class_33')->textInput() ?>

    <?= $form->field($model, 'cod_33')->textInput() ?>

    <?= $form->field($model, 'class_34')->textInput() ?>

    <?= $form->field($model, 'cod_34')->textInput() ?>

    <?= $form->field($model, 'class_35')->textInput() ?>

    <?= $form->field($model, 'cod_35')->textInput() ?>

    <?= $form->field($model, 'class_36')->textInput() ?>

    <?= $form->field($model, 'cod_36')->textInput() ?>

    <?= $form->field($model, 'class_37')->textInput() ?>

    <?= $form->field($model, 'cod_37')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
