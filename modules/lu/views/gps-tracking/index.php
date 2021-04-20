<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\lu\models\SearchGpsTracking */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gps-трекинг';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gps-tracking-index">

    <h1><?= Html::encode($this->title) ?></h1>
        <p>
    <?php if (\Yii::$app->user->can('gps_edit'))
            echo Html::a('Создать gps-трекинг', ['create'], ['class' => 'btn btn-success']);?>
            <span class="btn  btn-info">Легенда</span>
        </p>
    <div style="background: #f6f5f5;border-radius: 25px; max-width: 43%;margin-left:0" class="row legend">
        <div class=" col-sm-12"><h3>Легенда</h3></div>

        <div class="col-sm-4" style="margin-bottom: 10px">Знак/слово</div>
        <div class="col-sm-8"  style="margin-bottom: 10px">Обозначение</div>

         <div class="col-sm-4"><span style="color:green" class="glyphicon glyphicon-ok"></span></div>
         <div class="col-sm-8">Данные проверены</div>
         <div class="col-sm-4"><span style="color:red" class="glyphicon glyphicon-remove"></span></div>
         <div class="col-sm-8">Данные НЕ проверены</div>
         <div class="col-sm-4" style="margin-bottom: 20px">Руководитель п.г.</div>
         <div class="col-sm-8" style="margin-bottom: 20px">Руководитель полевой группы</div>
        <br>
    </div>




    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'branchName',
            'contractName',
