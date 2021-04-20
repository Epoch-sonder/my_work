<?php
use miloschuman\highcharts\Highcharts;
$this->title = 'ЕЦИС Лесной кластер';
?>
<div class="site-index">

 <style type="text/css">
   #w3, #w4{
        width: 49%;
        display: inline-block; 
        float: left;
    }
   #w4{
        width: 49%;
        display: inline-block; 
        float: right;
    }
</style>


    <div class="body-content">



        <div class="row">
            <div class="col-lg-12" style="text-align: center;">
                <br><br><br><br>
                <h2>Производственные показатели деятельности <br> ФГБУ «Рослесинфорг»</h2>
                <br>

                <!-- <p>Для начала работы необходимо выполнить <a href="http://192.168.8.42/site/login">вход в систему</a> и выбрать раздел в левом меню.</p> -->

<?php
               /* if(Yii::$app->user->isGuest) { 
                    //echo '<p>Для начала работы необходимо выполнить <a href="http://192.168.8.42/site/login">вход в систему</a> и выбрать раздел в левом меню.</p>';
                } else {
                  //  echo '<p>Для начала работы необходимо выбрать раздел в левом меню.</p>';
                }*/

                /* 
                */


//вертикальная диаграмма
$vertik = Highcharts::widget ([
        'options' => [
        'chart' => ['height' => 700],
        'title' => ['text' => ''],
        'credits' => ['enabled' => false],
        'xAxis' => ['categories' => $name],
        'yAxis' => [
            'min' => 0,
            'title' => ['text' => 'Количество проектов']
            ],
            
        'legend' => [
            'reversed' => true,
            'verticalAlign' => 'top',
            'align' => 'left',
            'x' => 155,
          ],
        'plotOptions' => ['series' => ['stacking' => 'normal']],
        'series' => [
            [
                'type' => 'bar',
                'name' => 'В работе',
                'data' => $docw,
                'color' => '#98FB98'
            ],
            [
                'type' => 'bar',
                'name' => 'Завершенно',
                'data' => $docc,
                'color' => '#696969'
            ]           
            
        ]

    ]

]);

echo $vertik; //вывод диаграммы 

//столбцатый график по датам заполнения договоров
$bar = Highcharts::widget([
    'options' => [
        'chart' => ['type' => 'column'],
        'title'=> ['text' => 'График заключения договоров'],
        'credits' => ['enabled' => false],
        'xAxis' => [
            'categories' => $dataOneChange,
            //'crosshair' => true
        ],
        'yAxis' => [
            'min' => 0,
            'title' => ['text' => 'Количество проектов']
        ],
        'tooltip' => [
            'shared' => true,
            'useHTML' => true
        ],
        'plotOptions' => [
            'column' => [
                'pointPadding' => 0,
                'groupPadding' => 0.1,
                'borderWidth' => 0
            ]
        ],
        'series'=> [
            [
                'name' => 'Количество проектов',
                'data' => $quantity,
                'color' => '#32CD32'

            ],
        ],
    ]
]);

echo '<hr>';
echo $bar;

$plotEconom = Highcharts::widget([
   'options' => [
        'title' => ['text' => 'Показатели трудозатрат Учереждения'],
        'credits' => ['enabled' => false],
        'xAxis' => [
            'type' => 'datetime',
            'title' => ['text' => 'Время'],
        ],
        'yAxis' => [
           'title' => ['text' => 'Количество проектов'],
             ],
        'series' => [
            [
                'name' => 'Объемы трудозатрат в количестве проектов',
                'dataLabels' => ['enabled' => true],
                'data' => $depension,
                'color' => '#32CD32'
            ],
        ],
    ]
]); 

echo '<hr>';
echo $plotEconom;

