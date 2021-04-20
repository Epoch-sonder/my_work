<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\forest_work\models\ForestWorkReporter */

$this->title = 'Create Forest Work Reporter';
$this->params['breadcrumbs'][] = ['label' => 'Forest Work Reporters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forest-work-reporter-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
