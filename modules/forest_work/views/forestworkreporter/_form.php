<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

?>

<div class="forest-work-reporter-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'reporter_fio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reporter_position')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reporter_tel')->textInput() ?>

	<?= $form->field($model, 'reporter_branch')->dropDownList(ArrayHelper::map(app\modules\forest_work\models\Branch::find()->all(), 'branch_id', 'name')) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>