//График с разработанной проектной документацией в текущем году
/*if ($ttl_lp || $ttl_lhr || $ttl_pol || $ttl_other) {
               
$round = Highcharts::widget ([
   'options' => [
        'chart' => [
            'height' => 400,
        ],           
        'title' => ['text' => $titleName],
        'subtitle' => ['text' =>  "Структура проектной документации <br> Всего $ttl_pd"], 
        'credits' => ['enabled' => false],
        'plotOptions' => [
           'pie' => [
               'allowPointSelect' => true,
               'cursor' => 'pointer',
               'dataLabels' => ['enabled' => false],
               'showInLegend' => true,
            ]
        ],
       'legend' => [
           'align' => 'center',
           'width' => 300,
           'borderWidth' => 1,
        ],    
       'series' => [
            [
               'name' => 'Количество документации',
               'type' => 'pie',
               'colorByPoint' => true,
               'data' =>[    
                    [
                       'name' => 'Лесные планы',
                       'y' => $ttl_lp,
                       'color' => '#C0C0C0'
                    ],
                    [
                       'name' => 'Лесохозяйственные регламенты',
                       'y' => $ttl_lhr,
                       'color' => '#FF0'
                    ],
                    [
                        'name' => 'Проекты освоения лесов',
                        'y' => $ttl_pol,
                        'color' => '#008000'                  
                    ],
                    [
                        'name' => 'Иная документация',
                        'y' => $ttl_other,
                        'color' => '#F00'                    
                    ],
                ],
            ],
        ],
    ],
]);
    echo '<hr>';
    echo '<hr>';
    echo $round;
}*/
 
echo '<hr>';
echo  "<h3>Выполняемый объём работ</h3>";
echo "<h5>(по лесничествам)</h5>";
echo "<h4>Всего ".$ttlinw_pd."</h4>";
echo '<hr>';

if ($ttlinw_lp || $ttlinw_lhr || $ttlinw_pol || $ttlinw_other) {

    //$titleName = 'В работе сейчас'; 

$roundinw = Highcharts::widget ([
   'options' => [
        'chart' => [
            'height' => 600,
        ],
        'title' => ['text' => 'Виды документации'], 
       // 'subtitle' => ['text' =>  "Структура проектной документации <br> Всего $ttlinw_pd"],
        'credits' => ['enabled' => false],
        'plotOptions' => [
           'pie' => [
               'allowPointSelect' => true,
               'cursor' => 'pointer',
               'dataLabels' => ['enabled' => false],
               'showInLegend' => true
            ]
        ],
       'legend' => [
           'align' => 'center',
           'width' => 550,
           'borderWidth' => 1,
        ],    
       'series' => [
            [
               'name' => 'Количество документации',
               'type' => 'pie',
               'colorByPoint' => true,
               'data' =>[    
                    [
                       'name' => $pdtypework[1],
                       'y' => $ttlinw_lp,
                       'color' => '#C0C0C0'
                    ],
                    [
                       'name' => $pdtypework[2],
                       'y' => $ttlinw_lhr,
                       'color' => '#FF0'
                    ],
                    [
                        'name' => $pdtypework[3],
                        'y' => $ttlinw_dlu,               
                    ],
                    [
                        'name' => $pdtypework[4],
                        'y' => $ttlinw_pol,
                        'color' => '#008000'                  
                    ],
                    [
                        'name' => $pdtypework[5],
                        'y' => $ttlinw_rnz,                
                    ],
                    [
                        'name' => $pdtypework[6],
                        'y' => $ttlinw_ld,               
                    ],
                    [
                        'name' => $pdtypework[7],
                        'y' => $ttlinw_useles,                
                    ],
                    [
                        'name' => $pdtypework[8],
                        'y' => $ttlinw_plv,                
                    ],
                    [
                        'name' => $pdtypework[9],
                        'y' => $ttlinw_pincl,                
                    ],
                    [
                        'name' => $pdtypework[10],
                        'y' => $ttlinw_ozu,                
                    ],
                    [
                        'name' => $pdtypework[11],
                        'y' => $ttlinw_puglz,                
                    ],
                    [
                        'name' => $pdtypework[12],
                        'y' => $ttlinw_ulpzp,       
                    ],
                    [
                        'name' => $pdtypework[13],
                        'y' => $ttlinw_ppt,       
                    ],
                    [
                        'name' => $pdtypework[14],
                        'y' => $ttlinw_pmt,       
                    ],
                    [
                        'name' => $pdtypework[15],
                        'y' => $ttlinw_transfer,       
                    ],
                    [
                        'name' => $pdtypework[16],
                        'y' => $ttlinw_kip,       
                    ],
                    [
                        'name' => $pdtypework[17],
                        'y' => $ttlinw_fireprev,       
                    ],
                    [
                        'name' => $pdtypework[18],
                        'y' => $ttlinw_hunt,       
                    ],
                    [
                        'name' => $pdtypework[19],
                        'y' => $ttlinw_oopt,       
                    ],
                    [
                        'name' => $pdtypework[20],
                        'y' => $ttlinw_prup,       
                    ],
                    [
                        'name' => $pdtypework[21],
                        'y' => $ttlinw_ovos,       
                    ],
                    [
                        'name' => $pdtypework[22],
                        'y' => $ttlinw_szz,       
                    ],
                    [
                        'name' => $pdtypework[23],
                        'y' => $ttlinw_pdv,       
                    ],
                    [
                        'name' => $pdtypework[24],
                        'y' => $ttlinw_pnoolr,       
                    ],
                    [
                        'name' => $pdtypework[25],
                        'y' => $ttlinw_other,
                        'color' => '#F00'                    
                    ],
                ],
            ],
        ],
    ],
]);

  //  echo '<hr>';
    echo $roundinw;
}

