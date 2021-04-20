<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pd\models\SearchPdWorkProcess */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Отчет о ходе работ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pd-work-process-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?php
            // $service = Service::findOne($id); 
            if(isset($pdwork)) {
                echo 'ПД: ' . $pdwork->pdworktype->work_name 
                . '<br>Филиал: ' . $pdwork->branchname->name 
                . '<br>Заказчик: ' . $pdwork->customer
                . '<br>' . $pdwork->docName->doctype . ' ' . $pdwork->basedoc_name . ' от ' . $pdwork->basedoc_datasign;
            }
        ?>
    </p>

    <p>
        <?php

            $request = Yii::$app->request;
            // $pdwork_id = $request->post('pd_work');
            $pdwork_id = $request->get('pd_work');

            // Добавляем стадию для проектной документации только если указан айдишник этой документации в GET-запросе
            if ($pdwork_id) {
                echo Html::a('Добавить стадию', ['create', 'pd_work' => $pdwork_id], ['class' => 'btn btn-success']);
                // echo Html::a('Добавить отчет', ['create'], ['class' => 'btn btn-success', 
                    // 'data-method' => 'POST', 'data-params' => ['pd_work' => $pdwork_id]]);
            }
        ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'pd_work',
            // [
            //     'attribute' => 'pd_work',
            //     'label' => 'Проектная документация',
            // ],
            'report_date',
            'pd_object',
            // 'pd_step',
            [
                'attribute' => 'pdStep.step_name',
                'label' => 'Этап работ',
            ],
            'step_startplan',
            'step_finishplan',
            // 'progress_status',
            // [
            //     'attribute' => 'progress_status',
            //     'label' => 'Стадия выполнения этапа',
            // ],
            // 'comment',
            [
                'attribute' => 'comment',
                'label' => 'Описание',
            ],
            // 'resultdoc_name',
            // 'resultdoc_num',
            // 'resultdoc_date',
            // 'resultdoc_file',
            // 'person_responsible',
            [
                'attribute' => 'person.fio',
                'label' => 'Отв. лицо',
            ],
            // 'timestamp',

            // ['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'Действия', 
                'template' => '{view} {update}',
                'buttons' => [
                    'view' => function ($url) {
                        return Html::a(
                        '<span class="glyphicon glyphicon-eye-open"></span>', 
                        [$url . '&pd_work=' . Yii::$app->request->get('pd_work')]);
                        
                    },
                    'update' => function ($url) {
                        return Html::a(
                        '<span class="glyphicon glyphicon-pencil"></span>', 
                        [$url . '&pd_work=' . Yii::$app->request->get('pd_work') ]);
                    },
                ],
            ],
        ],
    ]); 

    ?>


</div>
