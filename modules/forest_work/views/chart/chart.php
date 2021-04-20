<?php

use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;

?>



<div class="forest-work-index">


<?php

echo "<hr style='background: #88C86F;'>";



    // Создаем свой многомерный массив
// $ar = [];
// $ar = ["type" => "FeatureCollection"];
// $ar[12][2]['first'] = 44;
// $ar[12][2]['second'] = 13;
// $ar[12][2]['third'] = [[3, 5], [1, 6]];

// echo "<pre>";
// var_dump($ar);
// echo "</pre>";

    // Меняем некоторые значения элементов, следим за их зименением
// echo "Значение [12][2]['first'](44): ". $ar[12][2]['first'];
// $ar[12][2]['first'] = 45;
// echo "<br>";
// echo "Значение [12][2]['first'](45): ". $ar[12][2]['first'];
// echo "<br>";

    // Запаковываем массив в json-объект и выводим его
// $arjson = json_encode($ar);
// echo $arjson;
// echo "<br>";




// Чтение данных из JSON-файла
$f_json = 'docs/1902.07.001-01.geojson'; // http://192.168.8.42/docs/1902.07.001-01.geojson
$jsondata = file_get_contents("$f_json");

    // преобразуем строку, полученную из файла, в объект
$json = json_decode($jsondata,true);
    // В случае ошибки при декодировании содержимого json-файла узнаем суть ошибки
    // например, при синтаксической ошибке исходного .json json_decode() возвращает NULL
// echo "Ошибки при создании JSON-объекта из файла: ";
// switch (json_last_error()) {
//     case JSON_ERROR_NONE:
//         echo 'Ошибок нет';
//     break;
//     case JSON_ERROR_DEPTH:
//         echo 'Достигнута максимальная глубина стека';
//     break;
//     case JSON_ERROR_STATE_MISMATCH:
//         echo 'Некорректные разряды или несоответствие режимов';
//     break;
//     case JSON_ERROR_CTRL_CHAR:
//         echo 'Некорректный управляющий символ';
//     break;
//     case JSON_ERROR_SYNTAX:
//         echo 'Синтаксическая ошибка, некорректный JSON';
//     break;
//     case JSON_ERROR_UTF8:
//         echo 'Некорректные символы UTF-8, возможно неверно закодирован';
//     break;
//     default:
//         echo 'Неизвестная ошибка';
//     break;
// }

echo "<br>";


    // Распечатываем полученный массив
//echo "<pre>";
//var_dump($json);
//echo "</pre>";

    // Изменяем необходимые параметры объекта и добавляем при необходимости новые свойства
// $json["type"] = "Mytype";
// $json["features"][0]["type"] = "Mytype mfck";
// $json["features"][0]["properties"]["ULN"] = "Новое участковое";
// $json["features"][0]["properties"]["NewParameter"] = "Мой добавленный параметр";
    // добавляем параметры, которых не было
$json["features"][0]["properties"]["ULN_KOD"] = "07";
$json["features"][0]["properties"]["LN"] = "Бабаевское";
$json["features"][0]["properties"]["LN_KOD"] = "02";
$json["features"][0]["properties"]["SUB"] = "Вологодская область";
$json["features"][0]["properties"]["SUB_KOD"] = "19";

echo "<br>";

    // Распечатываем измененный массив, видим разницу
//echo "<pre>";
//var_dump($json);
//echo "</pre>";

    // Кодируем массив в объект JSON и сохраняем его в файл
    // http://192.168.8.42/docs/updated.geojson
    // опция JSON_UNESCAPED_UNICODE нужна для того, чтобы русские символы
    // кодировались нормально в UTF-8, а не в виде последовательностей типа \u0428
file_put_contents('docs/updated.geojson', json_encode($json, JSON_UNESCAPED_UNICODE)); 



echo "<hr style='background: #88C86F;'>";



// echo "<br>req = " . $req;

//  $date = "2020-06-21";
// print_r(date_parse($date));
// echo "<br>Timestamp (s): ";
// echo strtotime($date);
// echo "<br>Millitime (ms): ";
//  echo $time = strtotime($date) * 1000;
// echo "<br>1 week (ms): ";
//  echo $week = 7*24*60*60 * 1000;

// echo "<br><br>";

// //$data[] = "[$datetime, $value]";

