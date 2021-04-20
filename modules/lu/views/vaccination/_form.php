<?php


use app\modules\audit\models\Branch;
use app\modules\lu\models\Vaccination;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\Vaccination */
/* @var $form yii\widgets\ActiveForm */

$branchList = Branch::find()->orderBy(['name' => SORT_ASC])->all();

?>

<div class="vaccination-form">

    <?php $form = ActiveForm::begin(); ?>
   <br>
    <div class="form-group field-vaccination-vaccin required has-error">
    <div class="row">
        <div class="col-sm-2 ">
            <label><input type="radio" name="Vaccination[vaccin]" class="cheakRadio" value="1" checked> Первая вакцина весна(март, апрель)</label>
        </div>
        <div class="col-sm-2 ">
            <label><input  type="radio" name="Vaccination[vaccin]" class="cheakRadio" value="2"> Вторая вакцина через месяц от первой</label>
        </div>
        <div class="col-sm-2 ">
            <label><input type="radio" name="Vaccination[vaccin]" class="cheakRadio" value="3"> Третья вакцина через 9-12 месяцев от второй</label>
        </div>
    </div>
    </div>
    <div class="row">
        <div class="col-sm-6" style="margin-top: 15px;margin-bottom: 5px">
        <?= $form->field($model, 'date_cheak')->widget(DatePicker::classname(),
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
                ])->label(false); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 ">  <?= $form->field($model, 'person_id')->hiddenInput()->label('Выберите специалистов') ?>
        </div>
    </div>


    <div class="row">
         <div class="col-sm-3 ">
            <select id="trainingprocessViewPeople" class="form-control" size="10"  multiple="multiple">
                <?php
                echo '<option value="NO" selected disabled>-- Не выбрано --</option>';
                ?>
            </select>
        </div>
        <div class="col-sm-3 ">
            <select id="trainingprocessPeople" class="form-control"  size="10"  multiple="multiple" > </select>
        </div>
    </div>


    <?= $form->field($model2, 'vaccin')->fileInput(['id' => 'vaccin'])->label('Прикрепите файлы о прохождении вакцинации(.pdf, .doc, .docx)') ;?>






    <?= $form->field($model, 'first_vaccination')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'second_vaccination')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'third_vaccination')->hiddenInput()->label(false) ?>


    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    var branchID = <?= Yii::$app->user->identity->branch_id ?>
</script>
<?php
$js = <<< JS
start()

function start() {
    renderPeople();
    viewPeople();
}


function renderPeople() {
    var csrfToken = $('meta[name="csrf-token"]').attr("content"); //создаем CSRF токен
    $.ajax({
        url: '/lu/vaccination/render-people',
        type: 'POST',
        data: {'branchId' : branchID, 'vaccin' : $('input[class=cheakRadio]:checked').val(), 'arrayPeople' : $('#vaccination-person_id').val(),  _csrf :  csrfToken  },
        success: function(data){ // удачное завершение запроса к серверу, в переменной data ответ сервера
            $('#trainingprocessViewPeople').html(data);
        },
        error: function(){
          console.log('функция сломалась');
        }
      });
}
function viewPeople() {
    var csrfToken = $('meta[name="csrf-token"]').attr("content"); //создаем CSRF токен
    $.ajax({
        url: '/lu/vaccination/view-people',
        type: 'POST',
        data: {'arrayPeople' : $('#vaccination-person_id').val(),  _csrf :  csrfToken  },
        success: function(data){ // удачное завершение запроса к серверу, в переменной data ответ сервера
            $('#trainingprocessPeople').html(data);
        },
        error: function(){
          console.log('функция сломалась');
        }
      });
}

$("#trainingprocessPeople").dblclick(function(){
    var  eventar = event.target ;
    if (event.target.nodeName == 'OPTION'){
        $('#trainingprocessViewPeople option[value=NO]').remove();
        $('#trainingprocessViewPeople').append(eventar).prop('selected', false); //в список филиалов добавляется ещё один пунтк - "Не Рослесинфорг"
        $('#trainingprocessPeople option').prop('selected', true);
        var numPeople = $('#trainingprocessPeople').val().join();
        $('#vaccination-person_id').val(numPeople)
        $('#trainingprocessViewPeople option').prop('selected', false);
        $('#trainingprocessPeople option').prop('selected', false);
    }

});
$("#trainingprocessViewPeople").dblclick(function(){
    var  eventar = event.target ;
    if (event.target.nodeName == 'OPTION'){
        $('#trainingprocessPeople').append(eventar).prop('selected', false); //в список филиалов добавляется ещё один пунтк - "Не Рослесинфорг"
        $('#trainingprocessPeople option').prop('selected', true);
        var numPeople = $('#trainingprocessPeople').val().join();
        $('#vaccination-person_id').val(numPeople)
        // renderPeople();
        $('#trainingprocessViewPeople option').prop('selected', false);
        $('#trainingprocessPeople option').prop('selected', false);
    }
});
$('input[class=cheakRadio]').on('click',function(){
    $('#vaccination-person_id').val('')
    $('#trainingprocessPeople').html('')
   
    renderPeople();
});



JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($js, yii\web\View::POS_END);
?>
