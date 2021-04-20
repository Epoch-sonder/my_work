<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\modules\pd\models\PdWorkProcess */

$this->title = 'Изменение стадии подготовки документации: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pd Work Processes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pd-work-process-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
            // $service = Service::findOne($id); 
            if(isset($pdwork)) {
                echo '<strong>ПД:</strong> ' . $pdwork->pdworktype->work_name 
                . '<br><strong>Филиал:</strong> ' . $pdwork->branchname->name 
                . '<br><strong>Заказчик:</strong> ' . $pdwork->customer
                . '<br>' . $pdwork->docName->doctype . ' ' . $pdwork->basedoc_name . ' от ' . $pdwork->basedoc_datasign;
            }
        ?>
    </p>

    <?= $this->render('_form', [
        'model' => $model,
        'pdwork' => $pdwork,
    ]) ?>

</div>
