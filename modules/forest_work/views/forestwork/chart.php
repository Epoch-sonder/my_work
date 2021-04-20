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
echo "Ошибки при создании JSON-объекта из файла: ";
switch (json_last_error()) {
    case JSON_ERROR_NONE:
        echo 'Ошибок нет';
    break;
    case JSON_ERROR_DEPTH:
        echo 'Достигнута максимальная глубина стека';
    break;
    case JSON_ERROR_STATE_MISMATCH:
        echo 'Некорректные разряды или несоответствие режимов';
    break;
    case JSON_ERROR_CTRL_CHAR:
        echo 'Некорректный управляющий символ';
    break;
    case JSON_ERROR_SYNTAX:
        echo 'Синтаксическая ошибка, некорректный JSON';
    break;
    case JSON_ERROR_UTF8:
        echo 'Некорректные символы UTF-8, возможно неверно закодирован';
    break;
    default:
        echo 'Неизвестная ошибка';
    break;
}

echo "<br>";


    // Распечатываем полученный массив
echo "<pre>";
//var_dump($json);
echo "</pre>";

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
echo "<pre>";
//var_dump($json);
echo "</pre>";

    // Кодируем массив в объект JSON и сохраняем его в файл
    // http://192.168.8.42/docs/updated.geojson
    // опция JSON_UNESCAPED_UNICODE нужна для того, чтобы русские символы
    // кодировались нормально в UTF-8, а не в виде последовательностей типа \u0428
file_put_contents('docs/updated.geojson', json_encode($json, JSON_UNESCAPED_UNICODE)); 



echo "<hr style='background: #88C86F;'>";



// echo "<br>req = " . $req;

 $date = "2020-06-21";
// // print_r(date_parse($date));
// echo "<br>Timestamp (s): ";
// echo strtotime($date);
// echo "<br>Millitime (ms): ";
 echo $time = strtotime($date) * 1000;
// echo "<br>1 week (ms): ";
 echo $week = 7*24*60*60 * 1000;

// echo "<br><br>";

// $data[] = "[$datetime, $value]";

 $data[] = [$time, 29.9];
 $data[] = [$time+$week, 106.4];
 $data[] = [$time+$week*2, 129.2];
 // $data[] = [$time+$week*3, 144.0];
 $data[] = [$time+$week*4, 176.0];
 $data[] = [$time+$week*5, 135.6];
 $data[] = [$time+$week*6, 148.5];
 $data[] = [$time+$week*7, 236.4];
 $data[] = [$time+$week*8, 194.1];
 $data[] = [$time+$week*9, 95.6];
 $data[] = [$time+$week*10, 54.4];

//echo "<pre>";
 //print_r($data);
 //echo "</pre>";

