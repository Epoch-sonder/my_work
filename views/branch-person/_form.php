<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\BranchPerson */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .branch-person-form .field-branchperson-fio{
        width: 70%;
        padding-right: 3%;
        float: left;
    }

    .branch-person-form .field-branchperson-branch,
    .branch-person-form .field-branchperson-education{
        width: 27%;
        padding-right: 3%;
        float: left;
    }
    .branch-person-form .field-branchperson-division,
    .branch-person-form .field-branchperson-specialization{
        width: 43%;
        padding-right: 3%;
        float: left;
    }
    .branch-person-form .field-branchperson-position,
    .branch-person-form .field-branchperson-subdivision,
    .branch-person-form .field-branchperson-academic_degree{
        width: 27%;
        float: left;
    }
    .branch-person-form .field-branchperson-experience_specialty,
    .branch-person-form .field-branchperson-date_admission{
        width: 50%;
        padding-right: 3%;
        float: left;
    }
    .branch-person-form .field-branchperson-experience_work,
    .branch-person-form .field-branchperson-date_dismissial{
        width: 47%;
        float: left;
    }
    .branch-person-form .field-branchperson-remark{
        width: 100%;
        padding-right: 3%;
        float: left;
    }
    .label1{
        padding-left: 1%;
        border-top: 1px solid #c1c1c163;
        border-left: 1px solid #c1c1c163;
        border-right: 1px solid #c1c1c163;
        width: 66%;
        float: left;
    }
    .label2{
        padding-left: 1%;
        border-top: 1px solid #c1c1c163;
        border-right: 1px solid #c1c1c163 ;
        width: 33%;
        float: left;
    }
    .table1{
        border-bottom: 1px solid #c1c1c163;
        border-left: 1px solid #c1c1c163;
        padding-left: 5px;
        width: 33%;
        padding-right: 3%;
        float: left;
        margin-bottom: 8px;
    }
    .table2{
        border-bottom: 1px solid #c1c1c163;
        /*border-left: 1px solid #c1c1c163;*/
        border-right: 1px solid #c1c1c163;
        width: 33%;
        float: left;
        margin-bottom: 8px;
    }
    .table3{
        border-bottom: 1px solid #c1c1c163;
        border-right: 1px solid #c1c1c163;
        padding-left: 5px;
        padding-right: 5px;
        width: 33%;
        float: left;
        margin-bottom: 8px;
    }
    .who_works{
        width: 100%;
        padding-right: 3%;
        float: left;
    }

</style>
<div class="branch-person-form">

    <?php $form = ActiveForm::begin(); ?>
<div style="display: flow-root; width: 100%">
    <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>
</div>
    <?= $form->field($model, 'branch')->dropDownList(ArrayHelper::map(\app\models\Branch::find()->orderBy(['name' => SORT_ASC])->all(), 'branch_id', 'name')) ?>

    <?= $form->field($model, 'division')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subdivision')->textInput(['maxlength' => true]) ?>

    <!-- ЧЕК-БОКСЫ -->
    <div class="label1"><h4>Лесоустройство</h4></div>
    <div class="label2"><h4>Гил</h4></div>
    <div class="table1">
        <?= $form->field($model, 'lu_dzz')->checkbox([ 'value' => '1']) ?>

        <?= $form->field($model, 'lu_tax_eye')->checkbox([ 'value' => '1']) ?>

        <?= $form->field($model, 'lu_tax_aero')->checkbox([ 'value' => '1']) ?>

        <?= $form->field($model, 'lu_tax_actual')->checkbox([ 'value' => '1']) ?>
    </div>
    <div class="table2">
        <?= $form->field($model, 'lu_cameral1')->checkbox([ 'value' => '1']) ?>

        <?= $form->field($model, 'lu_cameral2')->checkbox([ 'value' => '1']) ?>

        <?= $form->field($model, 'lu_plot_allocation')->checkbox([ 'value' => '1']) ?>

        <?= $form->field($model, 'lu_park_inventory')->checkbox([ 'value' => '1']) ?>
    </div>
    <div class="table3">
        <?= $form->field($model, 'gil_field')->checkbox([ 'value' => '1']) ?>

        <?= $form->field($model, 'gil_cameral')->checkbox([ 'value' => '1']) ?>

        <?= $form->field($model, 'gil_ozvl_quality')->checkbox([ 'value' => '1']) ?>

        <?= $form->field($model, 'gil_remote_monitoring')->checkbox([ 'value' => '1']) ?>

    </div>





    <div style="display: flow-root; width: 100%">
    <?= $form->field($model, 'education')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'specialization')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'academic_degree')->textInput(['maxlength' => true]) ?>
    </div>
    <?= $form->field($model, 'experience_specialty')->textInput() ?>

    <?= $form->field($model, 'experience_work')->textInput() ?>

    <?= $form->field($model, 'date_admission')->widget(DatePicker::classname(),
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
        ]); ?>

    <?= $form->field($model, 'date_dismissial')->widget(DatePicker::classname(),
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
        ]); ?>

    <?= $form->field($model, 'remark')->textInput() ?>

    <div class="form-group" style="float: left">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$js = <<< JS


JS;

//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($js, yii\web\View::POS_END);
?>