//            'contract',
             'partyLeaderName',

            'specialistName',

            [

                'attribute' => 'april_recd',
                'headerOptions' => ['class' => 'april'],
                'format' => 'raw',
                'value' => function($data) use($arrayMonth){
                    if ($data->april_recd){
                        $date = new \DateTime($data->april_recd);
                        $dateD = $date->format('d');
                        $dateM = $date->format('m');
                        $dateM *=1;
                        $dateY = $date->format('Y');
                        $dateM = $arrayMonth[$dateM];
                        return '<div style="white-space: nowrap;">'.$dateD.'&nbsp;'.$dateM.'&nbsp;'.$dateY.($data->april_check ?'&nbsp;<span style="color:green;display: contents" title="Проверено" class="glyphicon glyphicon-ok"></span>':' <span style="color:red;display: contents" title="Не проверено" class="glyphicon glyphicon-remove"></span>').'</div>';

                    }
                    return '';
                },
            ],
            [
                'attribute' => 'may_recd',
                'format' => 'raw',
                'value' => function($data) use($arrayMonth){
                    if ($data->may_recd){
                        $date = new \DateTime($data->may_recd);
                        $dateD = $date->format('d');
                        $dateM = $date->format('m');
                        $dateM *=1;
                        $dateY = $date->format('Y');
                        $dateM = $arrayMonth[$dateM];
                        return '<div style="white-space: nowrap;">'.$dateD.'&nbsp;'.$dateM.'&nbsp;'.$dateY.($data->may_check ?'&nbsp;<span style="color:green;display: contents" title="Проверено" class="glyphicon glyphicon-ok"></span>':' <span style="color:red;display: contents" title="Не проверено" class="glyphicon glyphicon-remove"></span>').'</div>';

                    }
                    return '';
                },
            ],
            [
                'attribute' => 'june_recd',
                'format' => 'raw',
                'value' => function($data) use($arrayMonth){
                    if ($data->june_recd){
                        $date = new \DateTime($data->june_recd);
                        $dateD = $date->format('d');
                        $dateM = $date->format('m');
                        $dateM *=1;
                        $dateY = $date->format('Y');
                        $dateM = $arrayMonth[$dateM];
                        return '<div style="white-space: nowrap;">'.$dateD.'&nbsp;'.$dateM.'&nbsp;'.$dateY.($data->june_check ?'&nbsp;<span style="color:green;display: contents" title="Проверено" class="glyphicon glyphicon-ok"></span>':' <span style="color:red;display: contents" title="Не проверено" class="glyphicon glyphicon-remove"></span>').'</div>';

                    }
                    return '';
                },
            ],

            [
                'attribute' => 'july_recd',
                'format' => 'raw',
                'value' => function($data) use($arrayMonth){
                    if ($data->july_recd){
                        $date = new \DateTime($data->july_recd);
                        $dateD = $date->format('d');
                        $dateM = $date->format('m');
                        $dateM *=1;
                        $dateY = $date->format('Y');
                        $dateM = $arrayMonth[$dateM];
                        return '<div style="white-space: nowrap;">'.$dateD.'&nbsp;'.$dateM.'&nbsp;'.$dateY.($data->july_check ?'&nbsp;<span style="color:green;display: contents" title="Проверено" class="glyphicon glyphicon-ok"></span>':' <span style="color:red;display: contents" title="Не проверено" class="glyphicon glyphicon-remove"></span>').'</div>';

                    }
                    return '';
                },
            ],

            [
                'attribute' => 'august_recd',
                'format' => 'raw',
                'value' => function($data) use($arrayMonth){
                    if ($data->august_recd){
                        $date = new \DateTime($data->august_recd);
                        $dateD = $date->format('d');
                        $dateM = $date->format('m');
                        $dateM *=1;
                        $dateY = $date->format('Y');
                        $dateM = $arrayMonth[$dateM];
                        return '<div style="white-space: nowrap;">'.$dateD.'&nbsp;'.$dateM.'&nbsp;'.$dateY.($data->august_check ?'&nbsp;<span style="color:green;display: contents" title="Проверено" class="glyphicon glyphicon-ok"></span>':' <span style="color:red;display: contents" title="Не проверено" class="glyphicon glyphicon-remove"></span>').'</div>';

                    }
                    return '';
                },
            ],

            [
                'attribute' => 'september_recd',
                'format' => 'raw',
                'value' => function($data) use($arrayMonth){
                    if ($data->september_recd){
                        $date = new \DateTime($data->september_recd);
                        $dateD = $date->format('d');
                        $dateM = $date->format('m');
                        $dateM *=1;
                        $dateY = $date->format('Y');
                        $dateM = $arrayMonth[$dateM];
                        return '<div style="white-space: nowrap;">'.$dateD.'&nbsp;'.$dateM.'&nbsp;'.$dateY.($data->september_check ?'&nbsp;<span style="color:green;display: contents" title="Проверено" class="glyphicon glyphicon-ok"></span>':' <span style="color:red;display: contents" title="Не проверено" class="glyphicon glyphicon-remove"></span>').'</div>';

                    }
                    return '';
                },
            ],
            [
                'attribute' => 'october_recd',
                'format' => 'raw',
                'value' => function($data) use($arrayMonth){
                    if ($data->october_recd){
                        $date = new \DateTime($data->october_recd);
                        $dateD = $date->format('d');
                        $dateM = $date->format('m');
                        $dateM *=1;
                        $dateY = $date->format('Y');
                        $dateM = $arrayMonth[$dateM];
                        return '<div style="white-space: nowrap;">'.$dateD.'&nbsp;'.$dateM.'&nbsp;'.$dateY.($data->october_check ?'&nbsp;<span style="color:green;display: contents" title="Проверено" class="glyphicon glyphicon-ok"></span>':' <span style="color:red;display: contents" title="Не проверено" class="glyphicon glyphicon-remove"></span>').'</div>';

                    }
                    return '';
                },
            ],
            [
                'attribute' => 'november_recd',
                'format' => 'raw',
                'value' => function($data) use($arrayMonth){
                    if ($data->november_recd){
                        $date = new \DateTime($data->november_recd);
                        $dateD = $date->format('d');
                        $dateM = $date->format('m');
                        $dateM *=1;
                        $dateY = $date->format('Y');
                        $dateM = $arrayMonth[$dateM];
                        return '<div style="white-space: nowrap">'.$dateD.'&nbsp;'.$dateM.'&nbsp;'.$dateY.($data->november_check ?'&nbsp;<span style="color:green;display: contents" title="Проверено" class="glyphicon glyphicon-ok"></span>':' <span style="color:red;display: contents" title="Не проверено" class="glyphicon glyphicon-remove"></span>').'</div>';

                    }
                    return '';
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'<span class="glyphicon glyphicon-cog"></span>',
                'template' =>  '{update} {view} {delete} ',
                'buttons' => [
                    'delete' => function ($url,$model) {
                    if (\Yii::$app->user->can('admin'))
                       return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url);
                    else
                        return '';
                    },
                ],
                'visible' =>  \Yii::$app->user->can('gps_edit'),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'<span class="glyphicon glyphicon-cog"></span>',
                'template' => '{view}',
                'visible' =>  \Yii::$app->user->can('gps_view') or \Yii::$app->user->can('gps_check'),
            ],
        ],
    ]); ?>
<!--    <div class="strela" style="display: none;" >-->
<!--        <span style="color:red; font-size: 50px;transform: rotate(15deg);position: absolute;" class="strela glyphicon glyphicon-arrow-down"></span>-->
<!--        <div style="position: absolute;" class="strela_text"> Здесь все для того чтобы вы отдыхали </div>-->
<!--    </div>-->


</div>
<?php
$js = <<<JS
    $('.btn-info').on('click',function (){
        $('.legend').slideToggle();
    })
    $('.legend').css('display','none')
    // $('.btn-info').on('click',function (){
    //     var top = $('.april').offset().top - 55;
    //     var left = $('.april').offset().left + 20;
    //     $('.strela').css('display','block').css('top',top).css('left',left)
    //     $('.strela_text').css('display','block').css('top',top-24).css('left',left+50)
    // })
    // $(window).resize(function() {
    //     $('.strela').css('display','none')
    // });
    //legend//

JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($js, yii\web\View::POS_END);
?>