<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\MunicRegion */

$this->title = 'Редактировать данные: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Munic Regions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="munic-region-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'RegSubArr'=>$RegSubArr,
    ]) ?>

</div>
<?php



$js = <<< JS

start();
function start(){
    subj = fpress2;
    changeValLR();//возвращает функцию
    $('#municregion-federal_subject').val(fpress2); //возвращает значение переменной
    $('#municregion-forestgrow_region').val(fpress3);//возвращает значение переменной
    
    
}
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($js, yii\web\View::POS_END);
?>