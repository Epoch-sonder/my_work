<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\TrainingPerson */

$this->title = 'Добавить участника коллективной тренировки';
$this->params['breadcrumbs'][] = ['label' => 'Training People', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="training-person-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
