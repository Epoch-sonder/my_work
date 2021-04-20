<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pd\models\VegetPeriod */

$this->title = 'Update Veget Period: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Veget Periods', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="veget-period-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
