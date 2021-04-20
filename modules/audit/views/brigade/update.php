<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\Brigade */

$this->title = 'Обновление информации о бригаде № ' . $model->brigade_number;
$this->params['breadcrumbs'][] = ['label' => 'Brigades', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="brigade-update">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
        'RegSubArr'=>$RegSubArr,

        'model2' => $model2,
    ]) ?>

</div>
<?php
$js = <<< JS
START()

JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($js, yii\web\View::POS_END);