<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\ForestgrowZone */

$this->title = 'Создать лесорастительную зону';
$this->params['breadcrumbs'][] = ['label' => 'Forestgrow Zones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forestgrow-zone-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
