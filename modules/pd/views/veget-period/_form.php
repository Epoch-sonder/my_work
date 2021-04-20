<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\modules\pd\models\VegetPeriod */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="veget-period-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //= $form->field($model, 'subject_id')->textInput() ?>
    <?= $form->field($model, 'subject_id')->dropDownList(ArrayHelper::map(app\modules\pd\models\FederalSubject::find()->all(), 'federal_subject_id', 'name')) ?>

    <?php //=$form->field($model, 'veget_start')->textInput() ?>

    <?= $form->field($model, 'veget_start')->widget(DatePicker::classname(),
	[
	'language' => 'ru-RU',
    'removeButton' => false,
	'pluginOptions' => [
		'autoclose' => true,
		'format' => 'yyyy-mm-dd',
		'todayHighlight' => true,
        'orientation' => 'top right',
		]
		]);
	?>



    <?php //= $form->field($model, 'veget_finish')->textInput() ?>

    <?= $form->field($model, 'veget_finish')->widget(DatePicker::classname(),
	[
	'language' => 'ru-RU',
    'removeButton' => false,
	'pluginOptions' => [
		'autoclose' => true,
		'format' => 'yyyy-mm-dd',
		'todayHighlight' => true,
        'orientation' => 'top right',
		]
		]);
	?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
