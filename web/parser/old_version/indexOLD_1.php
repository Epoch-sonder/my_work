Выбираем архив:
<form enctype="multipart/form-data" action="" method="POST">
    <input name="userfile" type="file" /><br />
    <br />
    <select name="date">
        <option value="may">Май</option>
        <option value="june">Июнь</option>
    </select>
    <br /><br />
    <input type="submit" name="load" value="Загрузить xls" />
</form>

<?php
//$row[9] = 'Заготовка древесины
//Заготовка живицы
//Заготовка и сбор недревесных лесных ресурсов
//Заготовка пищевых лесных ресурсов и сбор лекарственных растений
//Осуществление видов деятельности в сфере охотничьего хозяйства
//Ведение сельского хозяйства
//Осуществление научно-исследовательской деятельности, образовательной деятельности
//Осуществление рекреационной деятельности
//Создание лесных плантаций и их эксплуатация
//Выращивание лесных плодовых, ягодных, декоративных растений, лекарственных растений
//Выращивание посадочного материала лесных растений (саженцев, сеянцев)
//Осуществление геологического изучения недр, разведка и добыча полезных ископаемых
//Строительство и эксплуатация водохранилищ и иных искусственных водных объектов, а также гидротехнических сооружений, морских портов, морских терминалов, речных портов, причалов
//Строительство, реконструкция, эксплуатация линейных объектов
//Переработка древесины и иных лесных ресурсов
//Осуществление религиозной деятельности';
//
//echo ' совпадений: '.similar_text($row[9],'Заготовка древесины').'<br>'; //37
//echo ' совпадений: '.similar_text($row[9],'Заготовка живицы').'<br>';  //31
//echo ' совпадений: '.similar_text($row[9],'Заготовка и сбор недревесных лесных ресурсов').'<br>'; //83
//echo ' совпадений: '.similar_text($row[9],'Заготовка пищевых лесных ресурсов и сбор лекарственных растений').'<br>'; //119
//echo ' совпадений: '.similar_text($row[9],'Осуществление видов деятельности в сфере охотничьего хозяйства').'<br>'; //118
//echo ' совпадений: '.similar_text($row[9],'Ведение сельского хозяйства').'<br>'; //52
//echo ' совпадений: '.similar_text($row[9],'Осуществление научно-исследовательской деятельности, образовательной деятельности').'<br>'; //156
//echo ' совпадений: '.similar_text($row[9],'Осуществление рекреационной деятельности').'<br>'; //78
//echo ' совпадений: '.similar_text($row[9],'Создание лесных плантаций и их эксплуатация').'<br>'; //81
//echo ' совпадений: '.similar_text($row[9],'Выращивание лесных плодовых, ягодных, декоративных растений, лекарственных растений').'<br>'; //156
//echo ' совпадений: '.similar_text($row[9],'Выращивание посадочного материала лесных растений (саженцев, сеянцев)').'<br>'; //129
//echo ' совпадений: '.similar_text($row[9],'Осуществление геологического изучения недр, разведка и добыча полезных ископаемых').'<br>'; //153
//echo ' совпадений: '.similar_text($row[9],'Строительство и эксплуатация водохранилищ и иных искусственных водных объектов, а также гидротехнических сооружений, морских портов, морских терминалов, речных портов, причалов').'<br>'; //328
//echo ' совпадений: '.similar_text($row[9],'Строительство, реконструкция, эксплуатация линейных объектов').'<br>'; //114
//echo ' совпадений: '.similar_text($row[9],'Переработка древесины и иных лесных ресурсов').'<br>'; //83
//echo ' совпадений: '.similar_text($row[9],'Осуществление религиозной деятельности').'<br>'; //74

//INSERT INTO Customers (CustomerName, ContactName, Address, City, PostalCode, Country)
//VALUES ('TEST','TEST','TEST','TEST','TEST','TEST');
$host='localhost'; // имя хоста (уточняется у провайдера)
$user='roslesinforg'; // заданное вами имя пользователя, либо определенное провайдером
$password='oXuZW7VOB9Ge'; // заданный вами пароль
$database='roslesinforg'; // имя базы данных, которую вы должны создать
$mysqli = new mysqli($host, $user, $password,$database) ;

