<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\LuObjectProcess */
/* @var $form yii\widgets\ActiveForm */
$date = new DateTime();
$date = $date->format('Y');

?>

<div class="lu-object-process-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'lu_object')->hiddenInput(['value' => Yii::$app->request->get('object')])->label(false) ?>

    <?= $form->field($model, 'lu_process_step')->hiddenInput(['value' => Yii::$app->request->get('step')])->label(false) ?>

    <?= $form->field($model, 'year')->hiddenInput(['value' => $date])->label(false) ?>


    <table class="table table-striped table-bordered detail-view">
        <tr>
            <th>Выберите месяц</th>
            <th>Плановый объем, га</th>
            <th>Фактический объем, га</th>
            <th></th>
        </tr>
        <tr>
            <th> <?= $form->field($model, 'month')->dropDownList(ArrayHelper::map(app\modules\lu\models\Month::find()->all(), 'id', 'name'))->label(false)?></th>
            <th> <?= $form->field($model, 'plan')->textInput()->label(false) ?></th>
            <th> <?= $form->field($model, 'fact')->textInput()->label(false) ?></th>
            <th>
                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                </div>
            </th>
        </tr>
    </table>
    <?php ActiveForm::end(); ?>

</div>
