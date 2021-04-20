<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pd\models\PdWork */

$this->title = 'Изменение проектной документации: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Проектная документация', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$pd_url = Yii::$app->session->get('pd_url');
?>
<div class="pd-work-update">

    <a href="<?=$pd_url?>" class="btn btn-primary"><- к общему списку</a>
    <?= Html::a('к отчётам ->', ['/pd/pd-work-process/create', 'pd_work' => Yii::$app->request->get('id')], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Создать дубликат карточки', ['create', 'id'=>$model->id], ['class' => 'btn btn-success']) ?>



    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'id_userCur'=>$id_userCur,
        'id_branch_curators'=>$id_branch_curators,
        'model' => $model,
    ]) ?>

</div>
