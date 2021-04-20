<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\Audit */
/* @var $form yii\widgets\ActiveForm */


$docdir = 'docs/audit/audit/'.$model->id.'/';
$id_audit=$model->id;
$docNameMask_orderAudit = 'OrderAudit_*';
$docNameMask_requestFalhCa = 'RequestFalhCa_*';
$docNameMask_answerBranchCa = 'AnswerBranchCa_*';
$docNameMask_requestCaBranch = 'RequestCaBranch_*';
$docNameMask_answerCaFalh = 'AnswerCaFalh_*';


?>


<table class="audit-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //= $form->field($model, 'date_start')->textInput() ?>
    <?php //= $form->field($model, 'date_finish')->textInput() ?>

    <?= $form->field($model, 'date_start')->widget(DatePicker::classname(),
    [
    'language' => 'ru-RU',
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        'orientation' => 'bottom left',
        ],
        ]);
    ?>

    <?= $form->field($model, 'date_finish')->widget(DatePicker::classname(),
    [
    'language' => 'ru-RU',
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        'orientation' => 'bottom left',
        ]
        ]);
    ?>
    <?= $form->field($model, 'duration')->textInput();?>
    <?php //= $form->field($model, 'fed_district')->textInput() ?>
    <?php //= $form->field($model, 'fed_subject')->textInput() ?>

    <div class="clr"></div>
    <?= $form->field($model, 'fed_district')->dropDownList(ArrayHelper::map(app\modules\audit\models\FederalDistrict::find()->orderBy(['name' => SORT_ASC])->all(), 'federal_district_id', 'name')) ?>

    <?= $form->field($model, 'fed_subject')->dropDownList(ArrayHelper::map(app\modules\audit\models\FederalSubject::find()/*->where($condBranch)*/->orderBy(['name' => SORT_ASC])->all(), 'federal_subject_id', 'name')) ?>

    
    <div class="clr"></div>
    <?= $form->field($model, 'oiv')->dropDownList(ArrayHelper::map(app\modules\audit\models\OivSubject::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name')) ?>


    <?= $form->field($model, 'organizer')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'audit_type')->textInput() ?>


    <?= $form->field($model, 'audit_type')->dropDownList(ArrayHelper::map(app\modules\audit\models\AuditType::find()->all(), 'id', 'type')) ?>

    <?= $form->field($model, 'audit_quantity')->hiddenInput(['value' => 1])->label(false) ?>
    <div class="clr"></div>
    <div class="clr"></div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    </table>



<hr class="blueline">

<?php
// Если редактируем закупку, даем возможность загрузить файл
// Если создаем новую закупку, возможности загрузки файла не даем, т.к. не знаем еще для какой закупки будет этот файл
if(isset($model2)) {
    $form2 = ActiveForm::begin(['options' => ['id' => 'requestFileForm', 'enctype' => 'multipart/form-data']]);
?>

<div>
   <h3>Файлы по проверки (.pdf, .doc, .docx)</h3><br>

    <div class="divflow">
        <div class="leftfloat requestFalhCa">
            <h4>Запрос ФАЛХ в ЦА</h4>
        <div class="file_list"></div>
        <div class="bottom_file"> <?= $form2->field($model2, 'requestFalhCa')->fileInput(['id' => 'requestFalhCa'])->label(false) ;?>
            <?= Html::submitButton('Загрузить файл', ['class' => 'btn btn-primary btn-upl-file']); ?></div>
    </div>
        <div class="rightfloat answerBranchCa">
            <h4>Ответы филиалов в ЦА</h4>
            <div class="file_list"></div>

            <div class="bottom_file"> <?=  $form2->field($model2, 'answerBranchCa')->fileInput(['id' => 'answerBranchCa'])->label(false) ;?>
                <?= Html::submitButton('Загрузить файл', ['class' => 'btn btn-primary btn-upl-file']); ?></div>
        </div>
    </div>

    <div class="divflow">
        <div class="leftfloat requestCaBranch">
            <h4>Запрос ЦА в филиалы</h4>
            <div class="file_list"></div>
            <div class="bottom_file"> <?= $form2->field($model2, 'requestCaBranch')->fileInput(['id' => 'requestCaBranch'])->label(false) ;?>
                <?= Html::submitButton('Загрузить файл', ['class' => 'btn btn-primary btn-upl-file']); ?></div>
        </div>
        <div class="rightfloat answerCaFalh">
        <h4>Ответы ЦА в ФАЛХ</h4>
        <div class="file_list"></div>
        <div class="bottom_file"> <?= $form2->field($model2, 'answerCaFalh')->fileInput(['id' => 'answerCaFalh'])->label(false) ;?>
            <?= Html::submitButton('Загрузить файл', ['class' => 'btn btn-primary btn-upl-file']); ?></div>
        </div>

    </div>

    <div class="divflow">
        <div class="leftfloat orderAudit">
       <h4>Приказ о проверке</h4>
        <div class="file_list"></div>
       <div class="bottom_file"> <?= $form2->field($model2, 'orderAudit')->fileInput(['id' => 'orderAudit'])->label(false) ;?>
           <?= Html::submitButton('Загрузить файл', ['class' => 'btn btn-primary btn-upl-file']); ?></div>
        </div>

    </div>

    <script type="text/javascript">
        // Переменные для функции опроса директории с файлами
        var docDir = '<?= $docdir ?>';
        var auditNum = '<?= $id_audit ?>';
        var docNameMask_requestFalhCa = '<?= $docNameMask_requestFalhCa ?>';
        var listDiv_requestFalhCa = '.requestFalhCa .file_list';
        var docNameMask_requestCaBranch = '<?= $docNameMask_requestCaBranch ?>';
        var listDiv_requestCaBranch = '.requestCaBranch .file_list';
        var docNameMask_answerBranchCa = '<?= $docNameMask_answerBranchCa ?>';
        var listDiv_answerBranchCa = '.answerBranchCa .file_list';
        var docNameMask_answerCaFalh = '<?= $docNameMask_answerCaFalh ?>';
        var listDiv_answerCaFalh  = '.answerCaFalh .file_list';
        var docNameMask_orderAudit = '<?= $docNameMask_orderAudit?>';
        var listDiv_orderAudit = '.orderAudit .file_list';
    </script>
<?php
echo $form2->field($model2, 'check_num')->hiddenInput(['value' => $id_audit,'readonly' => true])->label(false);

ActiveForm::end();
}
?>



</div>














<?php

$js = <<<JS
     //********************************************************
     // Загрузка файла с отправленным запросом КП по ДЗЗ
     //********************************************************

   

    $('#requestFileForm').on('beforeSubmit', function(e){
      var formData = new FormData($(this).get(0)); 
      $.ajax({
        url: '/audit/audit/upload',
        type: 'POST',
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
                $('#requestCaBranch').val('');
                $('#requestFalhCa').val('');
                $('#answerBranchCa').val('');
                $('#answerCaFalh').val('');
                $('#orderAudit').val('');
                // обновляем списки загруженных файлов в заявках и ПД после загрузки нового
                fileListRequest(docDir, docNameMask_requestFalhCa, auditNum, listDiv_requestFalhCa);
                fileListRequest(docDir, docNameMask_requestCaBranch, auditNum, listDiv_requestCaBranch);
                fileListRequest(docDir, docNameMask_answerBranchCa, auditNum, listDiv_answerBranchCa);
                fileListRequest(docDir, docNameMask_answerCaFalh, auditNum, listDiv_answerCaFalh);
                fileListRequest(docDir, docNameMask_orderAudit, auditNum, listDiv_orderAudit);
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

    function fileListRequest(docDir, docNameMask, auditNum, listDiv) {

        // Запрашиваем список файлов в папке по соответствующему контракту/закупке
        $.ajax({
            url: '/audit/audit/file-list-request',
            type: 'POST',
            data: {'docDir' : docDir, 'docNameMask' : docNameMask, 'auditNum' : auditNum },
            success: function(data){
                if(data){
                    $(listDiv).html(data);
                    // console.log(data);
                }
            }
        });

    }

    // Выполняем запрос списка загруженных файлов
    if(typeof docDir !== 'undefined') {
        fileListRequest(docDir, docNameMask_requestFalhCa, auditNum, listDiv_requestFalhCa); // Запросы КП по ДЗЗ
        fileListRequest(docDir, docNameMask_requestCaBranch, auditNum, listDiv_requestCaBranch); // КП по ДЗЗ
        fileListRequest(docDir, docNameMask_answerBranchCa, auditNum, listDiv_answerBranchCa);
        fileListRequest(docDir, docNameMask_answerCaFalh, auditNum, listDiv_answerCaFalh);
        fileListRequest(docDir, docNameMask_orderAudit, auditNum, listDiv_orderAudit);
        // console.log('Есть переменная docDir, обновляем списки файлов');
    } 
    // else console.log('Нет переменной docDir');
JS;

$this->registerJs($js);
?>
