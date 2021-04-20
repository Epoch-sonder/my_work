<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\LuPhase */

$this->title = 'Создание фазы';
$this->params['breadcrumbs'][] = ['label' => 'Lu Phases', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lu-phase-create">

    <?= Html::a('<- Список фазы', ['index'], ['class' => 'btn btn-primary']) ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
