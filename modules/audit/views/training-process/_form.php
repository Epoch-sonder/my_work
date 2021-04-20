<?php

use app\models\ForestryMunic;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\TrainingProcess */
/* @var $form yii\widgets\ActiveForm */

$branch_id = Yii::$app->user->identity->branch_id;
$docdir = 'docs/audit/training/'.$model->id.'/';
$id_audit= $model->id;
$docNameMask_stripCard = 'stripCard_*';
$docNameMask_pppCard = 'pppCard_*';
$docNameMask_pppMap = 'pppMap_*';
$docNameMask_invite = 'Invite_*';
$docNameMask_act = 'Act_*';
$docNameMask_taxCard = 'TaxCard_*';
$docNameMask_statement = 'Statement_*';
$docNameMask_orderBranch = 'OrderBranch_*';
$docNameMask_orderOiv = 'OrderOiv_*';

?>
<style>
    .field-trainingprocess-person{
        padding-left: 3%;
        width: 50%;
        float: right;
        margin-top: -25px;
    }
    pre{
        display: none;
    }
    .pdfloaded{
        width: 47%;
        float: left;
        padding-top: 10px;
        margin-left: 3%;
    }
    .pdfloaded1{
        width: 50%;
        float: left;
        padding-top: 10px;
    }
    .field-namePeople{
        margin-top: 15px;
        width: 50%;
    }
    .h5{
        margin: 14px 0px 0px 0px;
        width: 277px;
    }
    .field-orderBranch , .field-orderOiv{
        margin-top: 25px!important ;
    }
    .field-trainingprocess-training_contract_num .control-label {
        max-width: 38%;
    }
    .field-trainingprocess-training_strip_amount .control-label {
        max-width: 97%;
    }
</style>

<p>
    <?= Html::a('<- вернуться к тренировочному процессу', ['../audit/training-process/' ], ['class' => 'btn btn-primary']); ?>
</p>

