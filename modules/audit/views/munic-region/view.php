<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\MunicRegion */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Munic Regions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="munic-region-view">

    <h1><?= Html::encode($this->title) ?></h1>
     <?php if (\Yii::$app->user->can('admin')){ ?>
        <p>
            <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы уверенны, что хотите удалить запись?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
     <?php }?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'federal_subject',
            'forestgrow_region',
            'name',
            'full_name',
        ],
    ]) ?>

</div>
