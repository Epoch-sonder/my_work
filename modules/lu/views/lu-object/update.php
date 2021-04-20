<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\LuObject */

$this->title = 'Изменение ЛУ объекта: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Lu Objects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lu-object-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <p>
        <?= Html::a('<- вернуться к закупке', ['index', 'zakup' => $model->zakup], ['class' => 'btn btn-primary']) ?>
    </p>

    <p>
        <?php

        $zakupka = app\modules\lu\models\ZakupCard::find()->where(['=', 'id', Yii::$app->request->get('zakup') ])->one();

        echo 'Закупка: ' . $zakupka->zakup_num;
        echo '<br>';
        // echo $model->fed_subject;
        echo 'Субъект РФ: ' . app\modules\lu\models\FederalSubject::find()->where(['=', 'federal_subject_id', $zakupka->fed_subject])->one()->name;
        echo '<br>';
        // echo $model->land_cat;
        echo app\modules\lu\models\Land::find()->where(['=', 'land_id', $zakupka->land_cat ])->one()->name;
        ?>
    </p>

    <h1>Объекты лесоустроительных работ:</h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'zakup',
            // 'land_cat',
            // 'landCatName',
            // 'fed_subject',
            // 'fedSubjectName',
            // 'region',
            // 'region_subdiv',
            // 'taxation_way',
            // 'taxwork_cat',
            // 'taxwork_vol',
            //'stage_prepare_vol',
            //'stage_prepare_year',
            //'stage_field_vol',
            //'stage_field_year',
            //'stage_cameral_vol',
            //'stage_cameral_year',

            [
                'attribute' => 'forestryName',
                'label' => 'Лесничество',
                'visible' => $zakupka->land_cat == 1 ? 1 : 0,
            ],
            [
                'attribute' => 'forestryDefenseName',
                'label' => 'Лесничество',
                'visible' => $zakupka->land_cat == 2 ? 1 : 0,
            ],
            [
                'attribute' => 'cityregionName',
                'label' => 'Район',
                'visible' => $zakupka->land_cat == 3 ? 1 : 0,
            ],
            [
                'attribute' => 'ooptName',
                'label' => 'ООПТ',
                'visible' => $zakupka->land_cat == 4 ? 1 : 0,
            ],
            [
                'attribute' => 'region',
                'visible' => $zakupka->land_cat == 5 ? 1 : 0,
            ],

            [
                'attribute' => 'subforestryName',
                'label' => 'уч. лесничество',
                'visible' => $zakupka->land_cat == 1 ? 1 : 0,
            ],
            [
                'attribute' => 'subforestryDefenseName',
                'label' => 'уч. лесничество',
                'visible' => $zakupka->land_cat == 2 ? 1 : 0,
            ],
            [
                'attribute' => 'region_subdiv',
                'visible' => $zakupka->land_cat == 5 ? 1 : 0,
            ],
            'taxationWayName',
            'taxworkCatName',
            'stagePrepare',
            'stageField',
            'stageCameral',

            // ['class' => 'yii\grid\ActionColumn'],

            [
                'class' => 'yii\grid\ActionColumn',
                // 'header'=>'Действия',
                // 'headerOptions' => ['width' => '80'],
                'template' => ' {update} {link}',
//                'template' => '{view} {update} {link}',
                'buttons' => [
//                    'view' => function ($url,$model) {
//                        return Html::a(
//                        '<span class="glyphicon glyphicon-eye-open"></span>',
//                        [$url . '&zakup=' . Yii::$app->request->get('zakup')]);
//                        // [$url . '&zakup=' . $zakup_id]);
//
//                    },
                    'update' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            [$url . '&zakup=' . Yii::$app->request->get('zakup')]);
                        // [$url . '&zakup=' . $zakup_id]);
                    },
//                       'link' => function ($url,$model,$id) {
//                        return Html::a(
//                        '<span class="glyphicon glyphicon-list-alt"></span>',
//                        ['/lu/lu-process/index','object' => $id ,'zakup' => Yii::$app->request->get('zakup')],
//                        ['title' => 'План график'],
//                        );
//                    },
                ],
            ],

        ],
    ]); ?>




    <h1>Изменение объекта лесоустроительных работ:</h1>

    <?= $this->render('_form', [
        'model' => $model,
        'zakupka' => $zakupka,
    ]) ?>

</div>
