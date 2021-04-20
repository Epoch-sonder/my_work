<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\Audit */
$this->title = 'Информация о проверке';
$this->params['breadcrumbs'][] = ['label' => 'Audits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);


$nameDistr = \app\modules\audit\models\FederalDistrict::find()->where("federal_district_id = $model->fed_district")->select('name')->one();
$nameSub = \app\modules\audit\models\FederalSubject::find()->where("federal_subject_id = $model->fed_subject")->select('name')->one();
$nameOiv = \app\modules\audit\models\OivSubject::find()->where("id = $model->oiv")->select('name')->one();
$nameType = \app\modules\audit\models\AuditType::find()->where("id = $model->audit_type")->select('type')->one();
$docdir = 'docs/audit/audit/'.$model->id.'/';
$id_audit=$model->id;
$docNameMask_orderAudit = 'OrderAudit_*';
$docNameMask_requestFalhCa = 'RequestFalhCa_*';
$docNameMask_answerBranchCa = 'AnswerBranchCa_*';
$docNameMask_requestCaBranch = 'RequestCaBranch_*';
$docNameMask_answerCaFalh = 'AnswerCaFalh_*';



?>
<div class="audit-view">



    <p>
        <?php
        if(Yii::$app->request->get('from_date') != null and Yii::$app->request->get('to_date') != null){
            $return_data = '?from_date='.Yii::$app->request->get('from_date').'&to_date='.Yii::$app->request->get('to_date');
        }
        elseif (Yii::$app->request->get('from_date') == null and Yii::$app->request->get('to_date') != null){
            $return_data = '?to_date='.Yii::$app->request->get('to_date');
        }
        elseif (Yii::$app->request->get('from_date') != null and Yii::$app->request->get('to_date') == null){
            $return_data = '?from_date='.Yii::$app->request->get('from_date');
        }
        else{
            $return_data = '';
        }

        ?>

        <?php
        if(Yii::$app->request->get('process') == 1){
            echo Html::a('<- вернуться к списку проверок', ['../audit/audit-process/'], ['class' => 'btn btn-primary']);
            echo  '<br>';
            echo  '<br>';
        }
        elseif( \Yii::$app->user->can('audit_process_edit') or \Yii::$app->user->can('audit_process_view') ){
            echo Html::a('<- вернуться к ходу проверок', ['../audit/audit-process/'], ['class' => 'btn btn-primary']);
            echo  '<br>';
            echo  '<br>';
        }
        else{
            echo Html::a('<- вернуться к своду', ['../audit/audit/summary'.$return_data], ['class' => 'btn btn-primary']);
            echo  '<br>';
            echo  '<br>';
        }



        ?>
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
    </style>
    <?php
    $dateS = new \DateTime($model->date_start);
    $dateF = new \DateTime($model->date_finish);
    $dateS = date_format($dateS,"d.m.yy");
    $dateF = date_format($dateF,"d.m.yy");

    echo '<div style="width:100%" class="div"> ';
    echo '<div class="greyDiv" style="width: 100%; float: left;">';
    echo '<h4>Проверяемый ОИВ <h5> '.$nameOiv['name'].'</h5></h4>';
    echo '</div>';
    echo '<div style="width: 100%; float: left;">';
    echo '<h4>Организатор проверки <h5> '.$model->organizer.' </h5></h4>';
    echo '</div>';
    echo '<div style="width: 100%; float: left;">';
    echo '<h4>Период проверки <h5>с '.$dateS .' по '.$dateF.' (Дней '.$model->duration.' ) </h5></h4>';
    echo '</div>';
    echo '<div style="width: 100%;float: left;">';
    echo '<h4>Федеральный округ <h5>'. $nameDistr['name'] .'</h5></h4>
           </div> ';
    echo '<div style="width: 100%;float: left;">';
    echo '<h4>Субъект РФ <h5>'.$nameSub['name'] .'</h5></h4>
           </div> ';
    echo '<div style="width: 100%;float: left;">';
    echo '<h4>Тип проверки <h5>'.$nameType['type'] .'</h5></h4>
           </div> ';

   ?>

        <div class="divflow greyDiv" ><h4 style="margin-top: 15px;"> Документы</h4></div>
        <div class="divflow">
            <div class="leftfloat requestFalhCa">
                <h4>Запрос ФАЛХ в ЦА</h4>
                <div class="file_list"></div>
            </div>
            <div class="rightfloat answerBranchCa">
                <h4>Ответы филиалов в ЦА</h4>
                <div class="file_list"></div>
            </div>
        </div>

        <div class="divflow">
            <div class="leftfloat requestCaBranch">
                <h4>Запрос ЦА в филиалы</h4>
                <div class="file_list"></div>
            </div>
            <div class="rightfloat answerCaFalh">
                <h4>Ответы ЦА в ФАЛХ</h4>
                <div class="file_list"></div>
            </div>

        </div>

        <div class="divflow">
            <div class="leftfloat orderAudit">
                <h4>Приказ о проверке</h4>
                <div class="file_list"></div>
            </div>

        </div>
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