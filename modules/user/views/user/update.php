<?php

use yii\helpers\Html;

$this->title = 'Данные сотрудника: ' . $model->fio;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

    <h1>
    	<?= Html::encode($this->title) ?>
    	<?= " (". $model->username . ")" ?>
    	<?= Html::a('Изменить пароль', ["update-password?id={$model->id}"], ['class' => 'btn btn-success']) ?>
    </h1>

    <?= $this->render('_edit_form', [
        'model' => $model,
    ]) ?>

</div>