//  $data[] = [$time, 29.9];
//  $data[] = [$time+$week, 106.4];
//  $data[] = [$time+$week*2, 129.2];
//  // $data[] = [$time+$week*3, 144.0];
//  $data[] = [$time+$week*4, 176.0];
//  $data[] = [$time+$week*5, 135.6];
//  $data[] = [$time+$week*6, 148.5];
//  $data[] = [$time+$week*7, 236.4];
//  $data[] = [$time+$week*8, 194.1];
//  $data[] = [$time+$week*9, 95.6];
//  $data[] = [$time+$week*10, 54.4];

// echo "<pre>";
// print_r($data);
// echo "</pre>";




/*$chart = Highcharts::widget([
   'options' => [
        'title' => ['text' => 'Проекты освоения лесов'],
        'subtitle' => ['text' => 'по отчетным датам'],
        'credits' => ['enabled' => false],
        'xAxis' => [
            'type' => 'datetime',
        ],
        'yAxis' => [
           'title' => ['text' => 'Количество проектов'],
           'gridLineDashStyle' => 'LongDash',
        ],
        'series' => [
            [
                // 'type' => 'spline', // плавная линия
                // 'lineColor' => '#0a0', // цвет линии
                'name' => 'Всего',
                'dataLabels' => ['enabled' => true],
                'data' => $data,
            ],
        ],
    ]
]); 

echo $chart;*/



/*$chart2 = Highcharts::widget([
   'options' => [
        'title' => ['text' => 'Проекты освоения лесов'],
        'subtitle' => ['text' => 'по отчетным датам'],
        'credits' => ['enabled' => false],
        'xAxis' => [
            // 'categories' => ['Apples', 'Bananas', 'Oranges']
           // 'title' => ['text' => 'название оси х'],
            // The types are 'linear' (default), 'logarithmic' and 'datetime'
            'type' => 'datetime',
        ],
        'yAxis' => [
           'title' => ['text' => 'Количество проектов'],
           'gridLineWidth' => 0, // отображать сетку по оси
           'gridLine' => false, // толщина линии сетки
        ],
        // 'chart' => ['type' => 'bar'],
        // 'chart' => ['type' => 'line'],
        'series' => [
            // ['name' => 'Jane', 'data' => [1, 0, 4]],
            // ['name' => 'John', 'data' => [5, 7, 3]],
            
            // Серия данных для графика
            [
                // 'type' => 'spline', // плавная линия
                // 'lineWidth' => 2, // толщина линии
                'lineColor' => '#0a0', // цвет линии
                // 'dashStyle' => 'shortdash', // тип линии - longdash, shortdash, dot
                'allowPointSelect'=> true, // позволяем выбрать точку щелчком мыши
                // Зоны графика, определяем разный стиль отображения 
                // по умолчанию в зависимости от значения по оси y
                'zones' => [[  
                    'value'=> 100,  
                    'color'=> '#f7a35c'  
                    ], [
                    'value'=> 200,  
                    'color'=> '#7cb5ec'  
                    ], [
                    'color'=> '#90ed7d'  
                ]],
                // Переопределяем ось, по которой будут разделяться зоны
                'zoneAxis'=> 'x',
                'zones'=> [
                    ['value'=> 1595697600000],
                    ['dashStyle'=> 'dot']
                ],
                'name' => 'Всего',
                'dataLabels' => [
                    'enabled' => true,
                ],
                
                'data' => [
                    [$time, 29.9], [($time+$week), 106.4], [($time+$week*2), 129.2], ['x'=>($time+$week*3), 'y'=>144.0, 'name' => 'Точка 4', 'marker' => [ 'fillColor' => '#BF0B23', 'radius' => 8 ]], [($time+$week*4), 176.0], [($time+$week*5), 135.6], [($time+$week*6), 148.5],
                    [ 'x' =>($time+$week*7),'y' => 236.4, 'color' => '#f00'], [($time+$week*8), 194.1], [($time+$week*9), 95.6], [($time+$week*10), 54.4]
                ],

            ],
            

        ],
        //Выводим значения около точек 
        // 'plotOptions' => [
        //     'line'=> [
        //         'dataLabels'=> [
        //             'enabled'=> true
        //         ],
        //         // 'enableMouseTracking'=> false // не реагируем на мышь
        //     ]
        // ],

    ]
]); 

// $chart->options->chart->type = 'bar';

echo $chart2;*/



