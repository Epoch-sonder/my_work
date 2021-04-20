<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->fio;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
            // Позволяем менять профиль только высшим админам
            if ( !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id <= '2' ) {
                echo Html::a('Изменить профиль', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
            }
        ?>
        
        <?php //echo Html::a('Удалить', ['delete', 'id' => $model->id], [
        //     'class' => 'btn btn-danger',
        //     'data' => [
        //         'confirm' => 'Вы уверены, что хотите удалить профиль?',
        //         'method' => 'post',
        //     ],
        // ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'role.name',
            'branch.name',
            'position',
            'fio',
            'phone',
			'email',
            'enabled',
        ],
    ]) ?>

</div>
