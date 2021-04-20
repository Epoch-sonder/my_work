<?php

use app\modules\pd\models\PdWork;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\file\FileInput;
$id = Yii::$app->request->get('pd_work');
$pdwork = PdWork::find()->where(['=' , 'id', "$id"] )->one();
?>


<?php
// Текущая дата для внесения в авто-поля
$curdate = date("Y-m-d");
?>

<?php if (!$pdwork['completed'] or Yii::$app->request->get('id')){ ?>
    <h2>Добавление отчета</h2>
<div class="pd-work-process-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'pd_work')->hiddenInput(['readonly' => true])->label(false) ?>

	<?= $form->field($model, 'report_date')->hiddenInput(['value' => $curdate, 'readonly' => true])->label(false); ?>

    <?php /*= $form->field($model, 'report_date')->widget(DatePicker::classname(),
    [
    'name' => 'report_date',
    'value' =>  date("Y-m-d"),
    'language' => 'ru-RU',
    'removeButton' => false,
    // 'disabled' => true,
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        'orientation' => 'top right',
        ]
    ]); */
    ?>

    <?php //= $form->field($model, 'pd_step')->textInput() ?>

    <?= $form->field($model, 'pd_object')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pd_step')->dropDownList(ArrayHelper::map(app\modules\pd\models\PdStep::find()->all(), 'id', 'step_name')) ?>

	<?= $form->field($model, 'step_startplan')->widget(DatePicker::classname(),
    [
    'language' => 'ru-RU',
    'removeButton' => false,
    // 'options' => [
    //     'value' => $curdate,
    // ],
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        'orientation' => 'top right',
        ]
    ]);
    ?>

	<?= $form->field($model, 'step_finishplan')->widget(DatePicker::classname(),
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

    <?= $form->field($model, 'comment')->textarea(['rows' => 3, 'cols' => 5]) ?>

    <?php 
/* 
        echo $form->field($model, 'progress_status')->textInput(['maxlength' => true])->label(false);
        echo $form->field($model, 'comment')->textInput(['maxlength' => true]);
        echo $form->field($model, 'resultdoc_name')->textInput(['maxlength' => true]);
        echo $form->field($model, 'resultdoc_num')->textInput();
        
        echo $form->field($model, 'resultdoc_date')->widget(DatePicker::classname(),
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
        
        echo $form->field($model, 'resultdoc_file')->fileInput();
        echo $form->field($model, 'docs')->hiddenInput()->label(false);
        echo $form->field($model, 'resultdoc_file')->textInput(['maxlength' => true]);
        echo $form->field($model, 'timestamp')->textInput();
*/
    ?>


    <?= $form->field($model, 'person_responsible')->hiddenInput(['readonly' => true])->label(false) ?>





    <div class="bottom_file "> <label class="control-label">Загрузка документа для отчета(.pdf) </label> <?= $form->field($model2, 'pdProcess')->fileInput(['id' => 'pdProcess'])->label(false) ;?></div>

    <?= $form->field($model2, 'pd_work')->hiddenInput(['value' => Yii::$app->request->get('pd_work'),'readonly' => true])->label(false); ?>
    <div class="form-group">  <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success printName']) ?> </div>
    <br>
    <?php ActiveForm::end(); ?>

</div>
  <?php  } ?>

<?php
$js = <<< JS

$('.printName').on('click', function (){
    if ($('#pdworkprocess-pd_step').val() == 5){
        var Ydelete = confirm('После сдачи-приемки работ договор будет считаться завершенным');
        if(Ydelete == false) return false;
    }
})
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($js, yii\web\View::POS_END);

?>