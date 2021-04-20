<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\MunicRegion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="munic-region-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'federal_subject')->dropDownList(ArrayHelper::map(app\modules\audit\models\FederalSubject::find()->orderBy(['name' => SORT_ASC])->all(), 'federal_subject_id', 'name')) ?>

    <?= $form->field($model, 'forestgrow_region')->dropDownList(ArrayHelper::map(app\modules\audit\models\ForestgrowRegion::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
    <script type='text/javascript'>
        var regSubArr = <?= json_encode($RegSubArr) ?>;
    </script>
<?php
$js = <<< JS
var fpress2 =  $('#municregion-federal_subject').val(); // запоминает знаяения для upload form
var fpress3 =  $('#municregion-forestgrow_region').val(); // запоминает знаяения для upload form
var subj;

$('#municregion-federal_subject').on('change', function() { // При изменение субьекта РФ вызывает функцию
     subj = $('#municregion-federal_subject').val();
    changeValLR();
});

function changeValLR() {
    $("#municregion-forestgrow_region option").css('display','none').prop( "disabled", true );  // скрывает все option для select
    isValidLR = /^([0-9]*)$/.test(regSubArr[subj]); // ищет чтобы было целое число
    if (isValidLR == false){ //если не целое чесло
        if (Array.isArray(regSubArr[subj])  == false) //если не массив
        {
            regSubArr[subj] = regSubArr[subj].split(','); //то делает масив
        }
        count = Object.keys(regSubArr[subj]).length; //считает количество объектов
        for(let f=0; f< count ; f++){
            $("#municregion-forestgrow_region option[value= "+ regSubArr[subj][f] + " ]").css('display','block').prop( "disabled", false );
            //выводит из масива значение val и показывает их на странице
        }
    }
    else {
        $("#municregion-forestgrow_region option[value= "+ regSubArr[subj] + "]").css('display','block').prop( "disabled", false );
        //выводит из масива значение val и показывает их на странице
    }
    $('#municregion-forestgrow_region').val( regSubArr[ $('#municregion-federal_subject').val()]);
    //чтобы было значение сразу выбрано
    
}


JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($js, yii\web\View::POS_END);
?>