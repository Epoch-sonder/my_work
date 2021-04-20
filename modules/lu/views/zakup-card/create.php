<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\ZakupCard */

$this->title = 'Новая закупка';
$this->params['breadcrumbs'][] = ['label' => 'Zakup Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zakup-card-create">

    <?= Html::a('<- список закупок', ['index'], ['class' => 'btn btn-primary']) ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
