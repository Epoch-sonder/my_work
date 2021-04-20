<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\AuditProcess */
/* @var $form yii\widgets\ActiveForm */


$docdir = 'docs/audit/process/'.$model->id.'/';
$id_process=$model->id;
$docNameMask_sectionProcess = 'sectionProcess_*';
$docNameMask_signatureReference = 'signatureReference_*';


?>
<style>
    .btn-primary{
        margin-top: 10px;
        margin-bottom: 20px;
    }
</style>
<?= Html::a('<-- Вернуться в ход проверок', ['/audit/audit-process/index'], ['class' => 'btn btn-primary']) ?>
<div class="audit-process-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //= $form->field($model, 'audit')->textInput() ?>

    <?php
    if (!( \Yii::$app->user->can('audit_process_edit') or \Yii::$app->user->can('audit_process_view') )){
        echo $form->field($model, 'audit')->dropDownList(ArrayHelper::map(app\modules\audit\models\Audit::find()->orderBy(['date_start' => SORT_ASC])->all(), 'id', 'fedSubjectOrg' ));
        echo $form->field($model, 'audit_chapter')->textInput() ;
    }
    else{
        $audit = \app\modules\audit\models\Audit::find()->where(['=','id',$model->audit])->one();
        $sub = \app\modules\audit\models\FederalSubject::find()->where(['=','federal_subject_id',$audit->fed_subject])->one();
        $chapter_a = Html::a(
            "$sub->name (  $audit->organizer ) ",
            ['../audit/audit/view?id='. $model->audit],
            ['title' => 'Подробнее']);
        echo '<div class="form-group field-auditprocess-audit" style="height:69px"><label class="control-label" for="field-auditprocess-audit">Проверка</label><br>'  .$chapter_a  . '</div>';
//        var_dump( $audit);
    }

    ?>


    <?php //= $form->field($model, 'audit_person')->textInput() ?>

    <?php
    if (!( \Yii::$app->user->can('audit_process_edit') or \Yii::$app->user->can('audit_process_view') ))
    echo $form->field($model, 'audit_person')->dropDownList(ArrayHelper::map(app\modules\audit\models\AuditPerson::find()->orderBy(['fio' => SORT_ASC])->all(), 'id', 'fio'));
    else{
        $audit_person = \app\modules\audit\models\AuditPerson::find()->where(['=','id',$model->audit_person])->one();
        echo '<div class = "form-group field-auditprocess-audit_person" style="height:69px"><label class="control-label" for="field-auditprocess-audit_person">Проверяющий специалист</label><br>'.$audit_person->fio.'</div>';
//        var_dump($audit);
        echo $form->field($model, 'audit_chapter')->textInput() ;

    }

    ?>
    <?= $form->field($model, 'date_start')->widget(DatePicker::classname(),
        [
            'language' => 'ru-RU',
            'removeButton' => false,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true,
                'orientation' => 'top right',
            ]
        ])->label('Дата начала командировки'); ?>

    <?= $form->field($model, 'date_finish')->widget(DatePicker::classname(),
        [
            'language' => 'ru-RU',
            'removeButton' => false,
            'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true,
            'orientation' => 'top right',
        ]
    ])->label('Дата окончания командировки'); ?>
    <?= $form->field($model, 'remote_mode')->dropDownList([0=>'Очно',1=>'Дистанционно'])->label('Формат проведения') ?>
    <?= $form->field($model, 'comment')->textarea() ?>

    <?= $form->field($model, 'proposal')->textarea() ?>


    <div>
    <h3> Расходы (использовать точку в качестве разделителя) </h3>
    <?= $form->field($model, 'money_daily')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'money_accomod')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'money_transport')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'money_other')->textInput(['maxlength' => true]) ?>

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
        <h3>Файлы по проверки</h3>
            <div class="leftfloat sectionProcess">
                <h4>Раздел (.doxc/.doc)</h4>
                <div class="file_list"></div>
                <div class="bottom_file"> <?= $form2->field($model2, 'sectionProcess')->fileInput(['id' => 'sectionProcess'])->label(false) ;?>
                    <?= Html::submitButton('Загрузить файл (.pdf)', ['class' => 'btn btn-primary btn-upl-file']); ?></div>
            </div>
            <div class="rightfloat signatureReference">
                <h4>Справка с подписью (.pdf)</h4>
                <div class="file_list"></div>
                <div class="bottom_file"> <?= $form2->field($model2, 'signatureReference')->fileInput(['id' => 'signatureReference'])->label(false) ;?></div>
            </div>
    </div>


        <script type="text/javascript">
            // Переменные для функции опроса директории с файлами
            var docDir = '<?= $docdir ?>';
            var auditNum = '<?= $id_process ?>';
            var docNameMask_sectionProcess = '<?= $docNameMask_sectionProcess ?>';
            var listDiv_sectionProcess = '.sectionProcess .file_list';
            var docNameMask_signatureReference = '<?= $docNameMask_signatureReference ?>';
            var listDiv_signatureReference = '.signatureReference .file_list';
        </script>
        <?php
        echo $form2->field($model2, 'check_num')->hiddenInput(['value' => $id_process,'readonly' => true])->label(false);
        ActiveForm::end();
        }
        ?>
</div>

<?php

$js = <<<JS
  //********************************************************
     // Загрузка файла с отправленным запросом КП по ДЗЗ
     //********************************************************
console.log(docDir)
   

    $('#requestFileForm').on('beforeSubmit', function(e){
      var formData = new FormData($(this).get(0)); 
      $.ajax({
        url: '/audit/audit-process/upload',
        type: 'POST',
        data: formData,
        cache: false,
        dataType: 'json',
        processData: false, // Не обрабатываем файлы (Don't process the files)
        contentType: false, // Так jQuery скажет серверу что это строковой запрос
        success: function(data){ // удачное завершение запроса к серверу, в переменной data ответ сервера
            if(data){
                var answer;
                if(data == 'nofiles') answer = 'Файлы не выбраны';
                else answer = 'файлы ' + data + ' загружены';
                console.log(answer);
                $('#sectionProcess').val('');
                $('#signatureReference').val('');
                // обновляем списки загруженных файлов в заявках и ПД после загрузки нового
                fileListRequest(docDir, docNameMask_sectionProcess, auditNum, listDiv_sectionProcess);
                fileListRequest(docDir, docNameMask_signatureReference, auditNum, listDiv_signatureReference);
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
            url: '/audit/audit-process/file-list-request',
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
        fileListRequest(docDir, docNameMask_sectionProcess, auditNum, listDiv_sectionProcess);
        fileListRequest(docDir, docNameMask_signatureReference, auditNum, listDiv_signatureReference);
        // console.log('Есть переменная docDir, обновляем списки файлов');
    } 
    // else console.log('Нет переменной docDir');
JS;

$this->registerJs($js);
?>