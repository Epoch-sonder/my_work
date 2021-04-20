<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\OoptBinding */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oopt-binding-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'oopt')->dropDownList(ArrayHelper::map(\app\models\Oopt::find()->orderBy(['oopt_name' => SORT_ASC])->all(), 'id', 'oopt_name')) ?>

    <?= $form->field($model, 'subject')->dropDownList(ArrayHelper::map(app\modules\audit\models\FederalSubject::find()->orderBy(['name' => SORT_ASC])->all(), 'federal_subject_id', 'name'))->label("Субъект РФ") ?>

    <?= $form->field($model, 'munic')->dropDownList([0=>'--- Не выбрано ---']) ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$js = <<< JS

$('#ooptbinding-subject').on('change', function() { // при смене субъекта
    changeMunic()
});
function changeMunic(municUpdate){
    var csrfToken = $('meta[name="csrf-token"]').attr("content"); //создаем CSRF токен
    $.ajax({
        url: '/oopt-binding/change-munic',
        type: 'POST',
        data: {'subjectId' : $('#ooptbinding-subject').val()  ,  _csrf :  csrfToken },
        success: function(data){ // удачное завершение запроса к серверу, в переменной data ответ сервера
            $('#ooptbinding-munic').html(data);
            
            if(municUpdate != null) {
                $('#ooptbinding-munic option[value='+ municUpdate +']').prop('selected', true);
            }
        },
        error: function(){
          console.log('функция сломалась');
        }
      });
    
}

JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($js, yii\web\View::POS_END); ?>