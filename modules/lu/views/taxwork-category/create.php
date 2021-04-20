<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\TaxworkCategory */

$this->title = 'Create Taxwork Category';
$this->params['breadcrumbs'][] = ['label' => 'Taxwork Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="taxwork-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
