<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\NsiKfz */

$this->title = 'Create Nsi Kfz';
$this->params['breadcrumbs'][] = ['label' => 'Nsi Kfzs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nsi-kfz-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
