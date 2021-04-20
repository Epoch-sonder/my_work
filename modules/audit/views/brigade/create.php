<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\Brigade */

$this->title = 'Создание новой записи о бригаде';
$this->params['breadcrumbs'][] = ['label' => 'Brigades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brigade-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'RegSubArr'=>$RegSubArr,
    ]) ?>

</div>
