<?php

use app\models\ForestryMunic;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\TrainingProcess */

$this->title = 'Редактировать данные: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Training Processes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

?>
<div class="training-process-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'branchList'=>$branchList,
        'AreaArr'=>$AreaArr,
        'RegSubArr'=>$RegSubArr,
        'model' => $model,
        'model2' => $model2,
    ]) ?>

</div>
<script>
    var forestryUpdate = '<?= $model['forestry'] ?>';
    var trainingforestryUpdate = '<?= $model['training_forestry']?>';
    var subforestryUpdate = '<?= $model['subforestry']?>';
    var trainingsubforestryUpdate = '<?= $model['training_subforestry']?>';
    var municUpdate = '<?= $model['munic_region']?>';
</script>
<?php



$js = <<< JS


subj = fpress2;
    changeMunic(municUpdate);
start();
function start(){
    viewPeople();
    changeValLR();
    $('#trainingprocess-subject').val(fpress2); //выбирает value с помощью переменной fpress2
    $('#trainingprocess-forestgrow_region').val(fpress3);//выбирает value с помощью переменной fpress3
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
    forestry = forestryUpdate;
    trforestry = trainingforestryUpdate;
    
}

JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($js, yii\web\View::POS_END);
?>