if ($mysqli->connect_error) die('Не удалось подключиться к БД : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);


//foreach ($results as $result){
//    $result = $result;
//}



include("parser.php");

if(@$_POST["date"]){

    $uploaddir= '/var/www/html/roslesinforg/web/parser/tmp/';

    $loc = $uploaddir . $_FILES['userfile']['name'];

    move_uploaded_file($_FILES['userfile']['tmp_name'], $loc);

    /*************/

// Массив с названиями филиалов и их ID
    $branch = [1 =>'Филиал ФГБУ "Рослесинфорг" "Архангельсклеспроект"', 2 => 'Филиал ФГБУ "Рослесинфорг" "Дальлеспроект"', 3 => 'Филиал ФГБУ "Рослесинфорг" "Заплеспроект"', 4 => 'Филиал ФГБУ "Рослесинфорг" "Запсиблеспроект"', 5 => 'Филиал ФГБУ "Рослесинфорг" "Кареллеспроект"', 6 => 'Филиал ФГБУ "Рослесинфорг" "Мослеспроект"', 7 => 'Филиал ФГБУ "Рослесинфорг" "Поволжский леспроект"',8 => 'Филиал ФГБУ "Рослесинфорг" "Севзаплеспроект"', 9 => 'Филиал ФГБУ "Рослесинфорг" "Севлеспроект"', 10 => 'Филиал ФГБУ "Рослесинфорг" "Центрлеспроект"',
        11 => 'Филиал ФГБУ "Рослесинфорг" "Воронежлеспроект"', //11
        12 => 'Филиал ФГБУ "Рослесинфорг" "Востсиблеспроект"', 13 => 'Филиал ФГБУ "Рослесинфорг" "Прибайкаллеспроект"',
        14 => 'Филиал ФГБУ "Рослесинфорг" "Северо-Кавказский"', //14
        15 => 'Приморский филиал ФГБУ "Рослесинфорг"',
        16 => 'Филиал ФГБУ "Рослесинфорг" "Камчатский"', //16
        17 => 'Филиал ФГБУ "Рослесинфорг" "Амурский"', //17
        18 => 'Омский филиал ФГБУ "Рослесинфорг"', 19 => 'Томский филиал ФГБУ "Рослесинфорг"', 20 => 'Тюменский филиал ФГБУ "Рослесинфорг"', 21 => 'Уральский филиал ФГБУ "Рослесинфорг"',
        22 => 'Филиал ФГБУ "Рослесинфорг" "Ханты"', //22
        23 => 'Башкирский филиал ФГБУ "Рослесинфорг"', //23
        24 => 'Казанский филиал ФГБУ "Рослесинфорг"',
        25 => 'Филиал ФГБУ "Рослесинфорг" "Пензенский"', //25
        26 => 'Пермский филиал ФГБУ "Рослесинфорг"',
        27 => 'Филиал ФГБУ "Рослесинфорг" "Ульяновский"', //27
        28 => 'Вятский филиал ФГБУ "Рослесинфорг"',
        29 => 'Филиал ФГБУ "Рослесинфорг" "Коми"', //29
        30 => 'Тверской филиал ФГБУ "Рослесинфорг"',
        31 => 'Рязанский филиал ФГБУ "Рослесинфорг"', //31
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
    $countall = 1;
    foreach ( $xls->rows() as $r => $row ) {
        $complexOneRecord = 0;
        $value_complex =',"0"';
        $complex = 0;
        $this_pol = 0;
        if ($countall >= 1 and $countall <= 6) $bd_null = 1;
        else{
            $bd_null = 0;
            $query = 'SELECT * FROM   `pd_work` WHERE `code_1C` = "'. $row[15] .'"  LIMIT 1';
            $results = $mysqli->query($query);

            if (!$results->num_rows) $not_bd = 1;
            else $not_bd = 0;
        }

        // Запрос на дубликат
        if($not_bd){
            // Определение га или остальное
            if (strpos($row[13],'га')  !== false and $row[17] == true ){
                $comment = 'Выгрузка с 1С(Заполните поля: ';
                $area = $row[17];
            }
            elseif(strpos($row[13],'га') == false or $row[17] == false){
                $comment = 'Выгрузка с 1С(Заполните поля: Площадь по документу (га) ';
                $area = 0;
            }
            if ($comment == 'Выгрузка с 1С(Заполните поля: ')$comma = '';
            else $comma = ', ';


            if (!$row[16]){
                $row[16] = 0;
                $comment .= $comma.'Стоимость работ по документу (включая НДС 20%) [руб.коп]';
                $comma = ', ';
            }
            if ($row[7]){
                $customerName =  str_replace('"', "'", $row[7]);
            }
            else{
                $customerName = 'Не указано';
                $comment .= $comma.'Заказчик';
                $comma = ', ';
            }
            if (!$row[11]){
                $row[11] = 'Не указан';
                $comment .= $comma.'Номер документа';
                $comma = ', ';
            }




            if ($row[12]){
                $dataContract = new DateTime($row[12]);
                $dataContract = $dataContract->format('Y-m-d H:i:s');
            }
            else {
                $dataContract = $date;
                $comment .= $comma.'Дату заключения договора';
                $comma = ', ';
            }

            if ($row[14]){
                $dataEndings = new DateTime($row[14]);
                $dataEndings  = $dataEndings->format('Y-m-d H:i:s');
            }
            else {
                $dataEndings  = $date;
                $comment .= $comma.'Дату окончание договора ';
                $comma = ', ';
            }




            // Нет данных о Амурский(17), Воронежлеспроект(11), Тамбовский(33), Ханты(22), Марий Эл(32), Коми(29),
            if ($row[1] == $branch['2'] or $row[1] == $branch['17']) {
                if(strpos("$row[8]", "№ 043/") !== false) $idBranch =  $branches[$branch['17']];
                elseif(strpos("$row[8]", "№ 04/")!== false) $idBranch =  $branches[$branch['2']];
            }

            elseif ($row[1] == $branch['11'] or $row[1] == $branch['33']) {
                if(strpos("$row[8]", "№ 26/") !== false) $idBranch =  $branches[$branch['11']];
                elseif(strpos("$row[8]", "№ 05/") !== false) $idBranch =  $branches[$branch['33']];
            }
            elseif ($row[1] == $branch['4'] or $row[1] == $branch['22']) {
                if(strpos("$row[8]", "Счет-фактура") !== false) $idBranch =  $branches[$branch['22']];
                else $idBranch =  $branches[$branch['4']];
            }
            elseif ($row[1] == $branch['7'] or $row[1] == $branch['32']) {
                if(strpos("$row[8]", "№ 19/") !== false) $idBranch =  $branches[$branch['7']];
                elseif(strpos("$row[8]", "№ 14/") !== false) $idBranch =  $branches[$branch['32']];
            }
            elseif ($row[1] == $branch['9'] or $row[1] == $branch['29']) {
                if(strpos("$row[8]", "100-2/РК") !== false) $idBranch =  $branches[$branch['29']];
                else $idBranch =  $branches[$branch['9']];
            }
            else $idBranch =  $branches[$row[1]];



            $idSubject = $subjects[$row[10]];

            // Определение контракт или договор
            if(strpos("$row[8]", "контракт") !== false) $docs_type = 1;
            else $docs_type = 2;

            $idTypeUse = 17;
            $PIR = 0;
            $PIR_docs = 0;


            if (strpos("$row[6]", "Разработка проектов освоения лесов для всех видов пользования") !== false){
                $not_usage = 1;
                // Вид использования лесов
                $idType = 4;

                if(strpos($row[9],'Заготовка древесины') !== false){
                    if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                    $comment .= $comma.'Лесничества)';
                    $comma = ', ';
                    $not_usage = 0;
                    $idTypeUse = 1;
                   $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';

                    $results = $mysqli->query($query);
                    if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                }
                if(strpos($row[9],'Заготовка живицы') !== false ){
                    if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                    $comment .= $comma.'Лесничества)';
                    $comma = ', ';
                    $not_usage = 0;
                    $idTypeUse = 2;
                   $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';
                    $results = $mysqli->query($query);
                    if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                }
                if(strpos($row[9],'Заготовка и сбор недревесных лесных ресурсов') !== false ){
                    if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                    $comment .= $comma.'Лесничества)';
                    $comma = ', ';
                    $not_usage = 0;
                    $idTypeUse = 3;
                   $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';
                    $results = $mysqli->query($query);
                    if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                }
                if(strpos($row[9],'Заготовка пищевых лесных ресурсов и сбор лекарственных растений') !== false ){
                    if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                    $comment .= $comma.'Лесничества)';
                    $comma = ', ';
                    $not_usage = 0;
                    $idTypeUse = 4;
                   $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';
                    $results = $mysqli->query($query);
                    if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                }
                if(strpos($row[9],'Осуществление видов деятельности в сфере охотничьего хозяйства') !== false ){
                    if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                    $comment .= $comma.'Лесничества)';
                    $comma = ', ';
                    $not_usage = 0;
                    $idTypeUse = 5;
                   $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';
                    $results = $mysqli->query($query);
                    if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                }
                if(strpos($row[9],'Ведение сельского хозяйства') !== false ){
                    if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                    $comment .= $comma.'Лесничества)';
                    $comma = ', ';
                    $not_usage = 0;
                    $idTypeUse = 6;
                   $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';
                    $results = $mysqli->query($query);
                    if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                }
                if(strpos($row[9],'Осуществление научно-исследовательской деятельности, образовательной деятельности') !== false ){
                    if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                    $comment .= $comma.'Лесничества)';
                    $comma = ', ';
                    $not_usage = 0;
                    $idTypeUse = 7;
                   $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';
                    $results = $mysqli->query($query);
                    if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                }
                if(strpos($row[9],'Осуществление рекреационной деятельности')  !== false  ){
                    if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                    }
                    $complex = 1;
                    $comment .= $comma.'Лесничества)';
                    $comma = ', ';
                    $not_usage = 0;
                    $idTypeUse = 8;
                   $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';
                    $results = $mysqli->query($query);
                    if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                }
                if(strpos($row[9],'Создание лесных плантаций и их эксплуатация') !== false  ){
                    if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                    }
                    $complex = 1;
                    $comment .= $comma.'Лесничества)';
                    $comma = ', ';
                    $not_usage = 0;
                    $idTypeUse = 9;
                   $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';
                    $results = $mysqli->query($query);
                    if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                }
                if(strpos($row[9],'Выращивание лесных плодовых, ягодных, декоративных растений, лекарственных растений') !== false  ){
                    if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                    }
                    $complex = 1;
                    $comment .= $comma.'Лесничества)';
                    $comma = ', ';
                    $not_usage = 0;
                    $idTypeUse = 10;
                   $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';
                    $results = $mysqli->query($query);
                    if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                }
                if(strpos($row[9],'Выращивание посадочного материала лесных растений (саженцев, сеянцев)') !== false ){
                    if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                    $comment .= $comma.'Лесничества)';
                    $comma = ', ';
                    $not_usage = 0;
                    $idTypeUse = 11;
                   $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';

                     $results = $mysqli->query($query);
                    if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                }
                if(strpos($row[9],'Выполнение работ по геологическому изучению недр, разработка месторождений полезных ископаемых') !== false ){
                    if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                    $comment .= $comma.'Лесничества)';
                    $comma = ', ';
                    $not_usage = 0;
                    $idTypeUse = 12;
                   $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';

                     $results = $mysqli->query($query);
                    if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                }
                if(strpos($row[9],'Строительство и эксплуатация водохранилищ и иных искусственных водных объектов, а также гидротехнических сооружений и морских портов, морских терминалов, речных портов, причалов') !== false  ){
                    if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                    $comment .= $comma.'Лесничества)';
                    $comma = ', ';
                    $not_usage = 0;
                    $idTypeUse = 13;
                   $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';

                     $results = $mysqli->query($query);
                    if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                }

                if(strpos($row[9],'Строительство, реконструкция, эксплуатация линейных объектов') !== false  ){
                    if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                    $comment .= $comma.'Лесничества)';
                    $comma = ', ';
                    $not_usage = 0;
                    $idTypeUse = 14;
                   $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';

                     $results = $mysqli->query($query);
                    if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                }
                if(strpos($row[9],'Переработка древесины и иных лесных ресурсов') !== false  ){
                    if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                    $comment .= $comma.'Лесничества)';
                    $comma = ', ';
                    $not_usage = 0;
                    $idTypeUse = 15;
                   $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';

                     $results = $mysqli->query($query);
                    if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                }
                if(strpos($row[9],'Осуществление религиозной деятельности') !== false ){
                    if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                    $comment .= $comma.'Лесничества)';
                    $comma = ', ';
                    $not_usage = 0;
                    $idTypeUse = 16;
                   $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';

                    $results = $mysqli->query($query);
                    if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                }
                if ($not_usage){
                    if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                    }
                    $complex = 1;
                    $comment .= $comma.'Вид использования лесов, Лесничества)';
                    $comma = ', ';
                    $not_usage = 1;
                    $idTypeUse = 17;
                   $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';
                    $results = $mysqli->query($query);
                    if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                }



            }

            elseif (strpos($row[6],'Проектно-изыскательские работы') !== false ) {
                $PIR = 1;
            }

            if(strpos($row[9],'Лесной план') !== false ){
                if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                    $comment .= $comma.'Лесничества)';
                    $comma = ', ';
                $PIR_docs = 1;
                // Вид использования лесов
                $idType = 1;
                $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';
                    $results = $mysqli->query($query);
                if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
            }

            if(strpos($row[9],'Лесохозяйственный регламент') !== false ){
                if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                if ($comment{strlen($comment)-1} == ', Лесничества)') $comment = substr($comment,0,-1) . $comma.'Лесничества)';
                else $comment .= $comma.'Лесничества)';
                $comma = ', ';
                // Вид использования лесов
                $idType = 2;
                $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';
                $results = $mysqli->query($query);
                if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                $PIR_docs = 1;
            }
            if(strpos($row[9],'Проектная документация лесного участка (приказ МПР № 54)') !== false ){
                if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                $complex = 1;
                if ($comment{strlen($comment)-1} == ', Лесничества)') $comment = substr($comment,0,-1) . $comma.'Лесничества)';
                else $comment .= $comma.'Лесничества)';
                $comma = ', ';
                // Вид использования лесов
                $idType = 3;
                $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';
                    $results = $mysqli->query($query);
                if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                $PIR_docs = 1;
            }
//            if(similar_text($row[9],'Проект освоения лесов (ПОЛ)') >= 102 and $this_pol){
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
//                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';
//                    $results = $mysqli->query($query);
//                if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
//                $PIR_docs = 1;
//            }
            if(strpos($row[9],'Проект рекультивации нарушенных земель')  !== false ){
                if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                    if ($comment{strlen($comment)-1} == ', Лесничества)') $comment = substr($comment,0,-1) . $comma.'Лесничества)';
                else $comment .= $comma.'Лесничества)';
                $comma = ', ';
                // Вид использования лесов
                $idType = 5;
                $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';
                    $results = $mysqli->query($query);
                if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                $PIR_docs = 1;
            }
            if(strpos($row[9],'Лесная декларация')  !== false ){
                if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                if ($comment{strlen($comment)-1} == ', Лесничества)') $comment = substr($comment,0,-1) . $comma.'Лесничества)';
                else $comment .= $comma.'Лесничества)';
                $comma = ', ';
                // Вид использования лесов
                $idType = 6;
                $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';
                    $results = $mysqli->query($query);
                if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                $PIR_docs = 1;
            }
            if(strpos($row[9],'Отчет об использовании (защите, воспроизводстве) лесов')  !== false ){
                if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                if ($comment{strlen($comment)-1} == ', Лесничества)') $comment = substr($comment,0,-1) . $comma.'Лесничества)';
                else $comment .= $comma.'Лесничества)';
                $comma = ', ';
                // Вид использования лесов
                $idType = 7;
                $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';
                    $results = $mysqli->query($query);
                if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                $PIR_docs = 1;
            }
            if(strpos($row[9],'Проект лесовосстановления (лесоразведения)')  !== false ){
                if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                if ($comment{strlen($comment)-1} == ', Лесничества)') $comment = substr($comment,0,-1) . $comma.'Лесничества)';
                else $comment .= $comma.'Лесничества)';
                $comma = ', ';
                // Вид использования лесов
                $idType = 8;
                $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';
                    $results = $mysqli->query($query);
                if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                $PIR_docs = 1;
            }
            if(strpos($row[9],'Проект по изменению целевого назначения лесов (ст. 81 ЛК РФ)')  !== false ){
                if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                if ($comment{strlen($comment)-1} == ', Лесничества)') $comment = substr($comment,0,-1) . $comma.'Лесничества)';
                else $comment .= $comma.'Лесничества)';
                $comma = ', ';
                // Вид использования лесов
                $idType = 9;
                $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';
                    $results = $mysqli->query($query);
                if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                $PIR_docs = 1;
            }
            if(strpos($row[9],'Проект по проектированию особо защитных участков лесов')  !== false ){
                if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                if ($comment{strlen($comment)-1} == ', Лесничества)') $comment = substr($comment,0,-1) . $comma.'Лесничества)';
                else $comment .= $comma.'Лесничества)';
                $comma = ', ';
                // Вид использования лесов
                $idType = 10;
                $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';
                    $results = $mysqli->query($query);
                if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                $PIR_docs = 1;
            }
            if(strpos($row[9],'Проект установления (изменения) границ лесопарковых и зеленых зон')  !== false ){
                if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                    if ($comment{strlen($comment)-1} == ', Лесничества)') $comment = substr($comment,0,-1) . $comma.'Лесничества)';
                else $comment .= $comma.'Лесничества)';
                $comma = ', ';
                // Вид использования лесов
                $idType = 11;
                $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';
                    $results = $mysqli->query($query);
                if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                $PIR_docs = 1;
            }
            if(strpos($row[9],'Установление лесопаркового зеленого пояса')  !== false ){
                if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                   if ($comment{strlen($comment)-1} == ', Лесничества)') $comment = substr($comment,0,-1) . $comma.'Лесничества)';
                else $comment .= $comma.'Лесничества)';
                $comma = ', ';
                // Вид использования лесов
                $idType = 12;
                $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';
                    $results = $mysqli->query($query);
                if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                $PIR_docs = 1;
            }
            if(strpos($row[9],'Проект планирования территории')  !== false ){
                if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                if ($comment{strlen($comment)-1} == ', Лесничества)') $comment = substr($comment,0,-1) . $comma.'Лесничества)';
                else $comment .= $comma.'Лесничества)';
                $comma = ', ';
                // Вид использования лесов
                $idType = 13;
                $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';
                    $results = $mysqli->query($query);
                if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                $PIR_docs = 1;
            }
            if(strpos($row[9],'Проект межевания территории')  !== false ){
                if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                   if ($comment{strlen($comment)-1} == ', Лесничества)') $comment = substr($comment,0,-1) . $comma.'Лесничества)';
                else $comment .= $comma.'Лесничества)';
                $comma = ', ';
                // Вид использования лесов
                $idType = 14;
                $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';
                    $results = $mysqli->query($query);
                if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                $PIR_docs = 1;
            }
            if(strpos($row[9],'Перевод из состава земель лесного фонда')  !== false ){
                if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                   if ($comment{strlen($comment)-1} == ', Лесничества)') $comment = substr($comment,0,-1) . $comma.'Лесничества)';
                else $comment .= $comma.'Лесничества)';
                $comma = ', ';
                // Вид использования лесов
                $idType = 15;
                $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';
                    $results = $mysqli->query($query);
                if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                $PIR_docs = 1;
            }
            if(strpos($row[9],'Проект противопожарного обустройства лесов')  !== false ){
                if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                   if ($comment{strlen($comment)-1} == ', Лесничества)') $comment = substr($comment,0,-1) . $comma.'Лесничества)';
                else $comment .= $comma.'Лесничества)';
                $comma = ', ';
                // Вид использования лесов
                $idType = 17;
                $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';
                    $results = $mysqli->query($query);
                if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                $PIR_docs = 1;
            }
            if(strpos($row[9],'Проект организации охотничьего хозяйства')  !== false ){
                if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                   if ($comment{strlen($comment)-1} == ', Лесничества)') $comment = substr($comment,0,-1) . $comma.'Лесничества)';
                else $comment .= $comma.'Лесничества)';
                $comma = ', ';
                // Вид использования лесов
                $idType = 18;
                $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';
                    $results = $mysqli->query($query);
                if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                $PIR_docs = 1;
            }
            if(strpos($row[9],'Проект организации территории ООПТ')  !== false ){
                if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                    if ($comment{strlen($comment)-1} == ', Лесничества)') $comment = substr($comment,0,-1) . $comma.'Лесничества)';
                else $comment .= $comma.'Лесничества)';
                $comma = ', ';
                // Вид использования лесов
                $idType = 19;
                $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';
                    $results = $mysqli->query($query);
                if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                $PIR_docs = 1;
            }
            if(strpos($row[9],'Проект реконструкции усадебного парка')  !== false ){
                if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                if ($comment{strlen($comment)-1} == ', Лесничества)') $comment = substr($comment,0,-1) . $comma.'Лесничества)';
                else $comment .= $comma.'Лесничества)';
                $comma = ', ';
                // Вид использования лесов
                $idType = 20;
                $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';
                    $results = $mysqli->query($query);
                if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                $PIR_docs = 1;
            }
            if(strpos($row[9],'Проект оценки воздействия на окружающую среду (ОВОС)')  !== false ){
                if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                    if ($comment{strlen($comment)-1} == ', Лесничества)') $comment = substr($comment,0,-1) . $comma.'Лесничества)';
                else $comment .= $comma.'Лесничества)';
                $comma = ', ';
                // Вид использования лесов
                $idType = 21;
                $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';
                    $results = $mysqli->query($query);
                if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                $PIR_docs = 1;
            }
            if(strpos($row[9],'Проект организации санитарно-защитной зоны')  !== false ){
                if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                   if ($comment{strlen($comment)-1} == ', Лесничества)') $comment = substr($comment,0,-1) . $comma.'Лесничества)';
                else $comment .= $comma.'Лесничества)';
                $comma = ', ';
                // Вид использования лесов
                $idType = 22;
                $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';
                    $results = $mysqli->query($query);
                if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                $PIR_docs = 1;
            }
            if(strpos($row[9],'Проект нормативов предельно допустимых выбросов (ПДВ)')  !== false ){
                if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                if ($comment{strlen($comment)-1} == ', Лесничества)') $comment = substr($comment,0,-1) . $comma.'Лесничества)';
                else $comment .= $comma.'Лесничества)';
                $comma = ', ';
                // Вид использования лесов
                $idType = 23;
                $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';
                    $results = $mysqli->query($query);
                if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                $PIR_docs = 1;
            }
            if(strpos($row[9],'Проект нормативов образования отходов и лимитов на их размещение (ПНООЛР)')  !== false ){
                if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                    $complex = 1;
                if ($comment{strlen($comment)-1} == ', Лесничества)') $comment = substr($comment,0,-1) . $comma.'Лесничества)';
                else $comment .= $comma.'Лесничества)';
                $comma = ', ';
                // Вид использования лесов
                $idType = 24;
                $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$value_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'",": ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'" )';
                    $results = $mysqli->query($query);
                if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
                $PIR_docs = 1;
            }


            if (!$PIR_docs and $PIR){

                if ($complex) {
                    $value_complex =',"1"';
                    $complexOneRecord = 1;
                }
                $complex = 1;
                if ($comment{strlen($comment)-1} == ', Лесничества)') $comment = substr($comment,0,-1) . $comma.'Лесничества, Укажите наименование работ , Вид использования лесов)';
                else $comment .= $comma.'Лесничества, Укажите наименование работ , Вид использования лесов)';
                $comma = ', ';
                // Вид использования лесов
                $idType = 25;
                $idTypeUse = 17;

                // Запрос на создание
                $query = 'INSERT INTO pd_work(`branch`'.$tb_complex.',`customer`,`basedoc_type`,`basedoc_name`,`basedoc_datasign`,`basedoc_datefinish`,`work_cost`,`work_datastart`,`federal_subject`,`work_name`,`work_area`,`work_othername`,`work_reason`,`forest_usage`,`comment`,`code_1C` )
                    VALUES ("'.$idBranch.'"'.$tb_complex.',"'.$customerName.' ","'.$docs_type.'","'.$row[11].' ","'.$dataContract.' ","'.$dataEndings.' ","'.$row[16].'","'.$date.' ","'.$idSubject.'","'.$idType.'","'.$area.'","Иные ","1","'.$idTypeUse.'","'.$comment.'","'.$row[15].'")';
                    $results = $mysqli->query($query);
                if ($results) { echo '№'.  ++$count .' Запись' . $row[0].' добавлена <br>'; } else  {echo '№'.  ++$count .' Ошибка записи'. $row[0] .'<br>' ; var_dump($query); echo '<br>' ; }
            }
            if ($complexOneRecord){
                $query = 'UPDATE `pd_work` SET `in_complex` = REPLACE(`in_complex`,"0","1") WHERE `code_1C` = "'. $row[15].'" and `in_complex` = "0"';
                $results = $mysqli->query($query);
            }

        }
        elseif ($bd_null) {echo '';}
        else {
            echo '№'.  ++$count .' Запись '.$row[0].' в базе данных <br>';
        }
        $countall++;
    }


//    echo '<br><br>EXCEL разбор:<pre>';
//    print_r($xls->rows());
//    echo '</pre>';


}

?>