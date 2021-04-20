<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\lu\models\SearchZakupCard */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Закупки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zakup-card-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (\Yii::$app->user->can('lu_zakup_edit')){?>
    <p>
        <?= Html::a('Добавить новую закупку', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php }?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'zakup_num',
            // 'zakup_link',
            // 'contest_type',
            [
              'attribute' => 'contestTypeName',
              'label' => 'Определение <br /> поставщика',
              'encodeLabel' => false,
              // 'encodeLabel' => false, // в случае использования 'label' вместо 'header', чтоб воспринимал <br>
              // в случае с 'header' не работает сортировка
            ],
            [
              'attribute' => 'date_placement',
              'label' => 'Дата <br /> размещения',
              'encodeLabel' => false,
            ],
            [
              'attribute' => 'price_start',
              'label' => 'Начальная <br /> цена',
              'encodeLabel' => false,
            ],
            // 'contract_type',
            // 'contractTypeName',
            // [
            //   'attribute' => 'contractTypeName',
            //   'label' => 'Тип <br /> контракта',
            //   'encodeLabel' => false,
            // ],
            // [
            //   'attribute' => 'contract_num',
            //   'label' => 'Номер <br /> контракта',
            //   'encodeLabel' => false,
            // ],
            //'finsource_type',
            // 'finsourceName',
            'customer_name',
            //'land_cat',
            // 'landCatName',
            // 'fed_subject',
            'fedSubjectName',
            // 'region',
            [
              'attribute' => 'region',
              'label' => 'лесничество / <br /> ООПТ / район',
              'encodeLabel' => false,
            ],
            //'region_subdiv',
            //'dzz_type',
            // 'dzzTypeName',
            //'dzz_resolution',
            //'dzz_request_sent',
            // 'dzzRequestSent',
            //'dzz_cost',
            //'smp_attraction',
            //'timestamp',

            [
                'attribute' => 'dzz_control_date',
                'label' => 'Срок <br /> получения КП',
                'encodeLabel' => false,
                'format' => 'raw',
                /**
                 * Переопределяем отображение фильтра.
                 * Задаем выпадающий список с заданными значениями вместо поля для ввода
                 */
                // 'filter' => [
                //     0 => 'Yes',
                //     1 => 'No',
                // ],
                // 'filter' => [
                //     0 => 'Просрочено',
                //     1 => 'Ожидаем',
                // ],
                /**
                 * Переопределяем отображение самих данных.
                 * Вместо 1 или 0 выводим Yes или No соответственно.
                 * Попутно оборачиваем результат в span с нужным классом
                 */
                'value' => function ($model, $key, $index, $column) {
                    if($model->dzz_control_date) {
                        $alarm = $model->dzz_control_date < date('Y-m-d');
                        return \yii\helpers\Html::tag(
                            'span',
                            $alarm ? 'Просрочено' : 'Ожидаем',
                            [
                                'class' => 'label label-' . ($alarm ? 'danger' : 'success'),
                            ]
                        ) . '<br>' . $model->dzz_control_date;
                    } 
                    else return '';
                },
            ],

            // ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update}'],

            [
                'class' => 'yii\grid\ActionColumn',
                // 'header'=>'Действия', 
                // 'headerOptions' => ['width' => '80'],
                'template' => '{update} {link} {links}',
                'visible'=>\Yii::$app->user->can('lu_zakup_edit') ,
//                'template' => '{view} {update} {link}',
                'buttons' => [
                    'link' => function ($url,$model,$key) {
                        return Html::a(
                        '<span class="glyphicon glyphicon-menu-hamburger"></span>', 
                        ['/lu/lu-object/create', 'zakup' => $key],
                        ['title' => 'Объекты']
                        );
//                    'links' => function ($model) {
//                        return Html::a(
//                        '<span class="glyphicon glyphicon-menu-hamburger"></span>',
//                        ['/lu/lu-process/index','zakup' => $model->zakup],
//                        ['title' => 'Объекты'],
//                        );
                    },
                    'links' => function ($url,$model,$key) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-list-alt"></span>',
//                            ['/lu/lu-process/index','zakup' => $key],
                            ['/lu/lu-process/', 'zakup' => $key],
                            ['title' => 'План график']
                        );
                    },

                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                // 'header'=>'Действия',
                // 'headerOptions' => ['width' => '80'],
                'template' => '{view} {link} {links}',
                'visible'=>\Yii::$app->user->can('lu_zakup_view') ,
//                'template' => '{view} {update} {link}',
                'buttons' => [
                    'link' => function ($url,$model,$key) {
                        return Html::a(
                        '<span class="glyphicon glyphicon-menu-hamburger"></span>',
                        ['/lu/lu-object/create', 'zakup' => $key],
                        ['title' => 'Объекты']
                        );
//                    'links' => function ($model) {
//                        return Html::a(
//                        '<span class="glyphicon glyphicon-menu-hamburger"></span>',
//                        ['/lu/lu-process/index','zakup' => $model->zakup],
//                        ['title' => 'Объекты'],
//                        );
                    },
                    'links' => function ($url,$model,$key) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-list-alt"></span>',
//                            ['/lu/lu-process/index','zakup' => $key],
                            ['/lu/lu-process/', 'zakup' => $key],
                            ['title' => 'План график']
                        );
                    },

                ],
            ],
        ],
    ]); ?>


</div>
