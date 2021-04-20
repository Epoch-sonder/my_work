<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\Land */

$this->title = 'Create Land';
$this->params['breadcrumbs'][] = ['label' => 'Lands', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="land-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
