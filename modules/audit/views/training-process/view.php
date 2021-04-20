<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\TrainingProcess */

$this->title = 'Коллективная тренировка';
$this->params['breadcrumbs'][] = ['label' => 'Training Processes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);


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
    <?php
    if ( \Yii::$app->user->can('tr_process_check')){

    $form = ActiveForm::begin();


     echo '<div style="background: #c0c0c033;width: 20%;margin-bottom: 15px">'.'<div style="padding: 10px">'.$form->field($model2, 'verified')->checkbox([ 'value' => '1'])->label('');
     echo Html::submitButton("Сохранить", ["class" => "btn btn-success"]) . '</div></div>';

    ActiveForm::end();
    }
    ?>



    <p>
        <?= Html::a('<- вернуться к тренировочному процессу', ['../audit/training-process/' ], ['class' => 'btn btn-primary']); ?>
    </p>

    <h2><?= Html::encode($this->title) ?></h2>

    <style>
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
    </style>
    <?php
    $dateS = new \DateTime($model->training_date_start);
    $dateF = new \DateTime($model->training_date_finish);
    $DateAll = date_diff($dateS, $dateF)  ;
    $DateAll = $DateAll->d + 1;
    $dateS = date_format($dateS,"d.m.yy");
    $dateF = date_format($dateF,"d.m.yy");
    echo '<div style="width:100%" class="div"> ';

    echo '<div class="greyDiv" style="width: 50%; float: left;">';
    echo '<h4>Филиал <h5> '.$branchName['name'] .'</h5></h4>';
    echo '</div>';

    echo '<div class="greyDiv" style="width: 50%; float: left;">';
    echo '<h4>Номер контракта<h5>'.$model->training_contract_num .'</h5></h4>';
    echo '</div>';



    echo '<div class="greyDiv" style="width: 100%; float: left;"><h4>Место проведения работ </h4></div>';

    echo '<div><h5 class="textBold"> Субъект РФ: <h5 class="Text"> '.$subjectName['name'].' </h5></h5></div>' ;

    echo '<div><h5 class="textBold">Лесорастительный район:</h5> <h5 class="Text">'. $forestgrowName['name'] .'</h5></div> ';

    echo '<div><h5 class="textBold">Муниципальный район:</h5> <h5 class="Text">'.$municName['name'] .'</h5></div>';

    echo '<div><h5 class="textBold">Лесничество: </h5><h5 class="Text">'. $forestryName['forestry_name'].'</h5></div>';

    echo '<div><h5 class="textBold">Участковое лесничество:</h5><h5 class="Text">'. $subforestryName['subforestry_name'].'</h5></div><br>';

    echo '<div class="greyDiv"><h4>Место проведения тренировки </h4></div>';

    echo '<div><h5 class="textBold">Тренировочное лесничество: </h5><h5 class="Text">'. $trforestryName['forestry_name'].'</h5></div>';

    echo '<div><h5 class="textBold">Тренировочное участковое лесничество: </h5><h5 class="Text">'. $trsubforestryName['subforestry_name'].'</h5></div>';

    echo '<div><h5 class="textBold">Период тренировки:  </h5><h5 class="Text">с '.$dateS .' по '.$dateF.' (Дней '. $DateAll .' ) </h5></div>';

    echo '<div><h5 class="textBold">Квартал и выдел: </h5><h5 class="Text">'.$model->training_quarter_strip .'</h5><br></div>';

    echo '<div><h5 class="textBold">Количество тренировочных площадок: </h5><h5 class="Text">'.$model->training_site_amount .'</h5></div>';

    echo '<div><h5 class="textBold">Количество тренировочных выделов: </h5><h5 class="Text">'.$model->training_strip_amount .'</h5></div><br>';

    echo '<div class="greyDiv"><h4>Участники тренировки: </h4></div>';

    echo '<div>' . $peopleNameAll . ' </div><br>';
    echo '<div class="greyDiv"><h4> Документы </h4></div>';

   ?>


<div class="floatNo pppCard file_list" style="margin-top: 10px"></div>
<div class="floatNo pppMap file_list"></div>
<div class="floatNo stripCard file_list"></div>
<div class="floatNo invite file_list"></div>
<div class="floatNo act file_list"></div>
<div class="floatNo orderBranch file_list"></div>
<div class="floatNo orderOiv file_list" style="margin-bottom: 10px"></div>
<table>
    <tr>
        <td><div class=" statement"><div class="file_list"></div></div></td>
        <td><div class=" taxCard"><div class="file_list"></div></div></td>
    </tr>
</table>



</div>
<script type="text/javascript">
    // Переменные для функции опроса директории с файлами
    var docDir = '<?= $docdir ?>';
    var auditNum = '<?= $id_audit ?>';

    var docNameMask_stripCard = '<?= $docNameMask_stripCard?>';
    var NameMaskRus_stripCard = 'Карточка выделов уточненной таксации';
    var listDiv_stripCard = '.stripCard.file_list';

    var docNameMask_pppCard = '<?= $docNameMask_pppCard?>';
    var NameMaskRus_pppCard = 'Карточка ППП';
    var listDiv_pppCard = '.pppCard.file_list';

    var docNameMask_pppMap = '<?= $docNameMask_pppMap ?>';
    var NameMaskRus_pppMap = 'Карта-схема ППП';
    var listDiv_pppMap = '.pppMap.file_list ';

    var docNameMask_invite = '<?= $docNameMask_invite ?>';
    var NameMaskRus_invite = 'Приглашение на тренировку';
    var listDiv_invite = '.invite.file_list ';

    var docNameMask_act = '<?= $docNameMask_act ?>';
    var NameMaskRus_act = 'Карточка таксации';
    var listDiv_act = '.act.file_list ';

    var docNameMask_taxCard = '<?= $docNameMask_taxCard ?>';
    var NameMaskRus_taxCard = '';
    var listDiv_taxCard  = '.taxCard .file_list ';

    var docNameMask_statement = '<?= $docNameMask_statement ?>';
    var NameMaskRus_statement = '';
    var listDiv_statement = '.statement .file_list ';

    var docNameMask_orderBranch = '<?= $docNameMask_orderBranch ?>';
    var NameMaskRus_orderBranch  = 'Приказ Филиалу';
    var listDiv_orderBranch  = '.orderBranch.file_list ';

    var docNameMask_orderOiv = '<?= $docNameMask_orderOiv?>';
    var NameMaskRus_orderOiv = 'Приказ ОИВ';
    var listDiv_orderOiv = '.orderOiv.file_list ';

</script>


<?php

$js = <<<JS

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
   
    function fileListRequest(docDir, docNameMask, NameMaskRus, auditNum, listDiv ) {
       var csrfToken = $('meta[name="csrf-token"]').attr("content");
        // Запрашиваем список файлов в папке по соответствующему контракту/закупке
        $.ajax({
            type: 'POST',
            url: '/audit/training-process/file-list-request',
            data: {'docDir' : docDir, 'docNameMask' : docNameMask, 'NameMaskRus' : NameMaskRus,  'auditNum' : auditNum ,_csrf :  csrfToken},
            success: function(data){
                if(data){
                    $(listDiv).html(data);
                    renderName($('.statement .file_list a'), 'Сличительная ведомость')
                    renderName($('.taxCard .file_list a') , 'Карточка таксации')
                }
            }
        });
    }
    
    // Выполняем запрос списка загруженных файлов
    fileListRequest(docDir, docNameMask_stripCard,NameMaskRus_stripCard, auditNum, listDiv_stripCard);
    fileListRequest(docDir, docNameMask_pppCard,NameMaskRus_pppCard, auditNum, listDiv_pppCard);
    fileListRequest(docDir, docNameMask_pppMap,NameMaskRus_pppMap, auditNum, listDiv_pppMap);
    fileListRequest(docDir, docNameMask_invite,NameMaskRus_invite, auditNum, listDiv_invite); 
    fileListRequest(docDir, docNameMask_act,NameMaskRus_act,auditNum, listDiv_act);
    fileListRequest(docDir, docNameMask_taxCard,NameMaskRus_taxCard, auditNum, listDiv_taxCard);
    fileListRequest(docDir, docNameMask_statement,NameMaskRus_statement, auditNum, listDiv_statement);
    fileListRequest(docDir, docNameMask_orderBranch,NameMaskRus_orderBranch, auditNum, listDiv_orderBranch);
    fileListRequest(docDir, docNameMask_orderOiv,NameMaskRus_orderOiv,auditNum, listDiv_orderOiv);
    
    
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

$this->registerJs($js);


?>

</div>
