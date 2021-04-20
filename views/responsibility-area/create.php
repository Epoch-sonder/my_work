<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ResponsibilityArea */

$this->title = 'Добавление субъекта РФ в зону ответственности филиала';
$this->params['breadcrumbs'][] = ['label' => 'Зоны ответственности', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="responsibility-area-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