<div class="training-process-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php if ( \Yii::$app->user->can('tr_process_edit') and \Yii::$app->user->can('tr_process_view') or \Yii::$app->user->can('admin'))
     echo $form->field($model, 'verified')->checkbox([ 'value' => '1'])->label('');

    ?>


    <?= $form->field($model, 'branch')->dropDownList(ArrayHelper::map($branchList, 'branch_id', 'name'))->label("Филиал") ?>

    <?= $form->field($model, 'subject')->dropDownList(ArrayHelper::map(app\modules\audit\models\FederalSubject::find()->orderBy(['name' => SORT_ASC])->all(), 'federal_subject_id', 'name'))->label("Субъект РФ") ?>

    <?= $form->field($model, 'forestgrow_region')->dropDownList(ArrayHelper::map(app\modules\audit\models\ForestgrowRegion::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'))->label("Лесорастительный район") ?>

    <hr class="greenline">
    <?= $form->field($model, 'munic_region')->dropDownList([0=>'--- Не выбрано ---']) ?>

    <?= $form->field($model, 'forestry')->dropDownList([0=>'--- Не выбрано ---']) ?>

    <?= $form->field($model, 'subforestry')->dropDownList([0=>'--- Не выбрано ---']) ?>

    <hr class="greenline">

    <?= $form->field($model, 'training_forestry')->dropDownList([0=>'Не выбрано'])->label('Лесничество тренировки') ?>

    <?= $form->field($model, 'training_subforestry')->dropDownList([0=>'Не выбрано'])->label('Участковое лесничество тренировки') ?>

    <?= $form->field($model, 'training_quarter_strip')->textInput(['placeholder' => "Например: Кв.1 , Выд.1 ;"]) ?>
    <div class="file-training_site_amount">
    <?= $form->field($model, 'training_site_amount')->textInput()->label('Количество пробных площадей') ?>
    <div class="pppCard"><div class="file_list"></div></div>
    <div class="pppMap"><div class="file_list"></div></div>
    </div>

    <div class="file-training_strip_amount">
    <?= $form->field($model, 'training_strip_amount')->textInput()->label('Количество выделов уточненной таксации') ?>
    <div class="stripCard"><div class="file_list"></div></div>
    </div>

    <div class="file-training_contract_num">
    <?= $form->field($model, 'training_contract_num')->textInput(['maxlength' => true]) ?>
    <div class="invite"><div class="file_list"></div></div>
    </div>

    <div class="data-st-fi">
    <?= $form->field($model, 'training_date_start')->widget(DatePicker::classname(),
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

    <?= $form->field($model, 'training_date_finish')->widget(DatePicker::classname(),
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

    <div class="file-person">
    <div class="act ">  <div class="file_list "> </div></div>
    <div class="orderBranch"><div class="file_list"></div></div>
    <div class="orderOiv"><div class="file_list"></div></div>

        <label class="control-label" style="width: 53%;float: left">Поиск участников коллективной тренеровки</label>
        <select id="trainingprocessBranch" class="form-control" style="width: 50%;float: left">
            <?php
            echo '<option value="" selected disabled>-- Выберите категорию --</option>';
            echo '<option value="999" style="background: #f1f5f9">Показать все</option>';
            echo '<option value="666" style="background: #f1f5f9">Не рослесинфорг</option>';
            foreach ($branchList as $branchListOne){
                echo '<option value="' . $branchListOne['branch_id'] . '">' . $branchListOne['name'] . '</option>';
            }
            ?>
        </select>

        <?= $form->field($model, 'person')->hiddenInput()->label('Участник/участники коллективной тренировки') ?>
        <select id="trainingprocessViewPeople" size ='11' class="form-control" multiple="multiple" style="width: 47%;float: right;margin-left: 3%;">
            <?php
            echo '<option value="NO" selected disabled>-- Не выбрано --</option>';
            ?>
        </select>



        <select id="trainingprocessPeople" class="form-control"  multiple="multiple" size="10" style="width: 50%;float: left">
            <option value="" selected disabled>-- Выберите Филиал --</option>
        </select>
        <div class="file-person">
            <div class="statement pdfloaded1"><div class="file_list"></div></div>
            <div class="taxCard  pdfloaded"><div class="file_list"></div></div>

        </div>
    </div>



    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



<?php
// Если редактируем закупку, даем возможность загрузить файл
// Если создаем новую закупку, возможности загрузки файла не даем, т.к. не знаем еще для какой закупки будет этот файл
if(isset($model2)) {
$form2 = ActiveForm::begin(['options' => ['id' => 'requestFileForm', 'enctype' => 'multipart/form-data']]);
?>
<hr class="blueline">
<div class="training-process-form">
    <h3>Файлы по проверке(выберите файлы по название) в формате .pdf </h3><br>
    <div class="bottom_file "> <h5 class="h5">Карточки выделов уточненной таксации </h5> <?= $form2->field($model2, 'stripCard')->fileInput(['id' => 'stripCard'])->label(false) ;?></div>
    <div class="bottom_file "> <h5 class="h5">Карточки постоянных пробных площадей</h5> <?= $form2->field($model2, 'pppCard')->fileInput(['id' => 'pppCard'])->label(false) ;?></div>
    <div class="bottom_file"> <h5 class="h5">Карта-схема расположения пробных площадей</h5><?=  $form2->field($model2, 'pppMap')->fileInput(['id' => 'pppMap'])->label(false) ;?></div>
    <div class="bottom_file"><h5 class="h5">Приглашение на коллективную тренировку</h5> <?= $form2->field($model2, 'invite')->fileInput(['id' => 'invite'])->label(false) ;?></div>
    <div class="bottom_file"> <h5 class="h5">Акт проведения коллективной тренировки</h5> <?= $form2->field($model2, 'act')->fileInput(['id' => 'act'])->label(false) ;?></div>
    <div class="bottom_file"><h5 class="h5">Приказ филиала о допуске к производственной таксации и проверки качества работ</h5> <?= $form2->field($model2, 'orderBranch')->fileInput(['id' => 'orderBranch'])->label(false) ;?></div>
    <div class="bottom_file"><h5 class="h5">Приказ органа исполнительной власти о допуске к производственной таксации и проверки качества работ</h5> <?= $form2->field($model2, 'orderOiv')->fileInput(['id' => 'orderOiv'])->label(false) ;?></div>
    <?= Html::submitButton('Загрузить файлы', ['class' => 'btn btn-primary btn-upl-file']); ?>
    <hr class="blueline">
    <?= $form2->field($model2, 'namePeople')->dropDownList([''=>'-- Выберите участника --'],['id' => 'namePeople'])->label('Введите фамилию участника') ;?>
    <div class="bottom_file"><h5 class="h5">Карточка таксации</h5> <?= $form2->field($model2, 'taxCard')->fileInput(['id' => 'taxCard'])->label(false) ;?></div>
    <div class="bottom_file"><h5 class="h5">Сличительная ведомость</h5> <?= $form2->field($model2, 'statement')->fileInput(['id' => 'statement'])->label(false) ;?></div>
    <?= Html::submitButton('Загрузить файлы', ['class' => 'btn btn-primary btn-upl-file checkPeople']); ?>
</div>

    <script type="text/javascript">
        // Переменные для функции опроса директории с файлами
        var docDir = '<?= $docdir ?>';
        var auditNum = '<?= $id_audit ?>';

        var docNameMask_stripCard = '<?= $docNameMask_stripCard?>';
        var NameMaskRus_stripCard = 'Карточка выделов уточненной таксации';
        var listDiv_stripCard = '.stripCard .file_list';

        var docNameMask_pppCard = '<?= $docNameMask_pppCard?>';
        var NameMaskRus_pppCard = 'Карточка ППП';
        var listDiv_pppCard = '.pppCard .file_list';

        var docNameMask_pppMap = '<?= $docNameMask_pppMap ?>';
        var NameMaskRus_pppMap = 'Карта-схема ППП';
        var listDiv_pppMap = '.pppMap .file_list';

        var docNameMask_invite = '<?= $docNameMask_invite ?>';
        var NameMaskRus_invite = 'Приглашение на тренировку';
        var listDiv_invite = '.invite .file_list';

        var docNameMask_act = '<?= $docNameMask_act ?>';
        var NameMaskRus_act = 'Карточка таксации';
        var listDiv_act = '.act .file_list';

        var docNameMask_taxCard = '<?= $docNameMask_taxCard ?>';
        var NameMaskRus_taxCard = '';
        var listDiv_taxCard  = '.taxCard .file_list';

        var docNameMask_statement = '<?= $docNameMask_statement ?>';
        var NameMaskRus_statement = '';
        var listDiv_statement = '.statement .file_list';

        var docNameMask_orderBranch = '<?= $docNameMask_orderBranch ?>';
        var NameMaskRus_orderBranch  = 'Приказ Филиалу';
        var listDiv_orderBranch  = '.orderBranch .file_list';

        var docNameMask_orderOiv = '<?= $docNameMask_orderOiv?>';
        var NameMaskRus_orderOiv = 'Приказ ОИВ';
        var listDiv_orderOiv = '.orderOiv .file_list';

    </script>
</div>
    <?php
    echo $form2->field($model2, 'check_num')->hiddenInput(['value' => $id_audit,'readonly' => true])->label(false);
    ActiveForm::end();
    }
    ?>








<?php // передаем в переменные JS значения массива PHP ?>
<script type='text/javascript'>
    var areaArr = <?= json_encode($AreaArr) ?> ;
    var regSubArr = <?= json_encode($RegSubArr) ?>;
    var branchid = <?= $branch_id ?>;
</script>
<?php
$js = <<< JS
// var fpress =  $('#trainingprocess-branch').val();
var fpress2 =  $('#trainingprocess-subject').val();
var fpress3 =  $('#trainingprocess-forestgrow_region').val();
var forestry;
var subforestry;
var subj;



//удаление файла
 $(".file_list").click(function (){
      var  eventar = event.target ;
       if (event.target.nodeName == 'SPAN'){
          var Ydelete = confirm('Уверены что хотите удалить файл?');
           if(Ydelete == true){
               eventar = eventar.getAttribute('title')
               deleteFile(eventar);
               fileListRequest(docDir, docNameMask_stripCard,NameMaskRus_stripCard, auditNum, listDiv_stripCard);
               fileListRequest(docDir, docNameMask_pppCard,NameMaskRus_pppCard, auditNum, listDiv_pppCard);
               fileListRequest(docDir, docNameMask_pppMap,NameMaskRus_pppMap, auditNum, listDiv_pppMap);
               fileListRequest(docDir, docNameMask_invite,NameMaskRus_invite, auditNum, listDiv_invite);
               fileListRequest(docDir, docNameMask_act,NameMaskRus_act,auditNum, listDiv_act);
               fileListRequest(docDir, docNameMask_taxCard,NameMaskRus_taxCard, auditNum, listDiv_taxCard);
               fileListRequest(docDir, docNameMask_statement,NameMaskRus_statement, auditNum, listDiv_statement);
               fileListRequest(docDir, docNameMask_orderBranch,NameMaskRus_orderBranch, auditNum, listDiv_orderBranch);
               fileListRequest(docDir, docNameMask_orderOiv,NameMaskRus_orderOiv,auditNum, listDiv_orderOiv);
           }
       }
 });     
    //Добавление специалиста
    $("#trainingprocessPeople").dblclick(function(){
     var  eventar = event.target ;
    if (event.target.nodeName == 'OPTION'){
     $('#trainingprocessViewPeople option[value=NO]').remove();
     $('#trainingprocessViewPeople').append(eventar).prop('selected', false); 
     $('#trainingprocessViewPeople option').prop('selected', true);
     var numPeople = $('#trainingprocessViewPeople').val().join();
     $('#trainingprocess-person').val(numPeople)
     $('#trainingprocessViewPeople option').prop('selected', false);
     namePeople()
    }
    
    });
  //Удаление специалиста
 $("#trainingprocessViewPeople").dblclick(function(){
     var  eventar = event.target ;
     if (event.target.nodeName == 'OPTION'){
          $('#trainingprocessPeople').append(eventar).prop('selected', false); //в список филиалов добавляется ещё один пунтк - "Не Рослесинфорг"
         $('#trainingprocessViewPeople option').prop('selected', true);
         var numPeople = $('#trainingprocessViewPeople').val().join();
         $('#trainingprocess-person').val(numPeople)
         changePeople();
         $('#trainingprocessViewPeople option').prop('selected', false);
         namePeople()
     }
    });
    // $('#trainingperson-workplace_rli option[value=666]').remove(); 

// при смене филиала у специалистов
$('#trainingprocessBranch').on('change', function() { 
    changePeople();
});



 // при смене филиала
$('#trainingprocess-branch').on('change', function() {
    subj = $('#trainingprocess-subject').val();
    changeValLR();
});

// при смене субъекта
$('#trainingprocess-subject').on('change', function() { // при смене субъекта
    forestryUpdate = null;
    subforestryUpdate = null;
    trainingsubforestryUpdate = null;
    trainingforestryUpdate = null;
    subj = $('#trainingprocess-subject').val();
    municUpdate = null;
    changeValLR();
    changeMunic();
});
// при смене лесорастительного района
$('#trainingprocess-forestgrow_region').on('change', function() { // при смене Лесорастительного района
    municUpdate = null;
    changeMunic();
});
// при смене муника района
$('#trainingprocess-munic_region').on('change', function() { // при смене Лесорастительного района
    subj = $('#trainingprocess-subject').val();
    changeForestry(subj);
});
// при смене лесничества
$('#trainingprocess-forestry').on('change', function() { // при смене Лесничества
    forestryUpdate = null;
    subforestryUpdate = null;
    trainingsubforestryUpdate = null;
    trainingforestryUpdate = null;
    forestry = $('#trainingprocess-forestry').val();
    subforestry = $('#trainingprocess-subforestry');
    changeSubforestry(forestry, subforestry);
    
});
//при смене тренировочного лесничества
$('#trainingprocess-training_forestry').on('change', function() {  // при смене Тренировочного лесничества
    forestryUpdate = null;
    subforestryUpdate = null;
    trainingsubforestryUpdate = null;
    trainingforestryUpdate = null;
    forestry = $('#trainingprocess-training_forestry').val();
    subforestry = $('#trainingprocess-training_subforestry');
    changeSubforestry(forestry , subforestry );
});

//обновлние людей при update
function viewPeople() {
    var csrfToken = $('meta[name="csrf-token"]').attr("content"); //создаем CSRF токен
    $.ajax({
        url: '/audit/training-process/view-people',
        type: 'POST',
        data: {'branchId' : 999 , 'arrayPeople' : $('#trainingprocess-person').val(),  _csrf :  csrfToken  },
        success: function(data){ // удачное завершение запроса к серверу, в переменной data ответ сервера
             $('#trainingprocessViewPeople').html(data);
              namePeople()
        },
        error: function(){
          console.log('функция сломалась');
        }
      });
}
//загрузка списка людей
function changePeople() {
    var csrfToken = $('meta[name="csrf-token"]').attr("content"); //создаем CSRF токен
    $.ajax({
        url: '/audit/training-process/change-people',
        type: 'POST',
        data: {'branchId' : $('#trainingprocessBranch').val(), 'arrayPeople' : $('#trainingprocess-person').val(),  _csrf :  csrfToken  },
        success: function(data){ // удачное завершение запроса к серверу, в переменной data ответ сервера
            $('#trainingprocessPeople').html(data);
        },
        error: function(){
          console.log('функция сломалась');
        }
      });
}
//англ название фио
function namePeople(){
    $('#namePeople').find('option').remove();
     var array = Array.apply(null, $('#trainingprocessViewPeople option'))
     for (let pp = 0 ; pp< array.length ; pp++){
         var nameP = (array[pp].text.split(' '))[0]
         
         var optionname = '<option value='+ transliterateRuEn(nameP)  +'>'+ array[pp].text +'</option>';
          $('#namePeople').append(optionname).prop('selected', false);
     }
}

//смена субьекта
function changeValSub() {
    $("#trainingprocess-subject option").css('display','none').prop( "disabled", true );
    isValidSub = /^([0-9]*)$/.test(areaArr[i]); //проверка есть ли в массиве запятые, т.е. состоит он из одного элемента или нескольких
    if (isValidSub == false){ //если запятые есть, то
        //проверяет массив ли это
        if (Array.isArray(areaArr[i])  == false)
        {
            areaArr[i] = areaArr[i].split(',');
        }//и в таком случае разбиваем значения, разделенные запятыми
        count = Object.keys(areaArr[i]).length; //считаем длину массива
        for(let f=0; f< count ; f++){
            $("#trainingprocess-subject option[value= "+ areaArr[i][f] + " ]").css('display','block').prop( "disabled", false );
        } // иземняет свойства блоков

    }
    else {
        $("#trainingprocess-subject option[value= "+ areaArr[i] + "]").css('display','block').prop( "disabled", false );
    } // иземняет свойства блоков

    $('#trainingprocess-subject').val( areaArr[ $('#trainingprocess-branch').val()]);
}

//Аналогично
function changeValLR() {
    //лесорастительный регион, скрывать блоки
    //regSubArr, массив субъект->район лесорастительный
    $("#trainingprocess-forestgrow_region option").css('display','none').prop( "disabled", true );
    isValidLR = /^([0-9]*)$/.test(regSubArr[subj]);
    if (isValidLR == false){
        if (Array.isArray(regSubArr[subj])  == false)
            regSubArr[subj] = regSubArr[subj].split(',');
        count = Object.keys(regSubArr[subj]).length;
        for(let f=0; f< count ; f++){
            $("#trainingprocess-forestgrow_region option[value= "+ regSubArr[subj][f] + " ]").css('display','block').prop( "disabled", false );
        }
    }
    else {
        $("#trainingprocess-forestgrow_region option[value= "+ regSubArr[subj] + "]").css('display','block').prop( "disabled", false );
    }
    $('#trainingprocess-forestgrow_region').val( regSubArr[ $('#trainingprocess-subject').val()]);
}

//обновление лесничества
function changeForestry(subj,forestryUpdate, trainingforestryUpdate){
    var csrfToken = $('meta[name="csrf-token"]').attr("content"); //создаем CSRF токен
    $.ajax({
        url: '/audit/training-process/change-forestry',
        type: 'POST',
        data: {'subjectId' : subj ,'municId' : $('#trainingprocess-munic_region').val() ,  _csrf :  csrfToken },
        success: function(data){ // удачное завершение запроса к серверу, в переменной data ответ сервера
            $('#trainingprocess-forestry').html(data); //меняем HTML блока Лесничество
            $('#trainingprocess-training_forestry'). html(data); //меняем HTML блока Тренировочное лесничество
            $('#trainingprocess-subforestry').html('<option  value="0" selected >  --- Не выбрано --- </option>');  //обнуляем блок Участковое лесничество
            $('#trainingprocess-training_subforestry').html('<option  value="0" selected >  --- Не выбрано --- </option>');  //обнуляем блок Тренировочное участковое лесничество
             if (forestryUpdate != null){
               $('#trainingprocess-forestry').val(forestryUpdate).prop('selected', true);
                subforestry = $('#trainingprocess-subforestry');
                changeSubforestry(forestry ,subforestry)
            }
            if (trainingforestryUpdate != null){
               $('#trainingprocess-training_forestry').val(trainingforestryUpdate).prop('selected', true);
                trsubforestry = $('#trainingprocess-training_subforestry');
                changeSubforestry(trforestry , trsubforestry );
            }
            
            
        },
        error: function(){
          console.log('функция сломалась');
        }
      });
}
//обновление участкого лесничества
function changeSubforestry(forestry ,subforestry){
    var csrfToken = $('meta[name="csrf-token"]').attr("content"); //создаем CSRF токен
    $.ajax({
        url: '/audit/training-process/change-subforestry',
        type: 'POST',
        data: {'subjectId' : $('#trainingprocess-subject').val() , 'forestryKod' :  forestry ,  _csrf :  csrfToken },
        success: function(data){ // удачное завершение запроса к серверу, в переменной data ответ сервера
            subforestry.html(data); //менять HTML текст блока Участковое лесничество или Тренировочное участковое лесничество
            if(forestryUpdate != null && subforestryUpdate != null && trainingsubforestryUpdate != null  && trainingforestryUpdate != null){ // если есть переменные != null, то меняем значение value
                $('#trainingprocess-forestry option[value='+ forestryUpdate +']').prop('selected', true);
                $('#trainingprocess-subforestry option[value='+ subforestryUpdate +']').prop('selected', true);
                $('#trainingprocess-training_subforestry option[value='+ trainingsubforestryUpdate +']').prop('selected', true);
                $('#trainingprocess-training_forestry option[value='+ trainingforestryUpdate +']').prop('selected', true);
            }
            
        },
        error: function(){
          console.log('функция сломалась');
        }
      });
}
// Аналогоично changeSubforestry();
//обновление муниципального
function changeMunic(municUpdate){
    var csrfToken = $('meta[name="csrf-token"]').attr("content"); //создаем CSRF токен
    $.ajax({
        url: '/audit/training-process/change-munic',
        type: 'POST',
        data: {'subjectId' : $('#trainingprocess-subject').val() , 'forestgrowId' : $('#trainingprocess-forestgrow_region').val()   ,  _csrf :  csrfToken },
        success: function(data){ // удачное завершение запроса к серверу, в переменной data ответ сервера
            $('#trainingprocess-munic_region').html(data);
            //при update
            if(municUpdate != null) {
                $('#trainingprocess-munic_region option[value='+ municUpdate +']').prop('selected', true);
                changeForestry(subj,forestryUpdate ,trainingforestryUpdate);
            }
            else changeForestry(subj);
        },
        error: function(){
          console.log('функция сломалась');
        }
      });
    
}




 //********************************************************
 // Загрузка файла с отправленным запросом КП по ДЗЗ
 //********************************************************


    $('#requestFileForm').on('beforeSubmit', function(e){
        
      var formData = new FormData($(this).get(0));
      // var namePeople = ;
      
      
      $.ajax({
        url: '/audit/training-process/upload',
        type: 'POST',
        // data: {'formData' : formData , 'People' : namePeople },
        data: formData,
        cache: false,
        dataType: 'json',
        processData: false, // Не обрабатываем файлы (Don't process the files)
        contentType: false, // Так jQuery скажет серверу что это строковой запрос
        success: function(data){ // удачное завершение запроса к серверу, в переменной data ответ сервера
            if(data){
                // tmpfile = data;
                // var status = '<span style="font-size: smaller; font-style: italic; color: green;">Файл ' + data + ' успешно загружен!</span>';
                // $('.help-block').html(status); 
                // console.log(data);
                var answer;
                if(data == 'nofiles') answer = 'Файлы не выбраны';
                else answer = 'файлы ' + data + ' загружены';
                console.log(answer);
                $('#stripCard').val('');
                $('#pppCard').val('');
                $('#pppMap').val('');
                $('#invite').val('');
                $('#act').val('');
                $('#taxCard').val('');
                $('#statement').val('');
                $('#orderBranch').val('');
                $('#orderOiv').val('');
                $('#namePeople').val('');
                // обновляем списки загруженных файлов в заявках и ПД после загрузки нового
                fileListRequest(docDir, docNameMask_stripCard,NameMaskRus_stripCard, auditNum, listDiv_stripCard);
                fileListRequest(docDir, docNameMask_pppCard,NameMaskRus_pppCard, auditNum, listDiv_pppCard);
                fileListRequest(docDir, docNameMask_pppMap,NameMaskRus_pppMap, auditNum, listDiv_pppMap);
                fileListRequest(docDir, docNameMask_invite,NameMaskRus_invite, auditNum, listDiv_invite);
                fileListRequest(docDir, docNameMask_act,NameMaskRus_act,auditNum, listDiv_act);
                fileListRequest(docDir, docNameMask_taxCard,NameMaskRus_taxCard, auditNum, listDiv_taxCard);
                fileListRequest(docDir, docNameMask_statement,NameMaskRus_statement, auditNum, listDiv_statement);
                fileListRequest(docDir, docNameMask_orderBranch,NameMaskRus_orderBranch, auditNum, listDiv_orderBranch);
                fileListRequest(docDir, docNameMask_orderOiv,NameMaskRus_orderOiv,auditNum, listDiv_orderOiv);
               
            }
        },
        error: function(){
          var status = '<span style="color: red;">Ошибка при загрузке файла</span>';
          $('.help-block').html(status); 
          console.log('Ошибка при загрузке файла');
        }
      });
      return false;
    });


 //********************************************************
// Обновление списка файлов после загрузки файла
//********************************************************

    function fileListRequest(docDir, docNameMask, NameMaskRus, auditNum, listDiv ) {
       var csrfToken = $('meta[name="csrf-token"]').attr("content");
        // Запрашиваем список файлов в папке по соответствующему контракту/закупке
        $.ajax({
            type: 'POST',
            url: '/audit/training-process/file-list-request',
            data: {'docDir' : docDir, 'docNameMask' : docNameMask, 'NameMaskRus' : NameMaskRus,  'auditNum' : auditNum ,_csrf :  csrfToken},
            success: function(data){
                if(data || data==''){
                    $(listDiv).html(data);
                   renderName($('.statement .file_list .name'), 'Сличительная ведомость');
                   renderName($('.taxCard .file_list .name') , 'Карточка таксации');
                }
            }
        });
        
    }
 function deleteFile(filehref){
    var csrfToken = $('meta[name="csrf-token"]').attr("content"); //создаем CSRF токен
    $.ajax({
        url: '/audit/training-process/file-delete',
        type: 'POST',
        data: {'namefile' :  filehref  ,  _csrf :  csrfToken },
        success: function(data){ // удачное завершение запроса к серверу, в переменной data ответ сервера
             console.log(data);
        },
        error: function(){
          console.log('функция сломалась');
        }
      });
    
}   
    
    
 function renderName(name, nameST ){
        for (let num = 0; num < name.length ; num++ ){
          var namePDF = name[num].text;
          namePDF.split(' ')[2];
          if (/[а-я]/i.test(namePDF) == true){
               var namepeople = namePDF.split(' ')[2];
          }
          else {
              var namepeople = namePDF.split('_')[1]; 
              namepeople = transliterateEnRu(namepeople);
          }
          if (/\d+/.test(namepeople) == true){
             namepeople = '';
          }
          //
          name[num].innerHTML= nameST + ' ' + namepeople ;
        }
    } 
            



JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($js, yii\web\View::POS_END);
?>
