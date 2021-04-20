<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\TaxworkCategory */

$this->title = 'Update Taxwork Category: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Taxwork Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="taxwork-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
