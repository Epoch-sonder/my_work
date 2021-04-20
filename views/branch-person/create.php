<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BranchPerson */

$this->title = 'Добавление работника филиала';
$this->params['breadcrumbs'][] = ['label' => 'Branch People', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="branch-person-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
