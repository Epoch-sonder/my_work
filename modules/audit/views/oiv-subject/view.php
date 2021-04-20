<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\map3\models\OivSubject */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Oiv Subjects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="oiv-subject-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<- к ОИВ субъекта', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'fed_subject',
            'name',
            'address',
            'phone',
            'email:email',
        ],
    ]) ?>

</div>
