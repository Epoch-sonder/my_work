<?php

use yii\helpers\Html;

$this->title = 'Изменение пароля пользователя: ' . $model->fio;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

    <h2>Пользователь <?= $model->fio ?>
    	<?= Html::a('Изменить профиль', ["update?id={$model->id}"], ['class' => 'btn btn-success']) ?>
    </h2>
    <p>(логин <?= $model->username ?>)</p>
    

    <?= $this->render('_editpass_form', [
        'model' => $model,
    ]) ?>

</div>
