<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\NsiInfo */

$this->title = 'Создание новой записи';
$this->params['breadcrumbs'][] = ['label' => 'Nsi Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nsi-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