// JSON (using JSON string)
// Alternatively, you can use a valid JSON string in place of an associative array to specify options
// Note: You must provide a valid JSON string (with double quotes) when using the second option.
// echo Highcharts::widget([
//    'options'=>'{
//       "title": { "text": "Fruit Consumption" },
//       "xAxis": {
//          "categories": ["Apples", "Bananas", "Oranges"]
//       },
//       "yAxis": {
//          "title": { "text": "Fruit eaten" }
//       },
//       "series": [
//          { "name": "Jane", "data": [1, 0, 4] },
//          { "name": "John", "data": [5, 7,3] }
//       ]
//    }'
// ]);



/*echo Highcharts::widget([
    'scripts' => [
        // 'highcharts-more',   // enables supplementary chart types (gauge, arearange, columnrange, etc.)
        'modules/exporting', // adds Exporting button/menu to chart
        // 'themes/grid'        // applies global 'grid' theme to all charts
        'themes/grid-light',
    ],
    'options' => [
        'credits' => ['enabled' => false], // Убираем подпись в правом нижнем углу (метку Highcharts.com)
        'title' => [
            'text' => 'Combination chart',
        ],
        'xAxis' => [
            'categories' => ['Apples', 'Oranges', 'Pears', 'Bananas', 'Plums'],
        ],
        'labels' => [
            'items' => [
                [
                    'html' => 'Total fruit consumption',
                    'style' => [
                        'left' => '50px',
                        'top' => '18px',
                        'color' => new JsExpression('(Highcharts.theme && Highcharts.theme.textColor) || "black"'),
                    ],
                ],
            ],
        ],
        'series' => [
            [
                'type' => 'column',
                'name' => 'Jane',
                'data' => [3, 2, 1, 3, 4],
            ],
            [
                'type' => 'column',
                'name' => 'John',
                'data' => [2, 3, 5, 7, 6],
            ],
            [
                'type' => 'column',
                'name' => 'Joe',
                'data' => [4, 3, 3, 9, 0],
            ],
            [
                'type' => 'spline',
                'name' => 'Average',
                'data' => [3, 2.67, 3, 6.33, 3.33],
                'marker' => [
                    'lineWidth' => 2,
                    'lineColor' => new JsExpression('Highcharts.getOptions().colors[3]'),
                    'fillColor' => 'white',
                ],
            ],
            [
                'type' => 'pie',
                'name' => 'Total consumption',
                'data' => [
                    [
                        'name' => 'Jane',
                        'y' => 13,
                        'color' => new JsExpression('Highcharts.getOptions().colors[0]'), // Jane's color
                    ],
                    [
                        'name' => 'John',
                        'y' => 23,
                        'color' => new JsExpression('Highcharts.getOptions().colors[1]'), // John's color
                    ],
                    [
                        'name' => 'Joe',
                        'y' => 19,
                        'color' => new JsExpression('Highcharts.getOptions().colors[2]'), // Joe's color
                    ],
                ],
                'center' => [100, 80],
                'size' => 100,
                'showInLegend' => false,
                'dataLabels' => [
                    'enabled' => false,
                ],
            ],
        ],
    ]
]);*/


/*$chart3 = Highcharts::widget([
   'options' => [
        'plotBackgroundColor' => null,
        'plotBorderWidth' => null,
        'plotShadow' => false,
        //'type' => 'pie',
        'title' => ['text' => 'Browser market shares in January, 2018'],
        //'tooltip'=> ['pointFormat' => '{series.name}: <b>{point.percentage:.1f}%</b>' ],
       //'accessibility'=> ['point'=> ['valueSuffix' => '%' ] ],
        'plotOptions' => [
               'pie' => [
                        'allowPointSelect' => true,
                        'cursor' => 'pointer',
                        'dataLabels' => ['enabled' => false],
                        'showInLegend' => true
                        ]
                ],    
        'series' => [
                [
                'name' => 'Brands',
                'type' => 'pie',
                'colorByPoint' => true,
                'data' => [
                    [
                      'name' => 'Chrome',
                       'y' => 61.41, 
                       'sliced' => true,
                       'selected' => true
                    ], 
                    [
                     'name' => 'Internet Explorer',
                      'y' => 11.84
                    ], 
                    [
                     'name' => 'Firefox',
                      'y' => 10.85
                    ], 
                    [
                     'name' => 'Edge',
                      'y' => 4.67
                    ], 
                    [
                      'name' => 'Safari',
                      'y' => 4.18
                    ], 
                    [
                      'name' => 'Other',
                      'y' => 7.05
                    ]
                ]
            ]
        ]
    ]  
]);

echo $chart3;*/


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
           'width' => 400,
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


