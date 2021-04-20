<?php

use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\GpsTracking */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .col-sm-1{
        padding-top: 20px;
    }
</style>
<div class="gps-tracking-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'branch')->dropDownList(ArrayHelper::map(\app\models\Branch::find()->orderBy(['name' => SORT_ASC])->all(), 'branch_id', 'name')) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'contract')->dropDownList(ArrayHelper::map(\app\modules\lu\models\ZakupCard::find()->orderBy(['zakup_num' => SORT_ASC])->all(), 'id', 'zakup_num')) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'specialist')->dropDownList(ArrayHelper::map(\app\models\BranchPerson::find()->where(['is not','num_brigade',null])->orderBy(['fio' => SORT_ASC])->all(), 'id', 'fio')) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'party_leader')->dropDownList(ArrayHelper::map(\app\models\BranchPerson::find()->where(['is not','num_brigade',null])->orderBy(['fio' => SORT_ASC])->all(), 'id', 'fio')) ?>
        </div>
        <?php if (\Yii::$app->user->can('admin')){?>
        <div class="col-sm-3">
            <?= $form->field($model, 'april_recd')->widget(DatePicker::classname(),
                [
                    'language' => 'ru-RU',
                    'removeButton' => false,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                        // 'format' => 'dd-mm-yyyy',
                        'todayHighlight' => true,
                        'orientation' => 'top right',
                    ]
                ]);
            ?>
        </div>
        
        <div class="col-sm-3">
            <?= $form->field($model, 'may_recd')->widget(DatePicker::classname(),
                [
                'language' => 'ru-RU',
                'removeButton' => false,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    // 'format' => 'dd-mm-yyyy',
                    'todayHighlight' => true,
                    'orientation' => 'top right',
                    ]
                    ]);
                ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'june_recd')->widget(DatePicker::classname(),
                [
                'language' => 'ru-RU',
                'removeButton' => false,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    // 'format' => 'dd-mm-yyyy',
                    'todayHighlight' => true,
                    'orientation' => 'top right',
                    ]
                    ]);
                ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'july_recd')->widget(DatePicker::classname(),
                [
                'language' => 'ru-RU',
                'removeButton' => false,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    // 'format' => 'dd-mm-yyyy',
                    'todayHighlight' => true,
                    'orientation' => 'top right',
                    ]
                    ]);
                ?>
        </div>

        <div class="col-sm-3">
            <?= $form->field($model, 'august_recd')->widget(DatePicker::classname(),
    [
	'language' => 'ru-RU',
    'removeButton' => false,
	'pluginOptions' => [
		'autoclose' => true,
		'format' => 'yyyy-mm-dd',
        // 'format' => 'dd-mm-yyyy',
		'todayHighlight' => true,
        'orientation' => 'top right',
		]
		]);
    ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'september_recd')->widget(DatePicker::classname(),
    [
	'language' => 'ru-RU',
    'removeButton' => false,
	'pluginOptions' => [
		'autoclose' => true,
		'format' => 'yyyy-mm-dd',
        // 'format' => 'dd-mm-yyyy',
		'todayHighlight' => true,
        'orientation' => 'top right',
		]
		]);
    ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'october_recd')->widget(DatePicker::classname(),
    [
	'language' => 'ru-RU',
    'removeButton' => false,
	'pluginOptions' => [
		'autoclose' => true,
		'format' => 'yyyy-mm-dd',
        // 'format' => 'dd-mm-yyyy',
		'todayHighlight' => true,
        'orientation' => 'top right',
		]
		]);
    ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'november_recd')->widget(DatePicker::classname(),
    [
	'language' => 'ru-RU',
    'removeButton' => false,
	'pluginOptions' => [
		'autoclose' => true,
		'format' => 'yyyy-mm-dd',
        // 'format' => 'dd-mm-yyyy',
		'todayHighlight' => true,
        'orientation' => 'top right',
		]
		]);
    ?>
        </div>
        <?php }?>
    </div>


    <?= $form->field($model, 'fio_responsible')->hiddenInput(['value'=>Yii::$app->user->identity->id])->label(false) ?>

    <?= $form->field($model, 'date_create')->hiddenInput(['value'=>date("Y-m-d")])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
