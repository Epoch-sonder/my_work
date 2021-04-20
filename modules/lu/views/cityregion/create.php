<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\Cityregion */

$this->title = 'Create Cityregion';
$this->params['breadcrumbs'][] = ['label' => 'Cityregions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cityregion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
