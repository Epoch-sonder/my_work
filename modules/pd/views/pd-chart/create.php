<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pd\models\PdWork */

$this->title = 'Новая проектная документация';
$this->params['breadcrumbs'][] = ['label' => 'Pd Works', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;



?>

<div class="pd-work-create">

    <?= Html::a('<- вернуться к общему списку', ['index'], ['class' => 'btn btn-primary']) ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'id_userCur'=>$id_userCur,
        'id_branch_curators'=>$id_branch_curators,
        'model' => $model,
    ]) ?>

</div>
