<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\lu\models\SearchLuObject */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Объекты ЛУ работ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lu-object-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<- список закупок', ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Добавить объект ЛУ', ['create', 'zakup' => $zakup_id], ['class' => 'btn btn-success']) ?>
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

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        // 'rowOptions' => function ($model, $key, $index, $grid)
        // {
        //   if($model->date < date('Y-m-d')) {
        //       return ['class' => 'red'];
        //   }
        // },
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'zakup',
            // 'land_cat',
            // 'landCatName',
            // 'fed_subject',
            // 'fedSubjectName',
            // [
            // 'attribute' => 'region',
            // 'visible' => 0, // $condition,
            // ],
            // 'region',
            
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

            // 'region_subdiv',
            [
            'attribute' => 'subforestryName',
            'label' => 'уч. лесничество',
            'visible' => $zakupka->land_cat == 1 ? 1 : 0,
            // 'contentOptions' => ['class' => 'date'],
            ],
            [
            'attribute' => 'subforestryDefenseName',
            'label' => 'уч. лесничество',
            'visible' => $zakupka->land_cat == 2 ? 1 : 0,
            // 'contentOptions' => ['class' => 'date'],
            ],
            [
            'attribute' => 'region_subdiv',
            'visible' => $zakupka->land_cat == 5 ? 1 : 0,
            ],
            // 'taxation_way',
            'taxationWayName',
            // [
            //     /** Название поля модели */
            //     'attribute' => 'taxwork_cat',
            //     /** Формат вывода. * В этом случае мы отображает данные, как передали.
            //      * По умолчанию все данные прогоняются через Html::encode()  */
            //     'format' => 'raw',
            //     /*** Переопределяем отображение фильтра. * Задаем выпадающий список с заданными значениями вместо поля для ввода */
            //     'filter' => [
            //         1 => 'Первый',
            //         2 => 'Второй',
            //         3 => 'Третий',
            //     ],
            // ],
            // 'taxwork_cat',
            'taxworkCatName',
            // 'taxwork_vol',
            // 'stage_prepare_vol',
            // 'stage_prepare_year',
            // 'stage_field_vol',
            // 'stage_field_year',
            // 'stage_cameral_vol',
            // 'stage_cameral_year',
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
//                     'link' => function ($url,$model,$id) {
//                        return Html::a(
//                        '<span class="glyphicon glyphicon-list-alt"></span>',
//                        ['/lu/lu-process/index','zakup' => Yii::$app->request->get('zakup')],
//                            ['title' => 'План график']
//                        );
//                    },
                ],
            ],

        ],
    ]); ?>


</div>
