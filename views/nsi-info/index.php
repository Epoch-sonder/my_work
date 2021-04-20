<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchNsiInfo */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Информация о справочниках НСИ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nsi-info-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить новую запись', ['create'], ['class' => 'btn btn-success']) ?>

        <?= Html::a('Содержание справочников', ['nsi-content/index'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'soli_id',
            'attr_name',
            'maket_numb',
            'pole_numb',
            'winplp',
            //'pl',
            'topol',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
