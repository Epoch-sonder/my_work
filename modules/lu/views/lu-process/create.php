<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\LuProcess */

$this->title = 'Create Lu Process';
$this->params['breadcrumbs'][] = ['label' => 'Lu Processes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lu-process-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
