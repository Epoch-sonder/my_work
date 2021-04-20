<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\GpsTracking */

$this->title = 'Создание Gps-трекинга';
$this->params['breadcrumbs'][] = ['label' => 'Gps Trackings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gps-tracking-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('<- вернуться к Gps-трекингу', ['../lu/gps-tracking/' ], ['class' => 'btn btn-primary']); ?>
    </p>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
