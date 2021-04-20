<?php

use app\models\BranchPerson;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\Brigade */
/* @var $form yii\widgets\ActiveForm */

$docdir = 'docs/audit/brigade/'.$model->id.'/';
$id_audit= $model->id;
$docNameMask_fieldOrder = 'fieldOrder_*';
$docNameMask_businessTrip = 'businessTrip_*';
if (Yii::$app->request->get('id')){
    $idPost = Yii::$app->request->get('id');
    $forestry = $model->forestgrow_region;
}
else {
    $idPost = 0;
    $forestry = 0;
}


?>
<style>
    .brigade-form .field-brigade-branch{
        width: 50%;
        padding-right: 3%;
        float: left;
    }
    .brigade-form .field-brigade-subject,
    .brigade-form #brigade-person{
        width: 50%;
        float: left;
    }
    .brigade-form .field-brigade-contract{
        width: 40%;
        padding-right: 3%;
        float: left;
    }
    .brigade-form .field-brigade-date_begin{
        width: 30%;
        padding-right: 3%;
        float: left;
    }
    .brigade-form .field-brigade-brigade_number{
        width: 30%;
        float: left;
    }
    .brigade-form .field-brigade-remark,
    .brigade-form .field-brigade-object_work{
        width: 100%;
        float: left;
    }
    #fieldOrder,
    #businessTrip{
        margin-top: 5px;
    }
    pre{
        display: none;
    }
</style>


<div class="brigade-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'branch')->dropDownList(ArrayHelper::map(\app\models\Branch::find()->orderBy(['name' => SORT_ASC])->all(), 'branch_id', 'name')) ?>

    <?= $form->field($model, 'subject')->dropDownList(ArrayHelper::map(\app\models\FederalSubject::find()->orderBy(['name' => SORT_ASC])->all(), 'federal_subject_id', 'name')) ?>
    <?= $form->field($model, 'forestgrow_region')->dropDownList(ArrayHelper::map(\app\modules\audit\models\ForestgrowRegion::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'object_work')->textInput() ?>

    <?= $form->field($model, 'contract')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_begin')->widget(DatePicker::classname(),
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
        ])->label('выезд на полевые работы'); ?>
    <?= $form->field($model, 'brigade_number')->textInput() ?>

    <label class="control-label" style="width: 50%;float: left">Поиск специалистов </label>
    <label class="control-label" style="width: 50%;float: left; padding-left: 3%;">Специалист/специалисты бригады </label>
<!--    <select id="trainingprocessBranch" class="form-control" style="width: 50%;float: left">
        <?php
