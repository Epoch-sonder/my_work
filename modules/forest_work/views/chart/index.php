<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\SeriesDataHelper ;

$this->title = 'Отчеты - информация о выполнении работ по разработке проектов освоения лесов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forest-work-index">

    <p>
        <?= Html::a('Добавить отчет', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Инструкция', ['instruction-pol'], ['class' => 'btn btn-danger']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'branchName',
                'label' => 'Филиал',
            ],
            // [
            //     'attribute' => 'branch_id',
            //     'label' => 'Филиал',
            //     'value' => 'branch.name',
            // ],
			[
                'attribute' => 'fedSubjectName',
                'label' => 'Субъект',
            ],
            // [
            //     'attribute' => 'federal_subject_id',
            //     'label' => 'Субъект',
            //     'value' => 'federalSubject.name',
            // ],
            'date',
            [
                'attribute' => 'reporterName',
                'label' => 'Сотрудник',
            ],
			// [
   //              'attribute' => 'reporter',
   //              'label' => 'Сотрудник',
   //              'value' => 'user.fio',
   //          ],
            //'timestamp',
     
			[
			'format' => 'html',
			'value' => function ($url) {
				return Html::a('подробнее &raquo;', ['view', 'id' => $url->id], ['class' => 'btn btn-success']);
        },
			],

			//['class' => 'yii\grid\ActionColumn'],
			
			
        ],
    ]); 







// foreach ($plotdepend as $plotdepends){
//     $note = $plotdepends["$nameUn"];
// };

// echo '<pre>';
// var_dump($nameSort[0]);
// echo '</pre>';
     for ($fi = 0; $fi < count($nameSort); $fi++){
         $gg[$fi]['name'] = $nameSort[$fi];
         $gg[$fi]['dataLabels'] = ['enabled' => true];
         $gg[$fi]['data'] = $plotdepend["$nameSort[$fi]"];
     }

    echo '<pre>';
    var_dump ($gg);
    echo '</pre>';

if ($branchID != 0){
$plot = Highcharts::widget([
   'options' => [
        'chart' => [
            'height' => 450,
            'width' => 1000,
            'borderWidth' => 1,
            'borderColor' => '#000',
        ],
        'title' => ['text' => "$branchName"],
        'subtitle' => ['text' => 'Проекты освоения лесов'], 
        'credits' => ['enabled' => false],
        'xAxis' => [
            'type' => 'datetime',
            'title' => ['text' => 'Время'],
        ],
        'yAxis' => [
           'title' => ['text' => 'Количество проектов'],
             ],
        'legend' => [
            'align' => 'center',
            'borderWidth' => 1,
        ],
        'series' => $gg,

    ]
]);    

echo '<hr>';
echo $plot; 
}
//var_dump($nameSort)




    ?>

			  </div>

            
