<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\FileHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\audit\models\SearchAuditExpertise */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Экспертизы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="audit-expertise-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (\Yii::$app->user->can('audit_expertise_edit')){ ?>
    <p>
        <?= Html::a('Создание экспертизы', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php }?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'fedSubjectName',
            'contract',
            'sum_contract',
            'date_start',
            'date_finish',
            [
                'label' => 'Дни',
                'value' => function($data) {
                    $dateS = $data->date_start;
                    $dateF = $data->date_finish;
                    if ($dateS != null and $dateF != null) {
                        $dateF = new \DateTime($data->date_finish);
                        $dateS = new \DateTime($data->date_start);
                        $DateAll = date_diff($dateS, $dateF);
                        $sumDate = $DateAll->d + 1;
                        $sumDateAll = $sumDate;
                        return $sumDateAll;
                    }
                    else{
                        return '';
                    }


                },
            ],
            'branchName',
            'fio',
            'participation_cost',
            [
                'attribute' => 'comment',
                'label' => 'Замечания',
                'format' => 'raw',
                'value' => function($data) {
                    if($data->comment != null){
                        $chapter_a = Html::a(
                                '<span class="glyphicon glyphicon-book"></span>',
//                            ['/lu/lu-process/index','zakup' => $key],
                                ['../audit/audit-expertise/view?id='. $data->id],
                                ['title' => 'Подробнее']);
                        return $chapter_a;
                    }
                    else{
                        return '';
                    }
                },
            ],
            [
                'attribute' => 'proposal',
//                'label' => '',
                'format' => 'raw',
                'value' => function($data) {
                    if($data->proposal != null){
                        $chapter_a = Html::a(
                            '<span class="glyphicon glyphicon-book"></span>',
//                            ['/lu/lu-process/index','zakup' => $key],
                            ['../audit/audit-expertise/view?id='. $data->id],
                            ['title' => 'Подробнее']);
                        return $chapter_a;
                    }
                    else{
                        return '';
                    }
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'<span class="glyphicon glyphicon-cog"></span>',
                'template' => '{view} {update}', // '{view} {update} {delete}',
                'visible' => \Yii::$app->user->can('audit_expertise_edit'),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}' ,
                'visible' => \Yii::$app->user->can('audit_expertise_view'),

            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}' ,
                'visible' => \Yii::$app->user->can('admin'),

            ]
        ],
    ]); ?>


</div>
