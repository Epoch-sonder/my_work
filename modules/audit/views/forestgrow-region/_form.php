<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\ForestgrowRegion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="forestgrow-region-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'forestgrow_zone')->dropDownList(ArrayHelper::map(app\modules\audit\models\ForestgrowZone::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'))->label("Лесорастительная зона") ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
