<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\map3\models\SarchOivSubject */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ОИВ субъекта';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oiv-subject-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (\Yii::$app->user->can('admin')){ ?>
    <p>
        <?= Html::a('Создать ОИВ', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php }?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//
//            'id',
            'fed_subject',
            'name',
            'address',
            'phone',
            //'email:email',

            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'<span class="glyphicon glyphicon-cog"></span>',
                'template' => '{view} {update} {delete}', // '{view} {update} {delete}',
                'visible' => \Yii::$app->user->can('admin'),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} ' ,
                'visible' => \Yii::$app->user->can('oiv_view'),

            ]
        ],
    ]); ?>


</div>