$pol = [16, 126, 22, 11, 5, 206, 25, 79, 89, 292, 47, 0, 56, 0, 41, 0, 60, 11, 44, 18, 0, 0, 57, 72, 1, 31, 12, 50, 4, 54, 5, 10, 295, 48, 30, 37, 148]; 
$branch = ['Амурский', 'Архангельский', 'Башкирский', 'Бурятский', 'Воронежлеспроект', 'Вотсиблеспроект', 'Вятский', 'Дальлеспроект', 'Заплеспроект', 'Запсиблеспроект', 'Казанский', 'Камчатский', 'Кареллеспроект', 'Мослеспроект', 'Омский', 'Пензенский', 'Пермский', 'Поволжский', 'Прибайкаллеспроект', 'Приморский', 'Рязанский', 'Северо-Кавказский', 'Севзаплеспроект', 'Севлеспроект', 'Тамбовский', 'Тверской', 'Томский', 'Тюменский', 'Ульяновский', 'Уральский', 'Филиал по Респ. Коми', 'Филиал по Респ. Марий Эл', 'Ханты-Мансийский', 'Центрлеспроект', 'Читинский', 'Южный', 'Якутский'];

//Круговая диаграмма отчетов ПОЛ по филиалам
/*$chat5 = Highcharts::widget ([
    'options' => [
        'plotBackgroundColor' => null,
        'plotBorderWidth' => null,
        'plotShadow' => false,
        'title' => ['text' => 'Отчеты по ПОЛ'],
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
            'layout' => 'vertical',
            'align' => 'left',
            //'x' => 200,
            ],
        'series' => [
            [
                'name' => 'Количество ПОЛов',
                //'name' => $branch,
                'type' => 'pie',
                'colorByPoint' => true,
                //'data' => $pol2
                'data' =>[     
                    [
                        'name' => $branch[0],
                        'y' => $pol[0]
                    ],
                    [
                        'name' => $branch[1],
                        'y' => $pol[1]
                    ],
                    [
                        'name' => $branch[2],
                        'y' => $pol[2]
                    ],
                    [
                        'name' => $branch[3],
                        'y' => $pol[3]
                    ],
                    [
                        'name' => $branch[4],
                        'y' => $pol[4]
                    ],
                    [
                        'name' => $branch[5],
                        'y' => $pol[5]
                    ],
                    [
                        'name' => $branch[6],
                        'y' => $pol[6]
                    ],
                    [
                        'name' => $branch[7],
                        'y' => $pol[7]
                    ],
                    [
                        'name' => $branch[8],
                        'y' => $pol[8]
                    ],
                    [
                        'name' => $branch[9],
                        'y' => $pol[9]
                    ],
                    [
                        'name' => $branch[10],
                        'y' => $pol[10]
                    ],
                    [
                        'name' => $branch[11],
                        'y' => $pol[11]
                    ],
                    [
                        'name' => $branch[12],
                        'y' => $pol[12]
                    ],
                    [
                        'name' => $branch[13],
                        'y' => $pol[13]
                    ],
                    [
                        'name' => $branch[14],
                        'y' => $pol[14]
                    ],
                    [
                        'name' => $branch[15],
                        'y' => $pol[15]
                    ],
                    [
                        'name' => $branch[16],
                        'y' => $pol[16]
                    ],
                    [
                        'name' => $branch[17],
                        'y' => $pol[17]
                    ],
                    [
                        'name' => $branch[18],
                        'y' => $pol[18]
                    ],
                    [
                        'name' => $branch[19],
                        'y' => $pol[19]
                    ],
                     [
                        'name' => $branch[20],
                        'y' => $pol[20]
                    ],
                    [
                        'name' => $branch[21],
                        'y' => $pol[21]
                    ],
                    [
                        'name' => $branch[22],
                        'y' => $pol[22]
                    ],
                    [
                        'name' => $branch[23],
                        'y' => $pol[23]
                    ],
                    [
                        'name' => $branch[24],
                        'y' => $pol[24]
                    ],
                    [
                        'name' => $branch[25],
                        'y' => $pol[25]
                    ],
                    [
                        'name' => $branch[26],
                        'y' => $pol[26]
                    ],
                    [
                        'name' => $branch[27],
                        'y' => $pol[27]
                    ],
                    [
                        'name' => $branch[28],
                        'y' => $pol[28]
                    ],
                    [
                        'name' => $branch[29],
                        'y' => $pol[29]
                    ],
                    [
                        'name' => $branch[30],
                        'y' => $pol[30]
                    ],
                    [
                        'name' => $branch[31],
                        'y' => $pol[31]
                    ],
                    [
                        'name' => $branch[32],
                        'y' => $pol[32]
                    ],
                    [
                        'name' => $branch[33],
                        'y' => $pol[33]
                    ],
                    [
                        'name' => $branch[34],
                        'y' => $pol[34]
                    ],
                    [
                        'name' => $branch[35],
                        'y' => $pol[35]
                    ],
                    [
                        'name' => $branch[36],
                        'y' => $pol[36]
                    ],
                 ],
            ],
        ],
    ],

]);

*/

