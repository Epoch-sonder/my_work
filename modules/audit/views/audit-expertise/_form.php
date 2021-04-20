<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\AuditExpertise */
/* @var $form yii\widgets\ActiveForm */

$docdir = 'docs/audit/expertise/'.$model->id.'/';
$id_audit=$model->id;
$docNameMask_requisitesRequest = 'RequisitesRequest_*';
$docNameMask_requisitesResponse = 'RequisitesResponse_*';
$docNameMask_completedWork = 'CompletedWork_*';
$docNameMask_conclusionByWork = 'ConclusionByWork_*';
$docNameMask_proposalsByWork = 'ProposalsByWork_*';
$docNameMask_contract = 'Contract_*';

?>
<style>
    #auditexpertise-comment, #auditexpertise-proposal{
        height: 168px;
    }
</style>
    <p>
        <?= Html::a('<- вернуться к списку экспертиз', ['../audit/audit-expertise/' ], ['class' => 'btn btn-primary']); ?>
    </p>
<div class="audit-expertise-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-4 ">
            <?= $form->field($model, 'subject')->dropDownList(ArrayHelper::map(app\modules\audit\models\FederalSubject::find()/*->where($condBranch)*/->orderBy(['name' => SORT_ASC])->all(), 'federal_subject_id', 'name')) ?>
        </div>
        <div class="col-sm-4 ">
            <?= $form->field($model, 'branch')->dropDownList(ArrayHelper::map(\app\models\Branch::find()->orderBy(['name' => SORT_ASC])->all(), 'branch_id', 'name')) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4 ">
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
        <div class="col-sm-4 ">
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

    <div class="row">
        <div class="col-sm-5 ">
            <?= $form->field($model, 'contract')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3 ">
            <?= $form->field($model, 'sum_contract')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-5 ">
            <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3 ">
            <?= $form->field($model, 'participation_cost')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8 ">
            <?= $form->field($model, 'comment')->textarea() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8 ">
            <?= $form->field($model, 'proposal')->textarea() ?>
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
        <div class="col-sm-12"><h3>Файлы по экспертизе(.pdf, .doc, .docx)</h3></div>
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
        <div class="col-sm-4 contract" >
            <h4>Договор </h4>
            <div class="file_list"></div>
            <div class="bottom_file"> <?= $form2->field($model2, 'contract')->fileInput(['id' => 'contract'])->label(false) ;?>
                <?= Html::submitButton('Загрузить файл', ['class' => 'btn btn-primary btn-upl-file']); ?></div>
        </div>
        <div class="col-sm-4 completedWork" >
            <h4>Cправка о выполненной работе с подписью </h4>
            <div class="file_list"></div>
            <div class="bottom_file"> <?= $form2->field($model2, 'completedWork')->fileInput(['id' => 'completedWork'])->label(false) ;?>
                <?= Html::submitButton('Загрузить файл', ['class' => 'btn btn-primary btn-upl-file']); ?></div>
        </div>
    </div>
<!--    <div class="row" style="margin-bottom: 15px">-->
<!--        <div class="col-sm-4 conclusionByWork" >-->
<!--            <h4>Выводы представленные по итогу работ</h4>-->
<!--            <div class="file_list"></div>-->
<!--            <div class="bottom_file"> -->
                 <!--</div>-->
<!--        </div>-->
<!--        <div class="col-sm-4 proposalsByWork" >-->
<!--            <h4>Предложения представленные по итогу работ </h4>-->
<!--            <div class="file_list"></div>-->
<!--            <div class="bottom_file"> -->
                <!--</div>-->
<!--        </div>-->
<!--    </div>-->




    <script type="text/javascript">
        // Переменные для функции опроса директории с файлами
        var docDir = '<?= $docdir ?>';
        var auditNum = '<?= $id_audit ?>';

        var docNameMask_requisitesRequest = '<?= $docNameMask_requisitesRequest ?>';
        var listDiv_requisitesRequest = '.requisitesRequest .file_list';

        var docNameMask_requisitesResponse = '<?= $docNameMask_requisitesResponse ?>';
        var listDiv_requisitesResponse = '.requisitesResponse .file_list';

        var docNameMask_completedWork = '<?= $docNameMask_completedWork ?>';
        var listDiv_completedWork = '.completedWork .file_list';

        var docNameMask_conclusionByWork = '<?= $docNameMask_conclusionByWork ?>';
        var listDiv_conclusionByWork  = '.conclusionByWork .file_list';

        var docNameMask_proposalsByWork = '<?= $docNameMask_proposalsByWork ?>';
        var listDiv_proposalsByWork  = '.proposalsByWork .file_list';

        var docNameMask_contract = '<?= $docNameMask_contract ?>';
        var listDiv_contract  = '.contract .file_list';
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
        url: '/audit/audit-expertise/upload',
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
                $('#completedWork').val('');
                $('#conclusionByWork').val('');
                $('#proposalsByWork').val('');
                $('#contract').val('');
                // обновляем списки загруженных файлов в заявках и ПД после загрузки нового
                fileListRequest(docDir, docNameMask_requisitesRequest, auditNum, listDiv_requisitesRequest);
                fileListRequest(docDir, docNameMask_requisitesResponse, auditNum, listDiv_requisitesResponse);
                fileListRequest(docDir, docNameMask_completedWork, auditNum, listDiv_completedWork);
                fileListRequest(docDir, docNameMask_conclusionByWork, auditNum, listDiv_conclusionByWork);
                fileListRequest(docDir, docNameMask_proposalsByWork, auditNum, listDiv_proposalsByWork);
                fileListRequest(docDir, docNameMask_contract, auditNum, listDiv_contract);
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
            url: '/audit/audit-expertise/file-list-request',
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
        fileListRequest(docDir, docNameMask_completedWork, auditNum, listDiv_completedWork);
        fileListRequest(docDir, docNameMask_conclusionByWork, auditNum, listDiv_conclusionByWork);
        fileListRequest(docDir, docNameMask_proposalsByWork, auditNum, listDiv_proposalsByWork);
        fileListRequest(docDir, docNameMask_contract, auditNum, listDiv_contract);
        // console.log('Есть переменная docDir, обновляем списки файлов');
    } 
    // else console.log('Нет переменной docDir');
JS;

$this->registerJs($js);
?>