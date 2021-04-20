<?php

use app\models\BranchPerson;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\Brigade */

$this->title = 'Информации о бригаде № ' . $model->brigade_number;
$this->params['breadcrumbs'][] = ['label' => 'Brigades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$docdir = 'docs/audit/brigade/'.$model->id.'/';
$id_audit= $model->id;
$docNameMask_fieldOrder = 'fieldOrder_*';
$docNameMask_businessTrip = 'businessTrip_*';



$dateThis = date_default_timezone_get();
$dateThis = new \DateTime($dateThis);
$dateThis = $dateThis->format('Y-m-d');


?>
<style>
    .brigade-online-form .field-brigadeonline-date_report{
        width: 20%;
        padding-right: 3%;
        padding-left: 1%;
        float: left;
    }
    .brigade-online-form .field-brigadeonline-remark{
        width: 70%;
        padding-right: 3%;
        float: left;
    }
    .brigade-online-form .form-group .btn-success{
        margin-top: 24px;
        width: 9%;
        float: left;
        margin-right: 1%;
    }
    .div{
        border: 1px solid ;
        border-color: #e7e7e7;
    }
    h4 , h5{
        margin-left: 10px;
    }
    pre{
        display: none;
    }

    .divNoborder div {
        border: 0;
    }
    .divflow div{
        border: 0;

    }
    .divflow{
        margin-bottom:  15px;
        width: 100%;

    }
    .greyDiv{
        border-top: 1px solid ;
        border-bottom: 1px solid ;
        border-color: #e7e7e7;
        background-color: #f9f9f9;

    }
    .file_list{
        margin-left: 20px;
    }
    .textBold {

        margin: 10px 0px 5px 6px;
        display: inline-block;
    }
    .Text{
        margin: 10px 0px 5px 6px;
        display: inline-block;
    }
    .leftfloat , .rightfloat{
        widows: revert;
        margin: 0px;
    }
    .floatNo{
        width: 100%;
        margin: 0px 0px 0px 20px;
    }
    .statement span,
    .taxCard span,
    .floatNo span {
        display: none;
    }
    .brigade-view .row {
        margin-right: 0;
        margin-left: 0;
        border: 1px solid #f5f4f4;
        border-top: 0;
    }
</style>





<div class="brigade-view">







<?php
    echo '<div style="width:100%" class="div"> ';

    echo '<div class="greyDiv" style="width: 100%; float: left;">';
    echo '<h2 style="margin: 15px ; font-weight:bold"  >'.$this->title .'</h2>';
    echo '</div>';



//    echo '<div class="greyDiv" style="width: 100%; float: left;"><h4> Информация о бригаде </h4></div>';

    echo '<div><h5 class="textBold">Филиал: </h5> <h5 class="Text">'.$branch['name'].'</h5></div> ';

    echo '<div><h5 class="textBold"> Субъект РФ: <h5 class="Text"> '.$subj['name'].'</h5></h5></div>' ;

    echo '<div><h5 class="textBold">Объект работ: </h5> <h5 class="Text">'.$model->object_work.'</h5></div>';

    echo '<div><h5 class="textBold">Реквизиты контракта: </h5><h5 class="Text">'.$model->contract.'</h5></div>';

    echo '<div><h5 class="textBold">Дата выезда на полевые работы: </h5><h5 class="Text">'.$model->date_begin.'</h5></div>';

    echo '<div><h5 class="textBold">Примечание: </h5><h5 class="Text">'.$model->remark.'</h5></div><br>';

    echo '<div class="greyDiv"><h4> Специалисты в бригаде:</h4></div>';

    $arrayPeople = $model->person;
    $arrayPeople = explode(",", $arrayPeople);
    foreach ($arrayPeople as $arraPeople){
        foreach ($branchPersons as $branchPerson){
            if ($branchPerson['id'] == $arraPeople){
                echo '<div><h5 class="textBold">Специалист </h5><h5 class="Text">'.$branchPerson['fio'] .'</h5></div>';
            }
        }
    } ?>

    <div class="greyDiv"><h4> Документы: </h4></div>

    <div class="row">
        <div class="col-md-4"> <div class="fieldOrder"><div class="file_list"></div></div> </div>
        <div class="col-md-8"><div class="businessTrip"><div class="file_list"></div></div></div>
    </div>


    <div class="greyDiv"><h4> Отчёты:</h4></div>
    <?php if (\Yii::$app->user->can('brigade_online_edit')){?>
    <div class="brigade-online-form">
        <h3 style="margin-left: 10px;">Добавление еженедельного отчета</h3>
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model2, 'brigade_number')->hiddenInput( ['value'=>$model->id])->label(false) ?>
        
        <?= $form->field($model2, 'date_report')->textInput(['value'=>$dateThis , 'readonly'=>'true'])->label('Текст отчёта') ?>
        <?= $form->field($model2, 'remark')->textInput(['maxlength' => true])->label('Текст отчёта') ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
    <?php } ?>
<?php



    foreach ($brigadeOnlines as $brigadeOnline){

//        if ($brigadeOnline['date_report'] >= $thisWeekStart and $brigadeOnline['date_report'] <= $thisWeekEnd){
    ?>
    <div class="row">
        <div class="col-lg-3"><h5 class="textBold">Отчёт от </h5><h5 class="Text"><?= $brigadeOnline['date_report']?> </h5></div>
        <div class="col-lg-9"><h5 class="textBold"></h5><h5 class="Text"><?= $brigadeOnline['remark'] ?></h5></div>
    </div>


    <?php

    }

    echo '<div></div>';

    echo '</div>';
?>

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
    <?php
$js = <<< JS
    fileListRequest(docDir, docNameMask_fieldOrder,NameMaskRus_fieldOrder, auditNum, listDiv_fieldOrder);
    fileListRequest(docDir, docNameMask_businessTrip,NameMaskRus_businessTrip, auditNum, listDiv_businessTrip);

    function fileListRequest(docDir, docNameMask, NameMaskRus, auditNum, listDiv ) {
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        // Запрашиваем список файлов в папке по соответствующему контракту/закупке
        $.ajax({
            type: 'POST',
            url: '/audit/brigade/file-list',
            data: {'docDir' : docDir, 'docNameMask' : docNameMask, 'NameMaskRus' : NameMaskRus,  'auditNum' : auditNum ,_csrf :  csrfToken},
            success: function(data){
                if(data || data==''){
                     $(listDiv).html(data);
                     renderName($('.businessTrip .file_list .name'), 'Направление специалиста');
                }
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
$this->registerJs($js, yii\web\View::POS_END); ?>







</div>