//название видов работ
$type_work_name = ['Заготовка древесины', 'Заготовка живицы', 'Заготовка и сбор недревесных лесных ресурсов', 'Заготовка пищевых лесных ресурсов и сбор лекарственных растений', 'Охотничье хозяйство', 'Сельское хозяйство', 'Научно-исследовательскоя и образовательная деятельности', 'Рекреационная деятельность', 'Создание и эксплуатация лесных плантаций', 'Выращивание лесных растений', 'Выращивание посадочного материала лесных растений', 'Геологическое изучение недр, разработка месторождений', 'Строительство и эксплуатация водных объектов', 'Строительство, реконструкция, эксплуатация линейных объектов', 'Переработка древесины и иных лесных ресурсов', 'Религиозная деятельность', 'Иные виды'];
//количество проектов по всем видам работ для конкретных филиалов
$type_work_All = [879, 0, 2, 5, 34, 30, 14, 190, 0, 1, 5, 515, 35, 362, 5, 3, 6];

$type_work_branch = ['Казанский', 'Дальлеспроект', 'Заплеспроект', 'Запсиблеспроект', 'Вотсиблеспроект', 'Кареллеспроект', 'Мослеспроект', 'Омский', 'Прибайкаллеспроект', 'Севзаплеспроект', 'Тюменский', 'Центрлеспроект', 'Якутский'];


$project_all = [16, 126, 22, 11, 5, 206, 25, 79, 89, 292, 47, 0, 57, 0, 42, 18, 60, 11, 44, 18, 0, 0, 57, 72, 1, 33, 12, 50, 4, 54, 5, 10, 295, 49, 30, 37, 148]; //количество всех проектов
$project_comleted = [8, 88, 22, 0, 5, 133, 16, 52, 35, 183, 35, 0, 52, 0, 35, 14, 52, 7, 19, 11, 0, 0, 31, 70, 0, 29, 8, 30, 3, 33, 2, 8, 283, 46, 26, 36, 125]; //количество всех завершенных проектов


//считаем количество проектов в работе
$project_work[] = array();
for ($i = 0; $i <= 36; $i++){
    $project_work[$i] = $project_all[$i] - $project_comleted[$i];
};


