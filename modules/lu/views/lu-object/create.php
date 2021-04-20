<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\LuObject */

$this->title = 'Добавление объекта ЛУ работ';
$this->params['breadcrumbs'][] = ['label' => 'Lu Objects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lu-object-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <p>
        <?= Html::a('<- список закупок', ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Перейти к план-графику', ['../lu/lu-process/' , 'zakup' => Yii::$app->request->get('zakup')], ['class' => 'btn btn-primary']) ?>



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
                'visible'=>\Yii::$app->user->can('lu_object_edit') ,
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
<?php if(\Yii::$app->user->can('lu_object_edit') ){?>
<br>
    <h1>Новый объект лесоустроительных работ:</h1>

    <?= $this->render('_form', [
        'model' => $model,
        'zakupka' => $zakupka,
    ]) ?>
    <?php } ?>
</div>
<?php

$js = <<<JS

$('#luobject-taxation_way').val('');
$('#luobject-region').val('');
$('#luobject-taxwork_cat').val('');
$('#luobject-taxwork_vol').val('');
$('#luobject-stage_prepare_vol').val('');
$('#luobject-stage_prepare_year').val('');
$('#luobject-stage_field_vol').val('');
$('#luobject-stage_field_year').val('');
$('#luobject-stage_cameral_vol').val('');
$('#luobject-stage_cameral_year').val('');

changeLes(subId , landCatId)

JS;

$this->registerJs($js, yii\web\View::POS_END);
?>