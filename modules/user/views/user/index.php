<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\user\models\SearchUser */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список сотрудников';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
            // Позволяем менять профиль только высшим админам
            if (\Yii::$app->user->can('admin')  ) {
                echo Html::a('Создать учетную запись', ['create'], ['class' => 'btn btn-success']) . ' ';
                echo Html::a('Настроить доступ сотруднику', ['create-permission'], ['class' => 'btn btn-primary']) . ' ';
                echo Html::a('Создать роль/Настроить разрешения', ['create-role-permission'], ['class' => 'btn btn-primary']);
            }
        ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 

    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            'fio',
            // [
            //     'attribute' => 'Fio',
            //     'label' => 'Имя сотрудника',
            //     'value' => 'fio',
            // ],
            'branchName',
            // [
            //     'attribute' => 'BranchName',
            //     'label' => 'Филиал',
            //     'value' => 'branch.name',
            // ],
            'phone',
            'username',
            //'password',
            'roleName',
			// [
   //              'attribute' => 'RoleName',
   //              'label' => 'Роль',
   //              'value' => 'role.name',
			// ],
            //'role',
            //'branch_id',
            //'position',
            //'fio',
            // 'enabled',
            [
                'attribute' => 'Еnabled',
                'label' => 'Вкл',
                'value' => 'enabled',
            ],

            [
                'class' => ActionColumn::className(),
                'template' => '{view}', 
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => 'Подробная информация о сотруднике',
                            'data-pjax' => '0',
                        ]);
                    },
                    // 'delete' => function ($url, $model, $key) {
                    //     return Html::a('<span class="glyphicon glyphicon-remove"></span>', $url, [
                    //         'title' => Yii::t('yii', 'Удалить'),
                    //         'data-confirm' => 'Вы действительно хотите удалить профиль сотрудника?',
                    //         'data-method' => 'post',
                    //         'data-pjax' => '0',
                    //     ]);
                    // },
                ],
                'visible' => \Yii::$app->user->can('user_view') ,
			],
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {update}', 
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => 'Подробная информация о сотруднике',
                            'data-pjax' => '0',
                        ]);
                    },
                ],
                'visible' => \Yii::$app->user->can('admin'),
            ],


            

        ],
    ]); ?>


</div>
