<?php


use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\LuObjectProcess */

$this->title = 'Создание процесса объекта';
$this->params['breadcrumbs'][] = ['label' => 'Lu Object Processes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lu-object-process-index">
    <?= Html::a('<- вернуться к план-графику', ['../lu/lu-process/' , 'zakup' => Yii::$app->request->get('zakup')], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('<- вернуться к заполнению другого план-факта', ['../lu/lu-object-process/' , 'zakup' => Yii::$app->request->get('zakup') , 'step' => Yii::$app->request->get('step')], ['class' => 'btn btn-primary']) ?>
    <h1>Заполненые процессы объекта</h1>
    <br>
    <br>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            'id',
//            'lu_object',
//            'lu_process_step',
            [
                'attribute' => 'Month',
                'label' => 'Месяц',
            ],
            //            'year',
            'plan',
            'fact',
            //'timestamp',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => ' {update} ',
                'buttons' => [
                    'update' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            [$url . '&zakup=' . Yii::$app->request->get('zakup') . '&step=' .  Yii::$app->request->get('step')  . '&object=' . Yii::$app->request->get('object')]);
                    },
                ],
            ],
        ],
    ]); ?>


</div>
<br> <br>
<div class="lu-object-process-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
