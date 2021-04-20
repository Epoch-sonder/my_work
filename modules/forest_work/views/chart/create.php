<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\forest_work\models\ForestWork */

$this->title = 'Create Forest Work';
$this->params['breadcrumbs'][] = ['label' => 'Forest Works', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forest-work-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>



</div>