//Круговая диаграмма по видам работ для всех филиалов
/*$roundAll = Highcharts::widget ([
    'options' => [
        'title' => ['text' => 'Виды работ'],
        'subtitle' => ['text' => 'по всем филиалам'],
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
            'layout' => 'vertical',
            'align' => 'right',
            'x' => -600,
            'y' => 15
            ],    
        'series' => [
            [
                'name' => 'Количество проектов',
                'type' => 'pie',
                'colorByPoint' => true,
                'data' =>[    
                    [
                        'name' => $type_work_name [0],
                        'y' => $type_work_All[0]
                    ],
                    [
                        'name' => $type_work_name [1],
                        'y' => $type_work_All[1]
                    ],
                    [
                        'name' => $type_work_name [2],
                        'y' => $type_work_All[2]
                    ],
                    [
                        'name' => $type_work_name [3],
                        'y' => $type_work_All[3]
                    ],
                    [
                        'name' => $type_work_name [4],
                        'y' => $type_work_All[4]
                    ],
                    [
                        'name' => $type_work_name [5],
                        'y' => $type_work_All[5]
                    ],
                    [
                        'name' => $type_work_name [6],
                        'y' => $type_work_All[6]
                    ],
                    [
                        'name' => $type_work_name [7],
                        'y' => $type_work_All[7]
                    ],
                    [
                        'name' => $type_work_name [8],
                        'y' => $type_work_All[8]
                    ],
                    [
                        'name' => $type_work_name [9],
                        'y' => $type_work_All[9]
                    ],
                    [
                        'name' => $type_work_name [10],
                        'y' => $type_work_All[10]
                    ],
                    [
                        'name' => $type_work_name [11],
                        'y' => $type_work_All[11]
                    ],
                    [
                        'name' => $type_work_name [12],
                        'y' => $type_work_All[12]
                    ],
                    [
                        'name' => $type_work_name [13],
                        'y' => $type_work_All[13]
                    ],
                    [
                        'name' => $type_work_name [14],
                        'y' => $type_work_All[14]
                    ],
                    [
                        'name' => $type_work_name [15],
                        'y' => $type_work_All[15]
                    ],
                    [
                        'name' => $type_work_name [16],
                        'y' => $type_work_All[16]
                    ],
                ],
            ],
        ],
    ],
]);
*/


   

//Вертикальная диаграмма по завершенным и в работе проектам
$vertik = Highcharts::widget ([
        'options' => [
        'chart' => ['height' => 690],
        'title' => ['text' => 'Сведения о выполнении работ'],
        'subtitle' => ['text' => 'по всем филиалам'],
        'credits' => ['enabled' => false],
        'xAxis' => ['categories' => $branch],
        'yAxis' => [
            'min' => 0,
            'title' => ['text' => 'Количество проектов']
            ],
            
        'legend' => ['reversed' => true],
        'plotOptions' => ['series' => ['stacking' => 'normal']],
        'series' => [
            [
                'type' => 'bar',
                'name' => 'В работе',
                'data' => $project_work,
                //'color' => '#32CD32'
            ],
            [
                'type' => 'bar',
                'name' => 'Завершенно',
                'data' => $project_comleted,
                //'color' => '#808080'
            ]           
            
        ]

    ]

]);



foreach ($dates as $date) {
    $day[] = strtotime($date); //переводим из строки в дату в секундах
   //$day[] = new DateTime($date); //переводим из строки в дату
};


for ($i=0; $i < count($dates) ; $i++) { 
   $depend [$i] = [$day[$i]*1000, $asum[$i]]; //массив с датой и количеством
}

// echo "<pre>";
// var_dump($depend);
// echo "</pre>";




/*$plot = Highcharts::widget([
   'options' => [
        'title' => ['text' => 'Проекты освоения лесов'],
        'subtitle' => ['text' => 'Кареллеспроект'],
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
                'name' => 'Кареллеспроект',
                'dataLabels' => ['enabled' => true],
                'data' => $depend,
            ],
        ],
    ]
]);*/ 

// echo '<pre>';
// var_dump($plotdepend);
// echo '</pre>';



$plot2 = Highcharts::widget([
   'options' => [
        'chart' => ['height' => 450],
        'title' => ['text' => 'Проекты освоения лесов'],
        'subtitle' => ['text' => 'Запсиблеспроект'],
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
        'series' => [
            [
                'name' => 'Алтайский край',
                'dataLabels' => ['enabled' => true],
                //'type' => 'spline', //плавная линия
                'data' => $plotdepend["Алтайский край"],
            ],
            [
                'name' => 'Кемеровская область',
                'dataLabels' => ['enabled' => true],
                //'type' => 'spline', //плавная линия
                'data' => $plotdepend["Кемеровская область"],
            ],
            [
                'name' => 'Новосибирская область',
                'dataLabels' => ['enabled' => true],
                //'type' => 'spline', //плавная линия
                'data' => $plotdepend["Новосибирская область"],
            ],
            [
                'name' => 'Омская область',
                'dataLabels' => ['enabled' => true],
                //'type' => 'spline', //плавная линия
                'data' => $plotdepend["Омская область"],
            ],
            [
                'name' => 'Томская область',
                'dataLabels' => ['enabled' => true],
                // 'type' => 'spline' //плавная линия,
                'data' => $plotdepend["Томская область"],
            ],
            [
                'name' => 'Республика Алтай',
                'dataLabels' => ['enabled' => true],
                //'type' => 'spline', //плавная линия
                'data' => $plotdepend["Республика Алтай"],
            ],
            // [
            //     'name' => 'Ханты-Мансийский автономный округ',
            //     'dataLabels' => ['enabled' => true],
            //     //'type' => 'spline', //плавная линия
            //     'data' => $plotdepend["Ханты-Мансийский автономный округ – Югра"],
            // ],
            // [
            //     'name' => 'Ямало-Ненецкий автономный округ',
            //     'dataLabels' => ['enabled' => true],
            //     //'type' => 'spline', //плавная линия
            //     'data' => $plotdepend["Ямало-Ненецкий автономный округ"],
            // ],
        ],
    ]
]); 


        // echo '<pre>';
        // var_dump($plotmassiv);
        // echo '</pre>';


