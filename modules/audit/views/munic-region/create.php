<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\MunicRegion */

$this->title = 'Создание муниципального района';
$this->params['breadcrumbs'][] = ['label' => 'Munic Regions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="munic-region-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'RegSubArr'=>$RegSubArr,
    ]) ?>

</div>
