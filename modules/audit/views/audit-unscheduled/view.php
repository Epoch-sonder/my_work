<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\AuditUnscheduled */

$this->title = 'Информация о внеплановых проверках';
$this->params['breadcrumbs'][] = ['label' => 'Audit Unscheduleds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$docdir = 'docs/audit/unscheduled/'.$model->id.'/';
$id_audit=$model->id;
$docNameMask_requisitesRequest = 'RequisitesRequest_*';
$docNameMask_requisitesResponse = 'RequisitesResponse_*';
$docNameMask_completedWork = 'CompletedWork_*';
$docNameMask_conclusionByWork = 'ConclusionByWork_*';
$docNameMask_proposalsByWork = 'ProposalsByWork_*';


?>
<div class="audit-unscheduled-view">
    <p>
        <?= Html::a('<- вернуться к списку внеплановых проверок', ['../audit/audit-unscheduled/' ], ['class' => 'btn btn-primary']); ?>
    </p>

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

            margin: 10px 0 5px 6px;
            display: inline-block;
        }
        .Text{
            font-weight: bold;
            margin: 10px 0 5px 6px;
            display: inline-block;
        }
        .leftfloat , .rightfloat{
            widows: revert;
            margin: 0;
        }
        .floatNo{
            width: 100%;
            margin: 0 0 15px 20px !important;
        }
        .statement span,
        .taxCard span,
        .floatNo span {
            display: none;
        }
    </style>



    <?php
    $subject = \app\models\FederalSubject::find()->where(['=','federal_subject_id',$model->subject])->asArray()->one();
    $branch =\app\models\Branch::find()->where(['=','branch_id',$model->branch])->asArray()->one();


    $dateS = new \DateTime($model->date_start);
    $dateF = new \DateTime($model->date_finish);
    $DateAll = date_diff($dateS, $dateF)  ;
    $DateAll = $DateAll->d + 1;
    $dateS = date_format($dateS,"d.m.Y");
    $dateF = date_format($dateF,"d.m.Y");
    echo '<div style="width:100%" class="div"> ';

    echo '<div class="greyDiv" style="width: 100%; float: left;"><h4>'. Html::encode($this->title) .'</h4></div>';

    echo '<div><h5 class="textBold"> Субъект РФ: <h5 class="Text">'.$subject['name'].'</h5></h5></div>' ;
    echo '<div><h5 class="textBold"> Дата начала проверки: <h5 class="Text">'.$dateS.'  </h5></h5></div>' ;
    echo '<div><h5 class="textBold"> Дата окончания проверки: <h5 class="Text"> '.$dateF.' </h5></h5></div>' ;
    echo '<div><h5 class="textBold"> Дни: <h5 class="Text"> '.$DateAll.' </h5></h5></div>' ;
    echo '<div><h5 class="textBold"> Филиал: <h5 class="Text">'.$branch['name'].'</h5></h5></div>' ;
    echo '<div><h5 class="textBold"> ФИО и должность исполнителя: <h5 class="Text">'.$model->fio.'</h5></h5></div>' ;
    echo '<div><h5 class="textBold"> Затраты на участие: </h5><h5 class="Text">'.$model->participation_cost.'</h5></div>';
    echo '<div><h5 class="textBold"> Замечания: <h5 class="Text">'.$model->comment.'</h5></h5></div>' ;
    echo '<div><h5 class="textBold"> Предложения: </h5><h5 class="Text">'.$model->proposal.'</h5></div><br>';

    echo '<div class="greyDiv"><h4>Документы: </h4></div>';
    ?>
    <div class="requisitesRequest"> <h5>Реквизиты экспертизы(запрос)</h5><div class="floatNo  file_list" style="margin-top: 10px"></div></div>
    <div class="requisitesResponse"><h5>Реквизиты экспертизы(ответ)</h5><div class="floatNo file_list"></div></div>
    <div class="completedWork"><h5>Выводы представленные по итогу работ</h5><div class="floatNo file_list"></div></div>
    <div class="conclusionByWork"><h5>Предложения представленные по итогу работ</h5><div class="floatNo file_list"></div></div>
    <div class="proposalsByWork"><h5>Cправка о выполненной работе с подписью</h5><div class="floatNo file_list"></div></div>

    <?php
    echo '<div></div>';
    echo '</div>';

    ?>

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
    </script>
</div>

<?php

$js = <<<JS
 
    function fileListRequest(docDir, docNameMask, auditNum, listDiv) {

        // Запрашиваем список файлов в папке по соответствующему контракту/закупке
        $.ajax({
            url: '/audit/audit-unscheduled/file-list-request',
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
        // console.log('Есть переменная docDir, обновляем списки файлов');
    } 
JS;

$this->registerJs($js);
?>