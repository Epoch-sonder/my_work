<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\GpsTracking */

$this->title = 'Обновление Gps треков';
$this->params['breadcrumbs'][] = ['label' => 'Gps Trackings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gps-tracking-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('<- вернуться к Gps-трекингу', ['../lu/gps-tracking/' ], ['class' => 'btn btn-primary']); ?>
    </p>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
