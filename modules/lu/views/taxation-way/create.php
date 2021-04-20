<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\TaxationWay */

$this->title = 'Create Taxation Way';
$this->params['breadcrumbs'][] = ['label' => 'Taxation Ways', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="taxation-way-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
