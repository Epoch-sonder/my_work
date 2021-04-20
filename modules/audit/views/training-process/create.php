<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\TrainingProcess */

$this->title = 'Создание тренировочного процесса';
$this->params['breadcrumbs'][] = ['label' => 'Training Processes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;





$js = <<< JS
start();
function start(){
    $('#trainingprocess-branch').val(branchid)
    // i = branchid;
    // changeValSub();
    subj = $('#trainingprocess-subject').val();
    changeValLR();
}
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($js, yii\web\View::POS_END);


?>
<div class="training-process-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'branchList'=>$branchList,
        'AreaArr'=>$AreaArr,
        'RegSubArr'=>$RegSubArr,
        'model' => $model,
    ]) ?>

</div>
