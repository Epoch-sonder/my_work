<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pd\models\PdWorktype */

$this->title = 'Изменение типа работ по проектированию: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Типы работ по проектированию', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pd-worktype-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
