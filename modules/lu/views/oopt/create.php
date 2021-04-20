<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\Oopt */

$this->title = 'Create Oopt';
$this->params['breadcrumbs'][] = ['label' => 'Oopts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oopt-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
