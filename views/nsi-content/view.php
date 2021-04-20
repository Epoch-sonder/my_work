<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\NsiContent */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Nsi Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="nsi-content-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'soli_id',
            'class',
            'cod',
            'attr_textval',
            'class_01',
            'cod_01',
            'class_02',
            'cod_02',
            'class_03',
            'cod_03',
            'class_04',
            'cod_04',
            'class_05',
            'cod_05',
            'class_06',
            'cod_06',
            'class_07',
            'cod_07',
            'class_08',
            'cod_08',
            'class_09',
            'cod_09',
            'class_10',
            'cod_10',
            'class_11',
            'cod_11',
            'class_12',
            'cod_12',
            'class_13',
            'cod_13',
            'class_14',
            'cod_14',
            'class_15',
            'cod_15',
            'class_16',
            'cod_16',
            'class_17',
            'cod_17',
            'class_18',
            'cod_18',
            'class_19',
            'cod_19',
            'class_20',
            'cod_20',
            'class_21',
            'cod_21',
            'class_22',
            'cod_22',
            'class_23',
            'cod_23',
            'class_24',
            'cod_24',
            'class_25',
            'cod_25',
            'class_26',
            'cod_26',
            'class_27',
            'cod_27',
            'class_28',
            'cod_28',
            'class_29',
            'cod_29',
            'class_30',
            'cod_30',
            'class_31',
            'cod_31',
            'class_32',
            'cod_32',
            'class_33',
            'cod_33',
            'class_34',
            'cod_34',
            'class_35',
            'cod_35',
            'class_36',
            'cod_36',
            'class_37',
            'cod_37',
        ],
    ]) ?>

</div>
