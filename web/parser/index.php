Выбираем архив:
<form enctype="multipart/form-data" action="" method="POST">
    <input name="userfile" type="file" />
    <select name="date" style="display: none">
        <option value="may">Май</option>
        <option value="june">Июнь</option>
    </select>
    <br /><br />
    <input type="submit" name="load" value="Загрузить xls" />
</form>

<?php

function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}
$time_start = microtime_float();

$host='localhost'; // имя хоста (уточняется у провайдера)
$user='roslesinforg'; // заданное вами имя пользователя, либо определенное провайдером
$password='oXuZW7VOB9Ge'; // заданный вами пароль
$database='roslesinforg'; // имя базы данных, которую вы должны создать
$mysqli = new mysqli($host, $user, $password,$database) ;

if ($mysqli->connect_error) die('Не удалось подключиться к БД : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);


function pdQuery() {
    global $complex;
    global $value_complex;
    global $complexOneRecord;
    global $comment;
    global $comma;
    global $not_usage;
    global $query;
    global $tb_complex;
    global $idBranch;
    global $customerName;
    global $docs_type;
    global $dataContract;
    global $dataEndings;
    global $row;
    global $date;
    global $idSubject;
    global $idType;
    global $area;
    global $idTypeUse;
    global $mysqli;
    global $count;
    global $dataDefold;
    global $total_added;
    global $complex_docs;
    global $total;
    global $error_record;

    
    if ($complex) {
        $value_complex =',"1"';
        $complexOneRecord = 1;
        $complex_docs--;
    }
    $complex = 1;
    if ($comment{strlen($comment)-1} == ', Лесничества)') $comment = substr($comment,0,-1) . $comma.'Лесничества)';
    else $comment .= $comma.'Лесничества)';
    $comma = ', ';
    $not_usage = 0;

    $query = 'INSERT INTO pd_work(`no_report`,`date_create`,`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` ) VALUES ("1","'.$dataDefold.'","'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[10].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[17].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'","Иные ","4","'.$idTypeUse.'","'.$comment.'","'.$row[14].'" )';

    $results = $mysqli->query($query);
    if ($results)
        echo '№'.  ++$count .' Запись ' . $row[0].' добавлена <br>'; 
    else  {
        echo '№'.  ++$count .' Ошибка записи '. $row[0] .'<br>' ; var_dump($query); echo '<br>' ;
        --$total_added;
        $file = fopen('/var/www/cluster/web/parser/log.txt','a');
        $error_record += 1;
        $text_error = 'Ошибка в строке: '.($total + 1).
            ' Код запроса query: '.$query."\r\n";
        fwrite($file,$text_error);
        fclose($file);
       
    }

    $total_added++ ;
}

function pirQuery() {
    global $PIR_docs;
    pdQuery();
    $PIR_docs = 1;
}

include("parser.php");

if(@$_POST["date"]){

    $uploaddir= '/var/www/cluster/web/parser/tmp/';

    $loc = $uploaddir . $_FILES['userfile']['name'];

    move_uploaded_file($_FILES['userfile']['tmp_name'], $loc);

    /*************/

    $dataDefold = date_default_timezone_get();
    $dataDefold = date("Y-m-d", strtotime($dataDefold . ""));


// Массив с названиями филиалов и их ID
    $branch = [1 =>'Филиал ФГБУ "Рослесинфорг" "Архангельсклеспроект"', 2 => 'Филиал ФГБУ "Рослесинфорг" "Дальлеспроект"', 3 => 'Филиал ФГБУ "Рослесинфорг" "Заплеспроект"', 4 => 'Филиал ФГБУ "Рослесинфорг" "Запсиблеспроект"', 5 => 'Филиал ФГБУ "Рослесинфорг" "Кареллеспроект"', 6 => 'Филиал ФГБУ "Рослесинфорг" "Мослеспроект"', 7 => 'Филиал ФГБУ "Рослесинфорг" "Поволжский леспроект"',8 => 'Филиал ФГБУ "Рослесинфорг" "Севзаплеспроект"', 9 => 'Филиал ФГБУ "Рослесинфорг" "Севлеспроект"', 10 => 'Филиал ФГБУ "Рослесинфорг" "Центрлеспроект"',
        11 => 'Филиал ФГБУ "Рослесинфорг" "Воронежлеспроект"',
        12 => 'Филиал ФГБУ "Рослесинфорг" "Востсиблеспроект"', 13 => 'Филиал ФГБУ "Рослесинфорг" "Прибайкаллеспроект"',
        14 => 'Филиал ФГБУ "Рослесинфорг" "Северо-Кавказский"', //14
        15 => 'Приморский филиал ФГБУ "Рослесинфорг"',
        16 => 'Филиал ФГБУ "Рослесинфорг" "Камчатский"', //16
        17 => 'Филиал ФГБУ "Рослесинфорг" "Амурский"', //17
        18 => 'Омский филиал ФГБУ "Рослесинфорг"', 19 => 'Томский филиал ФГБУ "Рослесинфорг"', 20 => 'Тюменский филиал ФГБУ "Рослесинфорг"', 21 => 'Уральский филиал ФГБУ "Рослесинфорг"',
        22 => 'Филиал ФГБУ "Рослесинфорг" "Ханты"', //22
        23 => 'Башкирский филиал ФГБУ "Рослесинфорг"', //23
        24 => 'Казанский филиал ФГБУ "Рослесинфорг"',
        25 => 'Пензенский филиал ФГБУ "Рослесинфорг"',
        26 => 'Пермский филиал ФГБУ "Рослесинфорг"',
        27 => 'Филиал ФГБУ "Рослесинфорг" "Ульяновский"', //27
        28 => 'Вятский филиал ФГБУ "Рослесинфорг"',
        29 => 'Филиал ФГБУ "Рослесинфорг" "Коми"', //29
        30 => 'Тверской филиал ФГБУ "Рослесинфорг"',
        31 => 'Рязанский филиал ФГБУ "Рослесинфорг"',
        32 => 'Филиал ФГБУ "Рослесинфорг" "Марий Эл"', //32
        33 => 'Филиал ФГБУ "Рослесинфорг" "Тамбовский"', //33
        34 => 'Южный филиал ФГБУ "Рослесинфорг"', 35 => 'Читинский филиал ФГБУ "Рослесинфорг"', 36 => 'Якутский филиал ФГБУ "Рослесинфорг"', 37 => 'Бурятский филиал ФГБУ "Рослесинфорг"'];
    $branches = array_flip($branch);
    $subjects = [1 => "Республика Башкортостан", 2 => "Республика Бурятия", 3 => "Республика Дагестан", 4 => "Кабардино-Балкарская Республика", 5 => "Республика Калмыкия", 6 => "Республика Карелия", 7 => "Республика Коми", 8 => "Республика Марий Эл", 9 => "Республика Мордовия", 10 =>  "Республика Северная Осетия - Алания", 11 =>  "Республика Татарстан", 12 => "Республика Тыва", 13 =>  "Удмуртская Республика", 14 =>  "Республика Ингушетия", 15 => "Чувашская Республика - Чувашия", 16 => "Республика Саха (Якутия)", 17 => "Алтайский край", 18 => "Краснодарский край", 19 => "Красноярский край", 20 =>  "Приморский край", 21 =>  "Ставропольский край", 22 =>  "Хабаровский край", 23 => "Амурская область", 24 => "Архангельская область", 25 =>  "Астраханская область", 26 => "Белгородская область", 27 => "Брянская область", 28 => "Владимирская область", 29 => "Волгоградская область", 30 =>  "Вологодская область", 31 =>  "Воронежская область", 32 =>  "Нижегородская область", 33 =>  "Ивановская область", 34 => "Иркутская область", 35 =>  "Калининградская область", 36 =>  "Тверская область", 37 => "Калужская область", 38 =>  "Камчатский край", 39 =>  "Кемеровская область", 40 =>  "Кировская область", 41 =>  "Костромская область", 42 =>  "Самарская область", 43 =>  "Курганская область", 44 => "Курская область", 45 =>  "Ленинградская область", 46 =>  "Липецкая область", 47 => "Магаданская область", 48 =>  "Московская область", 49 => "Мурманская область", 50 => "Новгородская область", 51 => "Новосибирская область", 52 =>  "Омская область", 53 => "Оренбургская область", 54 => "Орловская область", 55 =>  "Пензенская область", 56 => "Пермский край", 57 =>  "Псковская область", 58 =>  "Ростовская область", 59 => "Рязанская область", 60 =>  "Саратовская область", 61 =>  "Сахалинская область", 62 =>  "Свердловская область", 63 => "Смоленская область", 64 => "Тамбовская область", 65 => "Томская область", 66 =>  "Тульская область", 67 => "Тюменская область", 68 =>  "Ульяновская область", 69 =>  "Челябинская область", 71 =>  "Ярославская область", 72 =>  "г. Санкт-Петербург", 73 => "г. Москва", 76 =>  "Республика Адыгея (Адыгея)", 77 => "Республика Алтай", 78 => "Еврейская автономная область", 79 => "Карачаево-Черкесская республика", 80 =>  "Республика Хакасия", 84 => "Ненецкий автономный округ", 87 =>  "Ханты-Мансийский автономный округ - Югра", 88 => "Чукотский автономный округ", 90 => "Ямало-Ненецкий автономный округ", 91 =>  "Забайкальский край", 94 => "Чеченская Республика", 95 => "Республика Крым", 96 =>  "г. Севастополь"];
    $subjects = array_flip($subjects);

    $xls = SimpleXLS::parse($loc);

// Если дата неправильная
    $date = '2000-01-01 00:00:00';
    $tb_complex =' ,`in_complex`';
    $bd_null = 0;
    $not_bd = 0;
    $count = 0;
    $complex_docs = 0;
    $error_record = 0;
    $countall = 1;
    $already_exist = $total_added = $total = 0;
    $comma = ', ';

    foreach ( $xls->rows() as $r => $row ) {
        $complexOneRecord = 0;
        $value_complex =',"0"';
        $complex = 0;
        $this_pol = 0;
        if ($countall >= 1 and $countall <= 6) $bd_null = 1;
        else{
            $bd_null = 0;
            $query = 'SELECT * FROM   `pd_work` WHERE `code_1C` = "'. $row[14] .'"  LIMIT 1';
            $results = $mysqli->query($query);

            if (!$results->num_rows) $not_bd = 1;
            else $not_bd = 0;
        }

        // Запрос на дубликат
        if($not_bd){
            // Определение га или остальное
            if (strpos($row[12],'га')  !== false and $row[18] == true ){
                $comment = 'Выгрузка с 1С(Заполните поля: Цель';
                $area = $row[18];
            }
            elseif(strpos($row[12],'га') == false or $row[18] == false){
                $comment = 'Выгрузка с 1С(Заполните поля: Цель, Площадь по документу (га) ';
                $area = 0;
            }

            if (!$row[17]){
                $row[17] = 0;
                $comment .= $comma.'Стоимость работ по документу (включая НДС 20%) [руб.коп]';

            }
            if ($row[15]){
                $customerName =  str_replace('"', "'", $row[15]);
            }
            else{
                $customerName = 'Не указано';
                $comment .= $comma.'Заказчик';
            }
            if (!$row[10]){
                $row[10] = 'Не указан';
                $comment .= $comma.'Номер документа';
            }




            if ($row[11]){
                $dataContract = new DateTime($row[11]);
                $dataContract = $dataContract->format('Y-m-d H:i:s');
            }
            else {
                $dataContract = $date;
                $comment .= $comma.'Дату заключения договора';
            }

            if ($row[13]){
                $dataEndings = new DateTime($row[13]);
                $dataEndings  = $dataEndings->format('Y-m-d H:i:s');
            }
            else {
                $dataEndings  = $date;
                $comment .= $comma.'Дату окончание договора ';

            }




            // Нет данных о Амурский(17), Воронежлеспроект(11), Тамбовский(33), Ханты(22), Марий Эл(32), Коми(29),
            if ($row[1] == $branch['2'] or $row[1] == $branch['17']) {
                if(strpos("$row[7]", "№ 043/") !== false) $idBranch =  $branches[$branch['17']];
                elseif(strpos("$row[7]", "№ 04/")!== false) $idBranch =  $branches[$branch['2']];
                elseif(strpos("$row[7]", "№ 042/")!== false) $idBranch =  $branches[$branch['16']];
            }

            elseif ($row[1] == $branch['11'] or $row[1] == $branch['33']) {
                if(strpos("$row[7]", "№ 26/") !== false) $idBranch =  $branches[$branch['33']];
                elseif(strpos("$row[7]", "№ 05/") !== false) $idBranch =  $branches[$branch['11']];
            }
            elseif ($row[1] == $branch['4'] or $row[1] == $branch['22']) {
                if(strpos("$row[7]", "(ХМ)") !== false or strpos("$row[7]", "Счет-фактура") !== false) $idBranch =  $branches[$branch['22']];
//                if(strpos("$row[7]", "Счет-фактура") !== false) $idBranch =  $branches[$branch['22']];
                else $idBranch =  $branches[$branch['4']];
            }
            elseif ($row[1] == $branch['7'] or $row[1] == $branch['32']) {
                if(strpos("$row[7]", "№ 19/") !== false) $idBranch =  $branches[$branch['7']];
                elseif(strpos("$row[7]", "№ 14/") !== false) $idBranch =  $branches[$branch['32']];
            }
            elseif ($row[1] == $branch['9'] or $row[1] == $branch['29']) {
                if(strpos("$row[7]", "/РК") !== false) $idBranch =  $branches[$branch['29']];
                else $idBranch =  $branches[$branch['9']];
            }
            else $idBranch =  $branches[$row[1]];



            $idSubject = $subjects[$row[9]];

            // Определение контракт или договор
            if(strpos("$row[7]", "контракт") !== false) $docs_type = 1;
            else $docs_type = 2;

            $PIR = 0;
            $PIR_docs = 0;
            $idTypeUse = 17;

            if (strpos("$row[6]", "Разработка проектов освоения лесов для всех видов пользования") !== false){
                $not_usage = 1;
                // Вид использования лесов
                $idType = 4;

                if(strpos($row[8],'Заготовка древесины') !== false){
                    $idTypeUse = 1;
                    pdQuery();
                 }
                if(strpos($row[8],'Заготовка живицы') !== false ){
                    $idTypeUse = 2;
                    pdQuery();
                }
                if(strpos($row[8],'Заготовка и сбор недревесных лесных ресурсов') !== false ){
                    $idTypeUse = 3;
                    pdQuery();

                }
                if(strpos($row[8],'Заготовка пищевых лесных ресурсов и сбор лекарственных растений') !== false ){
                    $idTypeUse = 4;
                    pdQuery();
                   }
                if(strpos($row[8],'Осуществление видов деятельности в сфере охотничьего хозяйства') !== false ){
                    $idTypeUse = 5;
                    pdQuery();
                    }
                if(strpos($row[8],'Ведение сельского хозяйства') !== false ){
                    $idTypeUse = 6;
                    pdQuery();
                   }
                if(strpos($row[8],'Осуществление научно-исследовательской деятельности, образовательной деятельности') !== false ){
                    $idTypeUse = 7;
                    pdQuery();
                }
                if(strpos($row[8],'Осуществление рекреационной деятельности')  !== false  ){
                    $idTypeUse = 8;
                    pdQuery();
                }
                if(strpos($row[8],'Создание лесных плантаций и их эксплуатация') !== false  ){
                    $idTypeUse = 9;
                    pdQuery();
                   }
                if(strpos($row[8],'Выращивание лесных плодовых, ягодных, декоративных растений, лекарственных растений') !== false  ){
                    $idTypeUse = 10;
                    pdQuery();
                }
                if(strpos($row[8],'Выращивание посадочного материала лесных растений (саженцев, сеянцев)') !== false ){
                    $idTypeUse = 11;
                    pdQuery();
                }
                if(strpos($row[8],'Выполнение работ по геологическому изучению недр, разработка месторождений полезных ископаемых') !== false ){
                    $idTypeUse = 12;
                    pdQuery();
                }
                if(strpos($row[8],'Строительство и эксплуатация водохранилищ и иных искусственных водных объектов, а также гидротехнических сооружений и морских портов, морских терминалов, речных портов, причалов') !== false  ){
                    $idTypeUse = 13;
                    pdQuery();
                }

                if(strpos($row[8],'Строительство, реконструкция, эксплуатация линейных объектов') !== false  ){
                    $idTypeUse = 14;
                    pdQuery();
                }
                if(strpos($row[8],'Переработка древесины и иных лесных ресурсов') !== false  ){
                    $idTypeUse = 15;
                    pdQuery();
                }
                if(strpos($row[8],'Осуществление религиозной деятельности') !== false ){
                    $idTypeUse = 16;
                    pdQuery();
                }
                if ($not_usage){
                    $idTypeUse = 17;
                    pdQuery();
                }

//                $idTypeUse = 17;
            }

            elseif (strpos($row[6],'Проектно-изыскательские работы') !== false ) {
                $PIR = 1;
            }

            if(strpos($row[8],'Лесной план') !== false ){

                // Вид использования лесов
                $idType = 1;
                pirQuery();
            }

            if(strpos($row[8],'Лесохозяйственный регламент') !== false ){
                $idType = 2;
                pirQuery();
            }
            if(strpos($row[8],'Проектная документация лесного участка (приказ МПР № 54)') !== false ){
                // Вид использования лесов
                $idType = 3;
                pirQuery();
            }
//            if(similar_text($row[8],'Проект освоения лесов (ПОЛ)') >= 102 and $this_pol){
//                if ($complex) {
//                    $value_complex =',"1"';
//                    $complexOneRecord = 1;
//                }
//                    $complex = 1;
//                    if ($comment{strlen($comment)-1} == ', Лесничества)') $comment = substr($comment,0,-1) . $comma.'Лесничества)';
//                else $comment .= $comma.'Лесничества)';
//                $comma = ', ';
//                // Вид использования лесов
//                $idType = 4;
//                $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
//                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[10].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[17].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[14].'" )';
//                    $results = $mysqli->query($query);
//                if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
//                $PIR_docs = 1;
//            }
            if(strpos($row[8],'Проект рекультивации нарушенных земель')  !== false ){
                // Вид использования лесов
                $idType = 5;
                pirQuery();
            }
            if(strpos($row[8],'Лесная декларация')  !== false ){
                // Вид использования лесов
                $idType = 6;
                pirQuery();
            }
            if(strpos($row[8],'Отчет об использовании (защите, воспроизводстве) лесов')  !== false ){
                // Вид использования лесов
                $idType = 7;
                pirQuery();
            }
            if(strpos($row[8],'Проект лесовосстановления (лесоразведения)')  !== false ){
                // Вид использования лесов
                $idType = 8;
                pirQuery();
            }
            if(strpos($row[8],'Проект по изменению целевого назначения лесов (ст. 81 ЛК РФ)')  !== false ){
                // Вид использования лесов
                $idType = 9;
                pirQuery();
            }
            if(strpos($row[8],'Проект по проектированию особо защитных участков лесов')  !== false ){
                // Вид использования лесов
                $idType = 10;
                pirQuery();
            }
            if(strpos($row[8],'Проект установления (изменения) границ лесопарковых и зеленых зон')  !== false ){
                // Вид использования лесов
                $idType = 11;
                pirQuery();
            }
            if(strpos($row[8],'Установление лесопаркового зеленого пояса')  !== false ){
                // Вид использования лесов
                $idType = 12;
                pirQuery();
            }
            if(strpos($row[8],'Проект планирования территории')  !== false ){
                // Вид использования лесов
                $idType = 13;
                pirQuery();
            }
            if(strpos($row[8],'Проект межевания территории')  !== false ){
                // Вид использования лесов
                $idType = 14;
                pirQuery();
            }
            if(strpos($row[8],'Перевод из состава земель лесного фонда')  !== false ){
                // Вид использования лесов
                $idType = 15;
                pirQuery();
            }
            if(strpos($row[8],'Проект противопожарного обустройства лесов')  !== false ){
                // Вид использования лесов
                $idType = 17;
                pirQuery();
            }
            if(strpos($row[8],'Проект организации охотничьего хозяйства')  !== false ){
                // Вид использования лесов
                $idType = 18;
                pirQuery();
            }
            if(strpos($row[8],'Проект организации территории ООПТ')  !== false ){
                // Вид использования лесов
                $idType = 19;
                pirQuery();
            }
            if(strpos($row[8],'Проект реконструкции усадебного парка')  !== false ){
                // Вид использования лесов
                $idType = 20;
                pirQuery();
            }
            if(strpos($row[8],'Проект оценки воздействия на окружающую среду (ОВОС)')  !== false ){
                // Вид использования лесов
                $idType = 21;
                pirQuery();
            }
            if(strpos($row[8],'Проект организации санитарно-защитной зоны')  !== false ){
                // Вид использования лесов
                $idType = 22;
                pirQuery();
            }
            if(strpos($row[8],'Проект нормативов предельно допустимых выбросов (ПДВ)')  !== false ){
                // Вид использования лесов
                $idType = 23;
                pirQuery();
            }
            if(strpos($row[8],'Проект нормативов образования отходов и лимитов на их размещение (ПНООЛР)')  !== false ){
                // Вид использования лесов
                $idType = 24;
                pirQuery();
            }


            if (!$PIR_docs and $PIR){
                // Вид использования лесов
                $idType = 25;
                $idTypeUse = 17;

                // Запрос на создание
                pdQuery();
            }
            if ($complexOneRecord){
                $query = 'UPDATE `pd_work` SET `in_complex` = REPLACE(`in_complex`,"0","1") WHERE `code_1C` = "'. $row[14].'" and `in_complex` = "0"';
                $results = $mysqli->query($query);
            }
        }
        elseif ($bd_null) {echo '';}
        else {
            $already_exist++;
            echo '№'.  ++$count .' Запись '.$row[0].' в базе данных <br>';
        }
        $countall++;
        $total++;
    }


//    echo '<br><br>EXCEL разбор:<pre>';
//    print_r($xls->rows());
//    echo '</pre>';
}


echo '<br><br>';
echo 'Всего строк обработано: '.($total ? $total : 0);
echo '<br>Добавлено новых записей: '.($total_added ? $total_added : 0);
echo '<br>Ранее существующих записей: '.($already_exist ? $already_exist : 0);

echo '<br><br>';
$time_end = microtime_float();
$time = $time_end - $time_start;
echo 'Затрачено секунд: '.$time;
echo '<br>';
if(@$_POST["date"]){

$file = fopen('/var/www/cluster/web/parser/log.txt','a');
$text = 'Дата выполнения: '.date("Y-d-m H:i:s").
    ' Всего строк обработано: '.$total.
    ' Добавлено новых записей в бд: '.$total_added.'(без дубликатов: '.($total_added + $complex_docs).')'.
    ' Ранее существующих записей в бд: '.$already_exist .
     ($error_record? 'Ошибок:'.$error_record :'') .
    ' Затрачено секунд на обработку файла: '.round($time, 3)
    ."\r\n";
fwrite($file,$text);
fclose($file);
}


?>