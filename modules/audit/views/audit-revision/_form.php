<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\AuditRevision */
/* @var $form yii\widgets\ActiveForm */

$docdir = 'docs/audit/revision/'.$model->id.'/';
$id_audit=$model->id;
$docNameMask_requisitesRequest = 'RequisitesRequest_*';
$docNameMask_requisitesResponse = 'RequisitesResponse_*';
$docNameMask_inspectionInformation= 'InspectionInformation_*';
$docNameMask_responseOrder = 'ResponseOrder_*';




?>
<style>
    #auditrevision-comment, #auditrevision-proposal{
        height: 168px;
    }
</style>
    <p>
        <?= Html::a('<- вернуться к списку ревизий', ['../audit/audit-revision/' ], ['class' => 'btn btn-primary']); ?>
    </p>
<div class="audit-revision-form">

    <?php $form = ActiveForm::begin(); ?>


        <div class="row">
            <div class="col-sm-8 ">
                <?= $form->field($model, 'branch')->dropDownList(ArrayHelper::map(\app\models\Branch::find()->orderBy(['name' => SORT_ASC])->all(), 'branch_id', 'name')) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'inspectorate')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'date_start')->widget(DatePicker::classname(),
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
            </div>
            <div class="col-sm-4">
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
            </div>
        </div>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


    <?php
    // Если редактируем закупку, даем возможность загрузить файл
    // Если создаем новую закупку, возможности загрузки файла не даем, т.к. не знаем еще для какой закупки будет этот файл
    if(isset($model2)) {
    $form2 = ActiveForm::begin(['options' => ['id' => 'requestFileForm', 'enctype' => 'multipart/form-data']]);
    ?>

    <div>



        <div class="row" style="margin-bottom: 15px">
            <div class="col-sm-12"><h3>Файлы по ревизии (.pdf, .doc, .docx)</h3></div>
            <div class="col-sm-4 requisitesRequest" >
                <h4>Реквизиты(запрос)</h4>
                <div class="file_list"></div>
                <div class="bottom_file"> <?= $form2->field($model2, 'requisitesRequest')->fileInput(['id' => 'requisitesRequest'])->label(false) ;?>
                    <?= Html::submitButton('Загрузить файл', ['class' => 'btn btn-primary btn-upl-file']); ?></div>
            </div>
            <div class="col-sm-4 requisitesResponse" >
                <h4>Реквизиты(ответ)</h4>
                <div class="file_list"></div>

                <div class="bottom_file"> <?=  $form2->field($model2, 'requisitesResponse')->fileInput(['id' => 'requisitesResponse'])->label(false) ;?>
                    <?= Html::submitButton('Загрузить файл', ['class' => 'btn btn-primary btn-upl-file']); ?></div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 inspectionInformation" >
                <h4>Информация об итогах проведенной проверки</h4>
                <div class="file_list"></div>
                <div class="bottom_file"> <?= $form2->field($model2, 'inspectionInformation')->fileInput(['id' => 'inspectionInformation'])->label(false) ;?>
                    <?= Html::submitButton('Загрузить файл', ['class' => 'btn btn-primary btn-upl-file']); ?></div>
            </div>
            <div class="col-sm-4 responseOrder" >
                <h4>Ответ на предписание по итогам проверки</h4>
                <div class="file_list"></div>
                <div class="bottom_file"> <?= $form2->field($model2, 'responseOrder')->fileInput(['id' => 'responseOrder'])->label(false) ;?>
                    <?= Html::submitButton('Загрузить файл', ['class' => 'btn btn-primary btn-upl-file']); ?></div>
            </div>

        </div>


        <script type="text/javascript">
            // Переменные для функции опроса директории с файлами
            var docDir = '<?= $docdir ?>';
            var auditNum = '<?= $id_audit ?>';

            var docNameMask_requisitesRequest = '<?= $docNameMask_requisitesRequest ?>';
            var listDiv_requisitesRequest = '.requisitesRequest .file_list';

            var docNameMask_requisitesResponse = '<?= $docNameMask_requisitesResponse ?>';
            var listDiv_requisitesResponse = '.requisitesResponse .file_list';

            var docNameMask_inspectionInformation = '<?= $docNameMask_inspectionInformation ?>';
            var listDiv_inspectionInformation = '.inspectionInformation .file_list';

            var docNameMask_responseOrder = '<?= $docNameMask_responseOrder ?>';
            var listDiv_responseOrder  = '.responseOrder .file_list';
        </script>

        <?php
        echo $form2->field($model2, 'check_num')->hiddenInput(['value' => $id_audit,'readonly' => true])->label(false);
        echo ' </div>';
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
        url: '/audit/audit-revision/upload',
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
                $('#requisitesRequest').val('');
                $('#requisitesResponse').val('');
                $('#inspectionInformation').val('');
                $('#responseOrder').val('');
                // обновляем списки загруженных файлов в заявках и ПД после загрузки нового
                fileListRequest(docDir, docNameMask_requisitesRequest, auditNum, listDiv_requisitesRequest);
                fileListRequest(docDir, docNameMask_requisitesResponse, auditNum, listDiv_requisitesResponse);
                fileListRequest(docDir, docNameMask_inspectionInformation, auditNum, listDiv_inspectionInformation);
                fileListRequest(docDir, docNameMask_responseOrder, auditNum, listDiv_responseOrder);
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
            url: '/audit/audit-revision/file-list-request',
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
         fileListRequest(docDir, docNameMask_requisitesRequest, auditNum, listDiv_requisitesRequest);
         fileListRequest(docDir, docNameMask_requisitesResponse, auditNum, listDiv_requisitesResponse);
         fileListRequest(docDir, docNameMask_inspectionInformation, auditNum, listDiv_inspectionInformation);
         fileListRequest(docDir, docNameMask_responseOrder, auditNum, listDiv_responseOrder);
        // console.log('Есть переменная docDir, обновляем списки файлов');
    } 
    // else console.log('Нет переменной docDir');
JS;

$this->registerJs($js);
?>