//круговая диаграмма по видам использовния
$roundType = Highcharts::widget ([
    'options' => [
       // 'chart' => ['height' => 500],
        'title' => ['text' => 'Вид использования лесов'],
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
            'layout' => 'vertical',
            'align' => 'right',
            'borderWidth' => 1,
            'x' => -150,
            //'y' => 15
            ],    
        'series' => [
            [
                'name' => 'Количество проектов',
                'type' => 'pie',
                'colorByPoint' => true,
                'data' => [
                    [
                        'name' => $typeusework [1],
                        'y' => $usage[1],
                        'color' => '#F00',
                    ],
                    $plotmassiv [2],
                    $plotmassiv [3],
                    $plotmassiv [4],
                    $plotmassiv [5],
                    $plotmassiv [6],
                    $plotmassiv [7],
                    [
                        'name' => $typeusework [8],
                        'y' => $usage[8],
                        'color' => '#800080',
                    ],                    
                    $plotmassiv [9],
                    $plotmassiv [10],
                    $plotmassiv [11],
                    [
                        'name' => $typeusework [12],
                        'y' => $usage[12],
                        'color' => '#0000FF',
                    ],
                    [
                        'name' => $typeusework [13],
                        'y' => $usage[13],
                        'color' => '#00FF00',
                    ],
                    [
                        'name' => $typeusework [14],
                        'y' => $usage[14],
                        'color' => '#FFFF00',
                    ],
                    $plotmassiv [15],
                    $plotmassiv [16],
                    [
                        'name' => $typeusework [17],
                        'y' => $usage[17],
                        'color' => '#00FFFF',
                    ],
                ],            
            ],
        ],
    ],
]);


$plotEconom = Highcharts::widget([
   'options' => [
        'title' => ['text' => 'Показатели планово-экономической деятельности'],
        'credits' => ['enabled' => false],
        'xAxis' => [
            'type' => 'datetime',
            'title' => ['text' => 'Время'],
        ],
        'yAxis' => [
           'title' => ['text' => 'Количество договоров'],
             ],
        'series' => [
            [
                'name' => 'Динамика',
                'dataLabels' => ['enabled' => true],
                'data' => $depension,
            ],
        ],
    ]
]); 

echo '<hr>';
echo $plotEconom;

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
            'title' => ['text' => 'Количество договоров']
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
                'name' => 'Количество договоров',
                'data' => $quantity

            ],
        ],
    ]
]);

//вертикальная диаграмма
$vertikG = Highcharts::widget ([
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
                'name' => 'В работе (+'.$newwT.')',
                'data' => $docw,
                'color' => '#98FB98'
            ],
            [
                'type' => 'bar',
                'name' => 'Завершенно (+'.$newcT.')',
                'data' => $docc,
                'color' => '#696969'
            ]           
            
        ]

    ]

]);



echo '<hr>';
//echo $chat5; //Круговая диаграмма отчетов ПОЛ по филиалам
//echo '<hr>';
//echo $roundAll; //Круговая диаграмма по видам работ для всех филиалов
echo '<hr>';
echo $vertik; //Вертикальная диаграмма по завершенным и в работе проектам
echo '<hr>';
// echo $plot;
// echo '<hr>';
echo $plot2;
echo '<hr>';
echo $roundType;
echo '<hr>';
echo $plotEconom;
echo '<hr>';
echo $bar;
echo '<hr>';
echo $vertikG; //вывод диаграммы 



       
?>

			  </div>
            
