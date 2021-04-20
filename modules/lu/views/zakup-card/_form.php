<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\ZakupCard */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zakup-card-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'zakup_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'zakup_link')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'contest_type')->textInput() ?>
    <?= $form->field($model, 'contest_type')->dropDownList(ArrayHelper::map(app\modules\lu\models\ContestType::find()->all(), 'id', 'name')) ?>

    <?php //= $form->field($model, 'date_placement')->textInput() ?>
    <?= $form->field($model, 'date_placement')->widget(DatePicker::classname(),
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

    <?= $form->field($model, 'price_start')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'finsource_type')->textInput() ?>
    <?= $form->field($model, 'finsource_type')->dropDownList(ArrayHelper::map(app\modules\lu\models\Finsource::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'smp_attraction')->textInput() ?>

    <?= $form->field($model, 'customer_name')->textInput(['maxlength' => true]) ?>

<hr class="greenline">
    <?php //= $form->field($model, 'fed_subject')->textInput() ?>
    <?= $form->field($model, 'fed_subject')->dropDownList(ArrayHelper::map(app\modules\lu\models\FederalSubject::find()->orderBy(['name' => SORT_ASC])->all(), 'federal_subject_id', 'name'), ['prompt' => 'Выберите субъект РФ']) ?>

    <?php //= $form->field($model, 'land_cat')->textInput() ?>
    <?= $form->field($model, 'land_cat')->dropDownList(ArrayHelper::map(app\modules\lu\models\Land::find()->all(), 'land_id', 'name')) ?>
    
    
    <?php
    if ($model->fed_subject) {
        if ($model->land_cat) {
            
            // $forestry_list_condition = $model->land_cat;
            
            function actualizeForestryList($form, $model, $subject_id, $land_cat) {
                if ( $land_cat == 1) {    // lesnoy fond
                    echo $form->field($model, 'region')->dropDownList(ArrayHelper::map(app\modules\lu\models\Forestry::find()->where("subject_kod = $subject_id")->all(), 'forestry_kod', 'forestry_name'));
                }
                if ( $land_cat == 2) {
                    // oborona i bezopasnost
                    echo $form->field($model, 'region')->dropDownList(ArrayHelper::map(app\modules\lu\models\ForestryDefense::find()->where("subject_kod = $subject_id")->all(), 'forestry_kod', 'forestry_name'));
                }
                if ( $land_cat == 3) {    // naselennie punkty
                    echo $form->field($model, 'region')->dropDownList(ArrayHelper::map(app\modules\lu\models\Cityregion::find()->where("subject_kod = $subject_id")->all(), 'cityregion_kod', 'cityregion_name'));
                }
                if ( $land_cat == 4) {    // oopt
                    echo $form->field($model, 'region')->dropDownList(ArrayHelper::map(app\modules\lu\models\Oopt::find()->where("subject_kod = $subject_id")->all(), 'oopt_kod', 'oopt_name'));
                }
                if ( $land_cat == 5) {    // Инные
                    echo $form->field($model, 'region')->dropDownList([0=>'Иные']);
                }
            }

            actualizeForestryList($form, $model, $model->fed_subject, $model->land_cat);

        }
    }
    else{
        echo $form->field($model, 'region')->dropDownList([0=>'Выберите Субъект РФ']);
    }
    ?>


    <?php //= $form->field($model, 'region')->textInput(['maxlength' => true])->label('Лесничество') ?>


    <?= $form->field($model, 'region_subdiv')->textInput(['maxlength' => true])->label('Участковое лесничество') ?>


<hr class="greenline">
    <h3>ДЗЗ</h3>
    
    <?php //= $form->field($model, 'dzz_type')->textInput() ?>
    <?= $form->field($model, 'dzz_type')->dropDownList(ArrayHelper::map(app\modules\lu\models\DzzType::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'dzz_resolution')->label('Разрешение, m/px (разделитель десятичный знаков-запятая)')->textInput(['maxlength' => true]) ?>

    <div class="form-group field-zakupcard-veget_period">
        <label class="control-label" for="veget_period">Период проведения съемки</label>
        <input type="text" class="form-control" id="veget_period" name="veget_period" disabled="disabled">
    </div>



    <div class="dzz_request">
        <?= $form->field($model, 'dzz_request_sent')->checkbox() ?>

        <div class="file_list"></div>
        <?php
        // Выводим список файлов с запросами на КП по ДЗЗ, которые были загружены
        // по этой закупке (если существует такая папка)
        $docdir = 'docs/lu/zakupki/'.$model->zakup_num.'/';
        $docNameMask_RequestPdDzz = 'RequestPdDzz*';

        // if (file_exists($docdir)) {
            
        //     $files=FileHelper::findFiles($docdir, [ 'only' => [$docNameMask], 'recursive' => false ]); // только в этой папке, не включая вложенные ('recursive' => true - включая вложенные папки)
        //     if (isset($files[0])) {
        //         echo '<div class="file_list">';
        //             foreach ($files as $index => $file) {
        //                 $namedoc = substr($file, strrpos($file, '/') + 1);
        //                 echo '<i class="fas fa-file-pdf"></i> ' . Html::a($namedoc, '/docs/lu/zakupki/'.$model->zakup_num.'/'.$namedoc , ['target'=>'_blank']) . "<br/>";
        //             }
        //         echo '</div>';
        //     } 
        //     else {
        //         // echo "Нет загруженных файлов";
        //     }
        // } 
        // Если нет папки с файлами для закупки
        // else echo "Нет директории с файлами";
        ?>


        <?= $form->field($model, 'dzz_control_date')->widget(DatePicker::classname(),
            [
                'language' => 'ru-RU',
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                    'orientation' => 'top right',
                ]
            ]);
        ?>
    </div>


    <div class="dzz_pd">
        <?= $form->field($model, 'dzz_cost')->textInput(['maxlength' => true]) ?> 

        <div class="file_list"></div>

        <?php
        // Выводим список файлов с полученными КП по ДЗЗ (если существует такая папка)
        $docNameMask_PdDzz = 'PdDzz*';

        // if (file_exists($docdir)) {
            
        //     $files=FileHelper::findFiles($docdir, [ 'only' => ['PdDzz*'], 'recursive' => false ]);
        //     if (isset($files[0])) {
        //         echo '<div class="file_list">';
        //             foreach ($files as $index => $file) {
        //                 $namedoc = substr($file, strrpos($file, '/') + 1);
        //                 echo '<i class="fas fa-file-pdf"></i> ' . Html::a($namedoc, '/docs/lu/zakupki/'.$model->zakup_num.'/'.$namedoc , ['target'=>'_blank']) . "<br/>";
        //             }
        //         echo '</div>';
        //     } 
        //     else {
        //         // echo "Нет загруженных файлов";
        //     }
        // } 
        // Если нет папки с файлами для закупки
        // else echo "Нет директории с файлами";
        ?>
    </div>



        <script type="text/javascript">
        // Переменные для функции опроса директории с файлами
            var docDir = '<?= $docdir ?>';
            var zakupNum = '<?= $model->zakup_num ?>';
            var docNameMask_RequestPdDzz = '<?= $docNameMask_RequestPdDzz ?>';
            var listDiv_RequestPdDzz = '.dzz_request .file_list';
            var docNameMask_PdDzz = '<?= $docNameMask_PdDzz ?>';
            var listDiv_PdDzz = '.dzz_pd .file_list';
        </script>


<hr class="greenline">

    <h3>Победитель</h3>


    <?= $form->field($model, 'winner_we')->checkbox(['id' => 'winner_we']) ?>

    <?= $form->field($model, 'winner_name')->textInput(['maxlength' => true, 'id' => 'winner_name']) ?>

    <?= $form->field($model, 'price_final')->textInput(['maxlength' => true, 'id' => 'price_final']) ?>

    <?= $form->field($model, 'price_rli')->textInput(['maxlength' => true, 'id' => 'price_rli']) ?>


    <?php //= $form->field($model, 'contract_type')->textInput() ?>
    <?= $form->field($model, 'contract_type')->dropDownList(ArrayHelper::map(app\modules\lu\models\ContractType::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'contract_num')->textInput() ?>

    <?= $form->field($model, 'date_contract_start')->widget(DatePicker::classname(),
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


    <?= $form->field($model, 'date_contract_finish')->widget(DatePicker::classname(),
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
    <hr class="greenline">
    <div>
        <div id="preparatory_work"><?= $form->field($model, 'date_preparatory')->widget(DatePicker::classname(),
                [
                    'options' => [
                        'id' => "preparatory"],
                    'language' => 'ru-RU',
                    'removeButton' => false,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,
                        'orientation' => 'top right',
                    ]
                ]); ?></div>
        <div id="field_work"><?= $form->field($model, 'date_field')->widget(DatePicker::classname(),
                [
                    'options' => [
                        'id' => "field"],
                    'language' => 'ru-RU',
                    'removeButton' => false,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,
                        'orientation' => 'top right',
                    ]
                ]); ?></div>
        <div id="cameral_work"><?= $form->field($model, 'date_cameral')->widget(DatePicker::classname(),
                [
                    'options' => [
                        'id' => "cameral"],
                    'language' => 'ru-RU',
                    'removeButton' => false,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,
                        'orientation' => 'top right',
                    ]
                ]); ?></div>
    </div>
    <hr class="greenline">


    <?php //= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group clr">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success ']) ?>
    </div>

    <?php ActiveForm::end(); ?>





    <?php
    // Если редактируем закупку, даем возможность загрузить файл
    // Если создаем новую закупку, возможности загрузки файла не даем, т.к. не знаем еще для какой закупки будет этот файл
    if(isset($model2)) {

        echo '
        <hr class="blueline">
        <h3>Загрузка файлов</h3>'
        ;

        $form2 = ActiveForm::begin(['options' => ['id' => 'requestFileForm', 'enctype' => 'multipart/form-data']]);
        
            echo $form2->field($model2, 'dzzRequestFile')->fileInput(['id' => 'dzzRequestFile'])->label('Файл запроса КП по ДЗЗ (.pdf)');
            echo $form2->field($model2, 'dzzPdFile')->fileInput(['id' => 'dzzPdFile'])->label('Файл c КП по ДЗЗ (.pdf)');
            // Через поле передаем в аякс-запрос реестровый номер закупки для использования его
            // при формировании адреса расположения загружаемого файла.
            echo $form2->field($model2, 'zakup_num')->textInput(['value' => $model->zakup_num,'readonly' => true]); //->label(false);
            
            // Используем сессию для передачи номера закупки для использованя в ходе аякс-запроса
            // $session = Yii::$app->session;
            // $session->set('zakup_num', $model->zakup_num);
                    // if ($session->has('zakup_num') ) echo $session->get('zakup_num');
                    // ->remove('zakup_num');
echo "<br>";
            echo Html::submitButton('Загрузить файлы', ['class' => 'btn btn-primary btn-upl-file']);
        
        ActiveForm::end();
    }
    ?>


   

</div>


<?php
//     $script = <<< JS
//         // Функция показа вегетационного периода для сроков проведения съемки.

//         function actualizeVegetPeriod() {

//             var cur_subject = $('#zakupcard-fed_subject').val();
//             console.log(cur_subject);

//             // Запрашиваем из БД границы вегетационного периода по субъекту
//             $.ajax({
//                 url: '/lu/veget-period/get-period',
//                 type: 'POST',
//                 data: {"cur_subject": cur_subject},
//                 success: function(data){
//                     if(data){
//                         $('#veget_period').val(data);
//                         console.log(data);
//                     }
//                 }
//             });

//             // $('#veget_period').val(cur_subject);
//         }


//         $('#zakupcard-fed_subject option').eq(0).attr('disabled','disabled'); 
//         // .attr('selected', 'selected'); .removeAttr('disabled');

//         // Вызываем функцию после загрузки страницы
//         $(document).ready(function() {
//             actualizeVegetPeriod();
//         });

//         // Вызываем функцию при выборе субъекта из списка
//         $('#zakupcard-fed_subject').on('change', function() {
//             actualizeVegetPeriod();
//         });
// JS;
// //маркер конца строки, обязательно сразу, без пробелов и табуляции
// $this->registerJs($script, yii\web\View::POS_END);


$js = <<<JS

  if($('#zakupcard-region').val() == null){
      if ($('#zakupcard-land_cat').val() == 1){
          $('#zakupcard-region').html('<option value="0"> Нет земель лесного фонда</option>');
      }
      else if ($('#zakupcard-land_cat').val() == 2){
          $('#zakupcard-region').html('<option value="0"> Нет земель обороны и безопасности</option>');
      }
      else if ($('#zakupcard-land_cat').val() == 3){
          $('#zakupcard-region').html('<option value="0"> Нет земель населенных пунктов</option>');
      }
      else if ($('#zakupcard-land_cat').val() == 4){
          $('#zakupcard-region').html('<option value="0"> Нет земель ООПТ</option>');
      }
      else if ($('#zakupcard-land_cat').val() == 5){
          $('#zakupcard-region').html('<option value="0"> Иные</option>');
      }
    
  }




     //********************************************************
     // Загрузка файла с отправленным запросом КП по ДЗЗ
     //********************************************************

    // var tmpfile = ''; // переменная для имени загруженноо временного файла с границами территории

    $('#requestFileForm').on('beforeSubmit', function(e){

      // Создадим данные формы и добавим в них данные c файлом
      // var formData = new FormData($(this)[0]);
      var formData = new FormData($(this).get(0));
      // formData.append('zakup_num', $model->zakup_num);

      // Отправляем запрос
      $.ajax({
        url: '/lu/zakup-card/upload',
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
                $('#dzzRequestFile').val('');
                $('#dzzPdFile').val('');
                // обновляем списки загруженных файлов в заявках и ПД после загрузки нового
                fileListRequest(docDir, docNameMask_RequestPdDzz, zakupNum, listDiv_RequestPdDzz);
                fileListRequest(docDir, docNameMask_PdDzz, zakupNum, listDiv_PdDzz);
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

    function fileListRequest(docDir, docNameMask, zakupNum, listDiv) {

        // Запрашиваем список файлов в папке по соответствующему контракту/закупке
        $.ajax({
            url: '/lu/zakup-card/file-list-request',
            type: 'POST',
            data: {'docDir' : docDir, 'docNameMask' : docNameMask, 'zakupNum' : zakupNum },
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
        fileListRequest(docDir, docNameMask_RequestPdDzz, zakupNum, listDiv_RequestPdDzz); // Запросы КП по ДЗЗ
        fileListRequest(docDir, docNameMask_PdDzz, zakupNum, listDiv_PdDzz); // КП по ДЗЗ
        // console.log('Есть переменная docDir, обновляем списки файлов');
    } 
    // else console.log('Нет переменной docDir');
JS;

$this->registerJs($js);
?>