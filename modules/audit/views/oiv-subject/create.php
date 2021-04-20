<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\map3\models\OivSubject */

$this->title = 'Создание ОИВ';
$this->params['breadcrumbs'][] = ['label' => 'Oiv Subjects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oiv-subject-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