//        echo '<option value="" disabled> -- Выберите категорию -- </option>';
//        echo '<option value="1" selected style="background: #f1f5f9">Рослесинфорг</option>';
//        echo '<option value="2" style="background: #f1f5f9">Не рослесинфорг</option>';
//        foreach ($branchList as $branchListOne){
//            echo '<option value="' . $branchListOne['branch_id'] . '">' . $branchListOne['name'] . '</option>';
//        }
        ?>
    </select>-->

    <?= $form->field($model, 'person')->hiddenInput()->label(false) ?>
    <select id="trainingprocessViewPeople" class="form-control" multiple="multiple" style="height: 250px;width: 47%;float: right;margin-left: 3%;">
        <?php
        echo '<option value="NO" selected disabled>-- Не выбрано --</option>';
        ?>
    </select>

    <select id="trainingprocessPeople" class="form-control"  multiple="multiple"  style="height: 250px;width: 50%;float: left">

    </select>
    <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>



    <?php
    // Если редактируем закупку, даем возможность загрузить файл
    // Если создаем новую закупку, возможности загрузки файла не даем, т.к. не знаем еще для какой закупки будет этот файл
    if(isset($model2)) { $form2 = ActiveForm::begin(['options' => ['id' => 'requestFileForm', 'enctype' => 'multipart/form-data']]);  ?>
    <hr class="blueline">
    <div class="training-process-form">
    <h4> Загрузка файлов в формате .pdf  </h4><br>
    <div class="row">
        <div class="col-md-4"> <h5 class="h5">Приказ о формировании полевой группы </h5> </div>
        <div class="col-md-8"> <?= $form2->field($model2, 'fieldOrder')->fileInput(['id' => 'fieldOrder'])->label(false) ;?></div>
        <div class="col-md-4"> <h5 class="h5">Направление специалиста в командировку</h5> </div>
        <div class="col-md-4"> <?= $form2->field($model2, 'namePeople')->dropDownList([''=>'-- Выберите участника --'],['id' => 'namePeople'])
//                ->label('Введите фамилию участника')
                ->label(false)
            ;?></div>

        <div class="col-md-4"> <?= $form2->field($model2, 'businessTrip')->fileInput(['id' => 'businessTrip'])->label(false) ;?></div>

        <div class="col-md-12"> <?= Html::submitButton('Загрузить файлы', ['class' => 'btn btn-primary btn-upl-file']); ?></div>
    </div>
    <hr class="blueline">
        <div class="row">
            <div class="col-md-4"> <div class="fieldOrder"><div class="file_list"></div></div> </div>
            <div class="col-md-4"><div class="businessTrip"><div class="file_list"></div></div></div>
        </div>

    </div>

    <script type="text/javascript">
        // Переменные для функции опроса директории с файлами
        var docDir = '<?= $docdir ?>';
        var auditNum = '<?= $id_audit ?>';

        var docNameMask_fieldOrder = '<?= $docNameMask_fieldOrder?>';
        var NameMaskRus_fieldOrder = 'Приказ о формировании группы ';
        var listDiv_fieldOrder = '.fieldOrder .file_list';

        var docNameMask_businessTrip = '<?= $docNameMask_businessTrip ?>';
        var NameMaskRus_businessTrip = '';
        var listDiv_businessTrip = '.businessTrip .file_list';

    </script>
</div>
    <?php
    echo $form2->field($model2, 'check_num')->hiddenInput(['value' => $id_audit,'readonly' => true])->label(false);
    ActiveForm::end();
}
?>

</div>
<script>
    var regSubArr = <?= json_encode($RegSubArr) ?>;
    var idPost = <?= $idPost ?>;
    var forestry = <?= $forestry ?>;
</script>
<?php
$js = <<< JS
 var forestr = forestry; 
    changeValLR(forestr);
    changeSpecialist();
    updateSpecialist();
function START(){
    fileListRequest(docDir, docNameMask_fieldOrder,NameMaskRus_fieldOrder, auditNum, listDiv_fieldOrder);
    fileListRequest(docDir, docNameMask_businessTrip,NameMaskRus_businessTrip, auditNum, listDiv_businessTrip);
}


$('#trainingprocessBranch').on('change',function (){
    changeSpecialist();
});
$('#brigade-forestgrow_region').on('change',function (){
    changeSpecialist();
});
$('#brigade-subject').on('change',function (){
  changeValLR();
  changeSpecialist();
});

$(".file_list").click(function (){
      var  eventar = event.target ;
       if (event.target.nodeName == 'SPAN'){
          var Ydelete = confirm('Уверены что хотите удалить файл?');
           if(Ydelete == true){
               eventar = eventar.getAttribute('title')
               deleteFile(eventar);
               fileListRequest(docDir, docNameMask_fieldOrder,NameMaskRus_fieldOrder, auditNum, listDiv_fieldOrder);
               fileListRequest(docDir, docNameMask_businessTrip,NameMaskRus_businessTrip, auditNum, listDiv_businessTrip);
           }
           else console.log(eventar.getAttribute('title'));
       }
 }); 






$("#trainingprocessPeople").dblclick(function(){
    var  eventar = event.target ;
    if (event.target.nodeName == 'OPTION'){
         $('#trainingprocessViewPeople').append(eventar).prop('selected', false); 
         $('#trainingprocessViewPeople option').prop('selected', true);
         var numPeople = $('#trainingprocessViewPeople').val().join();
         $('#brigade-person').val(numPeople)
         $('#trainingprocessViewPeople option').prop('selected', false);
         namePeople()
    }
});

$("#trainingprocessViewPeople").dblclick(function(){
    var  eventar = event.target ;
    if (event.target.nodeName == 'OPTION'){
          $('#trainingprocessPeople option[value=NO]').remove();
         $('#trainingprocessPeople').append(eventar).prop('selected', false); //в список филиалов добавляется ещё один пунтк - "Не Рослесинфорг"
         $('#trainingprocessViewPeople option').prop('selected', true);
         var numPeople = $('#trainingprocessViewPeople').val().join();
         $('#brigade-person').val(numPeople);
         $('#trainingprocessViewPeople option').prop('selected', false);
         $('#trainingprocessPeople option').prop('selected', false);
         namePeople()
    }
});