$chart = Highcharts::widget([
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

echo $chart;



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
$type_work_Kazan = [3, 0, 0, 0, 3, 9, 2, 14, 0, 0, 3, 2, 3, 8, 0, 0, 0];
$type_work_Dalles = [46, 0, 0, 0, 1, 3, 1, 6, 0, 0, 1, 12, 0, 7, 1, 0, 1];
$type_work_Zaples = [61, 0, 0, 0, 5, 1, 0, 8, 0, 0, 0, 3, 3, 6, 0, 0, 2];
$type_work_Zapsib = [108, 0, 0, 1, 0, 0, 5, 11, 0, 0, 0, 107, 2, 57, 1, 0, 0];
$type_work_Votsib = [45, 0, 0, 0, 6, 0, 0, 10, 0, 0, 0, 105, 3, 37, 0, 0, 0];
$type_work_Karel = [30, 0, 0, 0, 1, 5, 1, 7, 0, 0, 0, 9, 0, 3, 0, 0, 0];
$type_work_Mosles = [9, 0, 0, 0, 2, 0, 0, 18, 0, 0, 0, 2, 8, 19, 0, 3, 0];
$type_work_Omsk = [13, 0, 2, 1, 2, 2, 0, 10, 0, 0, 0, 2, 0, 10, 0, 0, 0];
$type_work_Pribaikal = [29, 0, 0, 1, 0, 0, 0, 5, 0, 0, 0, 1, 0, 7, 1, 0, 0];
$type_work_Sevzap = [32, 0, 0, 0, 3, 2, 2, 5, 0, 0, 0, 0, 0, 13, 0, 0, 0];
$type_work_Tumen = [2, 0, 0, 0, 0, 0, 0, 8, 0, 0, 0, 21, 1, 18, 0, 0, 0];
$type_work_Chentr = [5, 0, 0, 0, 0, 0, 2, 24, 0, 0, 0, 2, 7, 8, 0, 0, 0];
$type_work_Jackut = [48, 0, 0, 0, 2, 4, 0, 4, 0, 0, 0, 54, 2, 34, 0, 0, 0];

$type_work_All = [879, 0, 2, 5, 34, 30, 14, 190, 0, 1, 5, 515, 35, 362, 5, 3, 6];

$type_work_branch = ['Казанский', 'Дальлеспроект', 'Заплеспроект', 'Запсиблеспроект', 'Вотсиблеспроект', 'Кареллеспроект', 'Мослеспроект', 'Омский', 'Прибайкаллеспроект', 'Севзаплеспроект', 'Тюменский', 'Центрлеспроект', 'Якутский'];


$project_all = [16, 126, 22, 11, 5, 206, 25, 79, 89, 292, 47, 0, 57, 0, 42, 18, 60, 11, 44, 18, 0, 0, 57, 72, 1, 33, 12, 50, 4, 54, 5, 10, 295, 49, 30, 37, 148]; //количество всех проектов
$project_comleted = [8, 88, 22, 0, 5, 133, 16, 52, 35, 183, 35, 0, 52, 0, 35, 14, 52, 7, 19, 11, 0, 0, 31, 70, 0, 29, 8, 30, 3, 33, 2, 8, 283, 46, 26, 36, 125]; //количество всех завершенных проектов


//считаем количество проектов в работе
$project_work[] = array();
for ($i = 0; $i <= 36; $i++){
    $project_work[$i] = $project_all[$i] - $project_comleted[$i];
};


//считаем количество конктретного вида работ по филиалам
/*for ($i = 0; $i <= 16; $i++){
    $work[] = [$type_work_Kazan[$i], $type_work_Dalles[$i], $type_work_Zaples[$i], $type_work_Zapsib[$i], $type_work_Votsib[$i], $type_work_Karel[$i], $type_work_Mosles[$i], $type_work_Omsk[$i], $type_work_Pribaikal[$i], $type_work_Sevzap[$i], $type_work_Tumen[$i], $type_work_Chentr[$i], $type_work_Jackut[$i]]; //количество конктретного вида работ по филиалам
}*/




//Круговая диаграмма по видам работ для Казанского филиала 
/*$chat6 = Highcharts::widget ([
    'options' => [
        'plotBackgroundColor' => null,
        'plotBorderWidth' => null,
        'plotShadow' => false,
        'title' => ['text' => 'Виды работ'],
        'subtitle' => ['text' => 'Казанский филиал'],
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
            'x' => 100,
            ],    
        'series' => [
            [
                'name' => 'Количество проектов',
                'type' => 'pie',
                'colorByPoint' => true,
                'data' =>[     
                    [
                        'name' => $type_work_name [0],
                        'y' => $type_work_Kazan[0]
                    ],
                    [
                        'name' => $type_work_name [1],
                        'y' => $type_work_Kazan[1]
                    ],
                    [
                        'name' => $type_work_name [2],
                        'y' => $type_work_Kazan[2]
                    ],
                    [
                        'name' => $type_work_name [3],
                        'y' => $type_work_Kazan[3]
                    ],
                    [
                        'name' => $type_work_name [4],
                        'y' => $type_work_Kazan[4]
                    ],
                    [
                        'name' => $type_work_name [5],
                        'y' => $type_work_Kazan[5]
                    ],
                    [
                        'name' => $type_work_name [6],
                        'y' => $type_work_Kazan[6]
                    ],
                    [
                        'name' => $type_work_name [7],
                        'y' => $type_work_Kazan[7]
                    ],
                    [
                        'name' => $type_work_name [8],
                        'y' => $type_work_Kazan[8]
                    ],
                    [
                        'name' => $type_work_name [9],
                        'y' => $type_work_Kazan[9]
                    ],
                    [
                        'name' => $type_work_name [10],
                        'y' => $type_work_Kazan[10]
                    ],
                    [
                        'name' => $type_work_name [11],
                        'y' => $type_work_Kazan[11]
                    ],
                    [
                        'name' => $type_work_name [12],
                        'y' => $type_work_Kazan[12]
                    ],
                    [
                        'name' => $type_work_name [13],
                        'y' => $type_work_Kazan[13]
                    ],
                    [
                        'name' => $type_work_name [14],
                        'y' => $type_work_Kazan[14]
                    ],
                    [
                        'name' => $type_work_name [15],
                        'y' => $type_work_Kazan[15]
                    ],
                    [
                        'name' => $type_work_name [16],
                        'y' => $type_work_Kazan[16]
                    ],
                ],
            ],
        ], 
    ],
]);   

*/



//Круговая диаграмма по видам работ для Дальлеспроекта 
/*echo Highcharts::widget ([
    'options' => [
        'plotBackgroundColor' => null,
        'plotBorderWidth' => null,
        'plotShadow' => false,
        'title' => ['text' => 'Виды работ'],
        'subtitle' => ['text' => 'Дальлеспроект'],
        'credits' => ['enabled' => false],
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
                'name' => 'Work',
                'type' => 'pie',
                'colorByPoint' => true,
                'data' =>[     
                    [
                        'name' => $type_work_name [0],
                        'y' => $type_work_Dalles[0]
                    ],
                    [
                        'name' => $type_work_name [1],
                        'y' => $type_work_Dalles[1]
                    ],
                    [
                        'name' => $type_work_name [2],
                        'y' => $type_work_Dalles[2]
                    ],
                    [
                        'name' => $type_work_name [3],
                        'y' => $type_work_Dalles[3]
                    ],
                    [
                        'name' => $type_work_name [4],
                        'y' => $type_work_Dalles[4]
                    ],
                    [
                        'name' => $type_work_name [5],
                        'y' => $type_work_Dalles[5]
                    ],
                    [
                        'name' => $type_work_name [6],
                        'y' => $type_work_Dalles[6]
                    ],
                    [
                        'name' => $type_work_name [7],
                        'y' => $type_work_Dalles[7]
                    ],
                    [
                        'name' => $type_work_name [8],
                        'y' => $type_work_Dalles[8]
                    ],
                    [
                        'name' => $type_work_name [9],
                        'y' => $type_work_Dalles[9]
                    ],
                    [
                        'name' => $type_work_name [10],
                        'y' => $type_work_Dalles[10]
                    ],
                    [
                        'name' => $type_work_name [11],
                        'y' => $type_work_Dalles[11]
                    ],
                    [
                        'name' => $type_work_name [12],
                        'y' => $type_work_Dalles[12]
                    ],
                    [
                        'name' => $type_work_name [13],
                        'y' => $type_work_Dalles[13]
                    ],
                    [
                        'name' => $type_work_name [14],
                        'y' => $type_work_Dalles[14]
                    ],
                    [
                        'name' => $type_work_name [15],
                        'y' => $type_work_Dalles[15]
                    ],
                    [
                        'name' => $type_work_name [16],
                        'y' => $type_work_Dalles[16]
                    ],
                ],
            ],
        ], 
    ],
]);  */




//Круговая диаграмма по видам работ для всех филиалов
$roundAll = Highcharts::widget ([
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



//Диаграмма по видам работ для филиалов
/*$chat7 = Highcharts::widget ([
    'options' => [
        'title' => ['text' => 'Сведения о выполнении работ'],
        'subtitle' => ['text' => 'по некоторым филиалам'],
        'xAxis' => 
            [
                'categories' => $type_work_name,
                'crosshair' => true,
            ],
        'yAxis' => [ 
            'min' => 0,
            'title' => ['text' => 'Rainfall (mm)']
        ],
        'plotOptions' => 
            [
                'column' =>
                    [
                        'pointPadding' => 0.2,
                        'borderWidth' => 0
                    ]
            ],
        'legend' => [
            'layout' => 'vertical',
            'align' => 'right',
            'x' => -15,
            'y' => -80
            ],
        'credits' => ['enabled' => false],
        'series' => 
        [
            [
                'type' => 'column',
                'name' => $type_work_branch[0],
                'data' => $type_work_Kazan

            ],

            [
                'type' => 'column',
                'name' => $type_work_branch[1],
                'data' => $type_work_Dalles
            ],
            [
                'type' => 'column',
                'name' => $type_work_branch[2],
                'data' => $type_work_Zaples
            ],
            [
                'type' => 'column',
                'name' => $type_work_branch[3],
                'data' => $type_work_Zapsib
            ],
            [
                'type' => 'column',
                'name' => $type_work_branch[4],
                'data' => $type_work_Votsib
            ],
            [
                'type' => 'column',
                'name' => $type_work_branch[5],
                'data' => $type_work_Karel
            ],
            [
                'type' => 'column',
                'name' => $type_work_branch[6],
                'data' => $type_work_Mosles
            ],
            [
                'type' => 'column',
                'name' => $type_work_branch[7],
                'data' => $type_work_Omsk
            ],
            [
                'type' => 'column',
                'name' => $type_work_branch[8],
                'data' => $type_work_Pribaikal
            ],
            [
                'type' => 'column',
                'name' => $type_work_branch[9],
                'data' => $type_work_Sevzap
            ],
            [
                'type' => 'column',
                'name' => $type_work_branch[10],
                'data' => $type_work_Tumen
            ],
            [
                'type' => 'column',
                'name' => $type_work_branch[11],
                'data' => $type_work_Chentr
            ],
            [
                'type' => 'column',
                'name' => $type_work_branch[12],
                'data' => $type_work_Jackut
            ]
        ],
    ],
]);

echo $chat7;*/
    

//Вертикальная диаграмма по видам работ для филиалов     
/*$vertik2 = Highcharts::widget ([
    'options' => [
        'title' => ['text' => 'Сведения о выполнении работ'],
        'subtitle' => ['text' => 'по некоторым филиалам'],
        'xAxis' => ['categories' => $type_work_branch],
        'yAxis' => [
            
            'title' => [
                'text' => 'Количество проектов',
                'align' => 'middle'
                   ],
            'labels' => ['overflow' => 'justify'],
            ],
        'plotOptions' => ['bar' => ['dataLabels' => ['enabled' => true ]]],
        'legend' => [
            'layout' => 'vertical',
            'align' => 'right',
            'verticalAlign' => 'top',
            'x' => -5,
            'y' => 60,
            'width' => 350,
            //'floating' => true, //чтобы легенда была на диаграмме
            //'borderWidth' => 1,
        ],
        'credits' => ['enabled' => false],
        'series' => [
            [
                'type' => 'bar',
                'name' => $type_work_name[0],
                'data' => $work[0]
            ], 
            [
                'type' => 'bar',
                'name' => $type_work_name[1],
                'data' => $work[1]
            ], 
            [
                'type' => 'bar',
                'name' => $type_work_name[2],
                'data' => $work[2]
            ], 
            [
                'type' => 'bar',
                'name' => $type_work_name[3],
                'data' => $work[3]
            ],
            [
                'type' => 'bar',
                'name' => $type_work_name[4],
                'data' => $work[4]
            ],
            [
                'type' => 'bar',
                'name' => $type_work_name[5],
                'data' => $work[5]
            ],
            [
                'type' => 'bar',
                'name' => $type_work_name[6],
                'data' => $work[6]
            ],
            [
                'type' => 'bar',
                'name' => $type_work_name[7],
                'data' => $work[7]
            ],
            [
                'type' => 'bar',
                'name' => $type_work_name[8],
                'data' => $work[8]
            ],
            [
                'type' => 'bar',
                'name' => $type_work_name[9],
                'data' => $work[9]
            ],
            [
                'type' => 'bar',
                'name' => $type_work_name[10],
                'data' => $work[10]
            ],
            [
                'type' => 'bar',
                'name' => $type_work_name[11],
                'data' => $work[11]
            ],
            [
                'type' => 'bar',
                'name' => $type_work_name[12],
                'data' => $work[12]
            ],
            [
                'type' => 'bar',
                'name' => $type_work_name[13],
                'data' => $work[13]
            ],
            [
                'type' => 'bar',
                'name' => $type_work_name[14],
                'data' => $work[14]
            ],
            [
                'type' => 'bar',
                'name' => $type_work_name[15],
                'data' => $work[15]
            ],
            [
                'type' => 'bar',
                'name' => $type_work_name[16],
                'data' => $work[16]
            ]
        ]
    ]

]);*/




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


echo '<hr>';
//echo $chat5; //Круговая диаграмма отчетов ПОЛ по филиалам
echo '<hr>';
//echo $chat6; //Круговая диаграмма по видам работ для Казанского филиала 
echo '<hr>';
echo $roundAll; //Круговая диаграмма по видам работ для всех филиалов
echo '<hr>';
//echo $chat7; //Диаграмма по видам работ для филиалов
echo '<hr>';
//echo $vertik2; //Вертикальная диаграмма по видам работ для филиалов
echo '<hr>';
echo $vertik; //Вертикальная диаграмма по завершенным и в работе проектам
       
?>

			  </div>
            