//круговая диаграмма по видам использовния
$roundType = Highcharts::widget ([
    'options' => [
       'chart' => ['height' => 600],
        'title' => ['text' => 'Виды использования лесов'],
        'credits' => ['enabled' => false],
        'plotOptions' => [
            'pie' => [
                'allowPointSelect' => true,
                'cursor' => 'pointer',
                'dataLabels' => ['enabled' => false],
                'showInLegend' => true
                ]
         ],
         'legend' => [
            //'layout' => 'vertical',
            'align' => 'center',
            'borderWidth' => 1,
            //'height' => 300,
            'width' => 500,
            // 'x' => -150,
            //'y' => 15
            ],    
        'series' => [
            [
                'name' => 'Количество проектов',
                'type' => 'pie',
                'colorByPoint' => true,
                'data' => [
                    $plotmassiv[1], 
                    $plotmassiv [2],
                    $plotmassiv [3],
                    $plotmassiv [4],
                    $plotmassiv [5],
                    $plotmassiv [6],
                    $plotmassiv [7],
                    $plotmassiv [8],
                    $plotmassiv [9],
                    $plotmassiv [10],
                    $plotmassiv [11],
                    $plotmassiv [12],
                    $plotmassiv [13],
                    $plotmassiv [14],
                    $plotmassiv [15],
                    $plotmassiv [16],
                    $plotmassiv [17]
                ],            
            ],
        ],
    ],
]);

//echo '<hr>';
echo $roundType;
                
?>

            </div>

           <!-- <div class="col-lg-4">
                <h2>Задача проекта №1</h2>

                <p>Формирование единой и централизованной производственной базы данных потенциальных заказчиков из числа лесопользователей, 
				для которых филиалами ФГБУ «Рослесинфорг» ранее были разработаны проекты освоения лесов, а также осуществление взаимодействия 
				с арендаторами лесных участков, контактные данные которых находятся в открытом доступе.</p>

            </div>
            <div class="col-lg-4">
                <h2>Разработка</h2>

                <p>Проект разрабатывается на принципиально новой базе и платформе которая базируется на объектно-ориентированной модели фреймворка YII2. 
				Для созданиия проекта использованы технологии <strong>MYSQL/PHP/JSON/JS/HTML/CSS/BOOTSTRAP</strong>, что дает непревзойденную гибкость в разработке и 
				достижении поставленных задач. Производственная база данных призвана быть общедоступной как для центрального аппарата так и для всех
				филиалов ФГБУ "Рослесинфорг".</p>

            </div>
            <div class="col-lg-4">
			<h2>Задача проекта №2</h2>

                <p>Осуществление контроля по взаимодействию с лесопользователями, действие проектной документации которых истекает, 
				с целью своевременного заключения нового договора на выполнение соответствующих работ, прописанных в контракте.</p>

            </div> -->
        </div>


    </div>
</div>