function changeSpecialist() {
    var csrfToken = $('meta[name="csrf-token"]').attr("content"); //создаем CSRF токен
    $.ajax({
        url: '/audit/brigade/view-specialist',
        type: 'POST',
        data: {'forestryId' : $('#brigade-forestgrow_region').val() ,'typeWork' : $('#trainingprocessBranch').val() , 'arrayPeople' : $('#brigade-person').val(),  _csrf :  csrfToken  },
        success: function(data){ // удачное завершение запроса к серверу, в переменной data ответ сервера
         $('#trainingprocessPeople').html(data);
        },
        error: function(){
          console.log('функция сломалась');
        }
      });
}
function updateSpecialist() {
    var csrfToken = $('meta[name="csrf-token"]').attr("content"); //создаем CSRF токен
    $.ajax({
        url: '/audit/brigade/update-specialist',
        type: 'POST',
        data: {'arrayPeople' : $('#brigade-person').val(),'idPost': idPost ,  _csrf :  csrfToken  },
        success: function(data){ // удачное завершение запроса к серверу, в переменной data ответ сервера
        $('#trainingprocessViewPeople').html(data);
        namePeople()
        },
        error: function(){
          console.log('функция сломалась');
        }
      });
}
function changeValLR(forestr) {
    var subj = $('#brigade-subject').val();
    $("#brigade-forestgrow_region option").css('display','none').prop( "disabled", true );
    isValidLR = /^([0-9]*)$/.test(regSubArr[subj]);
    if (isValidLR == false){
        if (Array.isArray(regSubArr[subj])  == false)
        {
            regSubArr[subj] = regSubArr[subj].split(',');
        }
        count = Object.keys(regSubArr[subj]).length;
        for(let f=0; f< count ; f++){
            $("#brigade-forestgrow_region option[value= "+ regSubArr[subj][f] + " ]").css('display','block').prop( "disabled", false );
        }
    }
    else {
        $("#brigade-forestgrow_region option[value= "+ regSubArr[subj] + "]").css('display','block').prop( "disabled", false );
    }
    $('#brigade-forestgrow_region').val( regSubArr[ $('#brigade-subject').val()]);
    if(forestr){
        $("#brigade-forestgrow_region option[value= "+ forestr + " ]").prop( "selected", true );
    }
}



function namePeople(){
    $('#namePeople').find('option').remove();
     var array = Array.apply(null, $('#trainingprocessViewPeople option'))
     for (let pp = 0 ; pp< array.length ; pp++){
         var nameP = (array[pp].text.split(' '))[0]
         var optionname = '<option value='+ transliterateRuEn(nameP)  +'>'+ array[pp].text +'</option>';
         $('#namePeople').append(optionname).prop('selected', false);
     }
}




$('#requestFileForm').on('beforeSubmit', function(e){
  var formData = new FormData($(this).get(0));
  $.ajax({
    url: '/audit/brigade/upload',
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
            
            console.log(data);
            console.log(answer);
            $('#fieldOrder').val('');
            $('#businessTrip').val('');
            // обновляем списки загруженных файлов в заявках и ПД после загрузки нового
            fileListRequest(docDir, docNameMask_fieldOrder,NameMaskRus_fieldOrder, auditNum, listDiv_fieldOrder);
            fileListRequest(docDir, docNameMask_businessTrip,NameMaskRus_businessTrip, auditNum, listDiv_businessTrip);
           
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

function fileListRequest(docDir, docNameMask, NameMaskRus, auditNum, listDiv ) {
   var csrfToken = $('meta[name="csrf-token"]').attr("content");
    // Запрашиваем список файлов в папке по соответствующему контракту/закупке
    $.ajax({
        type: 'POST',
        url: '/audit/brigade/file-list-request',
        data: {'docDir' : docDir, 'docNameMask' : docNameMask, 'NameMaskRus' : NameMaskRus,  'auditNum' : auditNum ,_csrf :  csrfToken},
        success: function(data){
            if(data || data==''){
                $(listDiv).html(data);
               renderName($('.businessTrip .file_list .name'), 'Направление специалиста');
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