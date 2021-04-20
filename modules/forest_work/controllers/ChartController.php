<?php

namespace app\modules\forest_work\controllers;

use Yii;
use app\modules\forest_work\models\ForestWork;
use app\modules\forest_work\models\SearchForestWork;
use app\modules\pd\models\PdWork;
use app\modules\pd\models\SearchPdWork;
use app\modules\forest_work\models\Branch;
use app\modules\forest_work\models\FederalSubject;
use app\modules\forest_work\models\ResponsibilityArea;
use app\modules\forest_work\models\ReportDateRequest;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\Pagination;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;

/**
 * ForestworkController implements the CRUD actions for ForestWork model.
 */
class ChartController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ForestWork models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new SearchForestWork();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Для пользователей не из ЦА выводим только отчеты их филиала
        $branchID = Yii::$app->user->identity->branch_id;
        if($branchID != 0) $dataProvider->query->andWhere("forest_work.branch_id = $branchID");




        $works = ForestWork::find()->select(['federal_subject_id', 'branch_id', 'date', 'a1', 'a2', 'a3', 'a4', 'a5', 'a6', 'a7', 'a8', 'a9', 'a10', 'a11', 'a12', 'a13', 'a14', 'a15', 'a16', 'a17'])->where("branch_id = $branchID") -> orderBy(['date' => SORT_ASC], ['federal_subject_id' => SORT_ASC])->all();
        $subjects = FederalSubject::find()->select(['federal_subject_id', 'name'])->all();
        $branches = Branch::find()->select(['branch_id', 'name'])->where("branch_id = $branchID")->all(); 


       // $startdate = strtotime('2021-01-01');
       $startdate = "2021-01-01";
        if ($branchID != 0) {
            foreach ($subjects as $subject) {
                $subID = $subject->federal_subject_id; //обращение к id субъекта
                $subName = $subject->name; //название субъекта
                $i=0;
                foreach ($works as  $work) {
                    if ($subID == $work->federal_subject_id){
                       if ($work->date >= $startdate) {
                        $date = $work->date; //дата
                        //if (strtotime($date) >= $startdate){
                            $mtime = strtotime($date) * 1000; //перевод даты в нужный формат
                            $sumA = 0;

                            for ($j = 1; $j <= 17; $j++) $sumA += $work->{"a".$j};  //сумма всех проектов

                    // foreach ($subjects as $subject) {
                    //     if ($subID == $subject->federal_subject_id){
                    //         $subName = $subject->name; //название субъекта
                    //     }
                    // }

               
                           if ($i != 0 && $mtime == $plotdepend[$subName][$i-1][0]){ 
                               $plotdepend[$subName][$i-1][1] = $sumA; //когда повторяется дата
                            }   else {
                                $plotdepend[$subName][] = [$mtime, $sumA]; //формируем массив
                            $i++;
                         } 
                            $NameSub[] = $subName;       
                        }
                    }
                }
            }
        }
        else {
            $plotdepend = 0;
            $NameSub[] = 'none';
        }

        foreach ($branches as $branch) {
                $branchName = $branch->name;
        }

       $nameUn = array_unique($NameSub); //массив с уникальными значениями субъектов
       $nameSort = array_values($nameUn); //меняем ключи массива

        echo '<pre>';
        var_dump($startdate);
        echo '</pre>';





        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'plotdepend' => $plotdepend,
            'branchID' => $branchID,
            'branchName' => $branchName,
            'nameSort' =>$nameSort,
        ]);
    }


    public function actionChart()
    {
         $forestworks = ForestWork::find()->select(['date', 'a1', 'a2', 'a3', 'a4', 'a5', 'a6', 'a7', 'a8', 'a9', 'a10', 'a11', 'a12', 'a13', 'a14', 'a15', 'a16', 'a17'])->where('branch_id = 5') -> orderBy(['date' => SORT_ASC])->all();

        foreach ($forestworks as $forestwork) {
            $date = $forestwork->date;
            $dates[]=$date;
            $sum = $forestwork->a1 + $forestwork->a2 + $forestwork->a3 + $forestwork->a4  + $forestwork->a5 + $forestwork->a6 + $forestwork->a7 + $forestwork->a8  + $forestwork->a9 + $forestwork->a10 + $forestwork->a11 + $forestwork->a12  + $forestwork->a13  + $forestwork->a14 + $forestwork->a15 + $forestwork->a16  + $forestwork->a17; //сумма всех проектов
            $asum[]=$sum;

         };



         $works = ForestWork::find()->select(['branch_id', 'federal_subject_id', 'date', 'a1', 'a2', 'a3', 'a4', 'a5', 'a6', 'a7', 'a8', 'a9', 'a10', 'a11', 'a12', 'a13', 'a14', 'a15', 'a16', 'a17'])->where('branch_id = 4') -> orderBy(['date' => SORT_ASC])->all();
         $subjects = FederalSubject::find()->select(['federal_subject_id', 'name'])->all();

        foreach ($subjects as $subject) {
            $subID = $subject->federal_subject_id;
            $subName = $subject->name; //название субъекта
            $i=0;
            foreach ($works as  $work) {

                if ($subID == $work->federal_subject_id){
                    $date = $work->date; //дата
                    $mtime = strtotime($date) * 1000; //перевод даты в нужный формат
                    $sumA = 0;
                
                    for ($j = 1; $j <= 17; $j++) $sumA += $work->{"a".$j};  //сумма всех проектов
                
                    if ($i != 0 && $mtime == $plotdepend[$subName][$i-1][0]){ 
                        $plotdepend[$subName][$i-1][1] = $sumA; //когда повторяется дата
                    } else {
                        $plotdepend[$subName][$i] = [$mtime, $sumA]; //формируем массив
                        $i++;
                    }
                }
            }
        }


        ob_start();

        echo "<pre>";

        echo '<br>Сегодня: '.date("d.m.Y");


        // ищем первый понедельник года
        $y = date("Y"); // определяем текущий год
        $date = new \DateTime("01.01.{$y}"); // Экранируем функцию Datetime, чтоб воспринималась как php-объект
        // print_r ($date);
        echo "<br>Начальная дата отсчета: ".$date->format("d.m.Y");
        
        // До тех пор, пока номер дня недели не равен 1 (ПН) прибавляем к дате 1 день
        while ($date->format("N") !== "1") {
            $date->add(new \DateInterval("P1D"));
        }

        // Убеждаемся что определенная дата начала недели - понедельник
        if ($date->format("N") === "1") {
            $monday = clone $date; // Принудительно клонируем дату, иначе обе переменных будут указывать на один и тот же объект, и при изменении одного будет меняться и второй
            $sunday = clone $date->add(new \DateInterval("P6D"));
            // $date->add(new \DateInterval("P6D"));
            echo "<br><br>";

            // убеждаемся в том, что переменные содержат независимые (собственные) значения
            // var_dump($monday);
            // var_dump($sunday);
            // var_dump($date);

            // $sunday = $date->add(new \DateInterval("P6D"));
            
            // Если дата окончания недели укладывается до текущей даты
            $i = 1;
            while ($sunday->format("Y-m-d") < date("Y-m-d")) {

                echo "<br>$i. пн-вс: " . $monday->format("d.m.Y") . " - " . $sunday->format("d.m.Y");
                echo ' Сравниваем даты: ' . $sunday->format("Y-m-d"). ' и ' . date("Y-m-d");
                echo " -> Дата прошлая, продолжаем";

                // Сдвигаем границы недели на 7 дней вперед
                $monday->add(new \DateInterval("P7D"));
                $sunday->add(new \DateInterval("P7D"));
                $i++;
            }









            echo "<br><br>$i. пн-вс: " . $monday->format("d.m.Y") . " - " . $sunday->format("d.m.Y")."<br>";
            echo " -> Это текущая неделя, останавливаемся";
        }

        // Сдвигаем границы недели на 7 дней вперед
        // function plusWeek($day) {
        //     $day->add(new \DateInterval("P7D"));
        //     return $day;
        // }
          


            // if ($flag === true) // если текущая дата - ПН
            // {
            //     echo $date->format("d.m")."\t";
            //     $date->add(new \DateInterval("P1W"));
            // }
            // if ($m != $date->format("m"))
            // {
            //     $m = $date->format("m");
            //     echo "\r\n\r\n";
            // }
        
        echo "</pre>";

        $req = ob_get_contents();
        ob_end_clean();



        $searchModel = new SearchForestWork();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Для пользователей не из ЦА выводим только отчеты их филиала
        // $branchID = Yii::$app->user->identity->branch_id;
        $branchID = 24;
        $subjectID = 11;
        // if($branchID != 0) $dataProvider->query->andWhere("forest_work.branch_id = $branchID");

        $dataProvider->query->andWhere("forest_work.branch_id = $branchID")->andWhere("forest_work.federal_subject_id = $subjectID");
       // $forestworks = ForestWork::find()->select(['date', ])->where('branch_id == 5') -> orderBy(['date' => SORT_ASC])->all;

        $thisyear = date ('2020-12-31'); //начало текущего года

        $dateComp = ['<','date', "$thisyear"];




        $pdworks = PdWork::find()->select(['work_name', 'forest_usage', 'date_create', 'completed'])->orderBy(['date_create' => SORT_ASC])->all();

    
        $typeusework = array (1 =>'Заготовка древесины', 'Заготовка живицы', 'Заготовка и сбор недревесных лесных ресурсов', 'Заготовка пищевых лесных ресурсов и сбор лекарственных растений', 'Осуществление видов деятельности в сфере охотничьего хозяйства', 'Ведение сельского хозяйства', 'Научно-исследовательская и образовательная деятельность', 'Рекреационная деятельность', 'Создание лесных плантаций и их эксплуатация', 'Выращивание лесных плодовых, ягодных, декоративных, лекарственных растений',  'Выращивание посадочного материала лесных растений (саженцев, сеянцев)', 'Геологическое изучение недр, разведка и добыча полезных ископаемых', 'Строительство и эксплуатация водоёмов и водных объектов', 'Строительство, реконструкция, эксплуатация линейных объектов', 'Переработка древесины и иных лесных ресурсов', 'Религиозная деятельность', 'Иные виды');


       
        $usage = array_fill(1, 17, 0); //массив с к-вом по каж. виду работ, изначально нулевой
        foreach ($pdworks as $pdwork) {
            if ($pdwork->work_name != 1 && $pdwork->work_name != 2){
                for ($i = 1; $i <= 17; $i++){
                    if ($pdwork->forest_usage == $i){
                        $usage[$i] += 1;  //прибавляем
                    }
                }
            }
        }



        for ($k=1; $k<=17; $k++){
            $plotmassiv[$k]['name'] = $typeusework[$k]; //массив, к-й будет использоваться в графике
            $plotmassiv[$k]['y'] = $usage[$k];
        }



 

        // echo '<pre>';
        // var_dump($plotmassiv);
        // echo '</pre>';
//код для графика по видам документации 

        $pdtypework = array (1=>'Лесной план', 'Лесохозяйственный регламент', 'Проектная документации лесного участка', 'Проект освоения лесов', 'Проект рекультивации нарушенных земель', 'Лесная декларация', 'Отчет об использовании (защите, воспроизводстве) лесов', 'Проект лесовосстановления', 'Проект по изменению целевого назначения лесов', 'Проект по проектированию ОЗУ лесов', 'Проект установления (изменения) границ лесопарковых зон (зеленых зон)', 'Установление лесопаркового зеленого зона', 'Проект планирования территории', 'Проект межевания территории', 'Перевод из состава земель лесного фонда', 'Концепция инвестиционного проекта', 'Проект противопожарного обустройства лесов', 'Проект организации охотничьего хозяйства', 'Проект организации территории ООПТ', 'Проект реконструкции усадебного парка', 'Проект оценки на окружающую среду', 'Проект организации санитарно-защитной зоны', 'Проект нормативов предельно допустимых выбросов', 'Проект нормативов образования отходов и лимитов на их размещение', 'Прочие проекты');

        $today = date('Y-m-d');
        $contrdate = date('Y-03-01');
        $lastyear = date ('Y-01-01', strtotime('-1 year')); //начало прошлого года
        $thisyear = date ('Y-01-01'); //начало текущего года
        $nextyear = date ('Y-01-01', strtotime('+1 year')); //начало следующего года

        if ($today < $contrdate){  
            $dateComp =  ['and' , [">=", "fact_datefinish", "$lastyear"], ['<','fact_datefinish', "$thisyear"]];
            $titleName = 'Итоги 2020 года';
        } else {
            $dateComp = ['and' , ['>=', 'fact_datefinish', "$thisyear"], ['<','fact_datefinish', "$nextyear"]];
            $titleName = 'Разработанная проектная документация в текущем году';
        }

       // Запрос завершенных работ за год
        $pdwork_closed = PdWork::find()
            ->select(['work_type' =>'work_name', 'forestry_qnty' => 'SUM(IF(forestry_quantity = 0 or forestry_quantity is NULL, 1, forestry_quantity))', 'row_qnty' => 'COUNT(*)' ])
            ->groupBy('work_name')
            ->where("completed = 1")
            ->andWhere($dateComp)
            ->all();

        // Количество завершенной документации
        $ttl_lp = $ttl_lhr = $ttl_pol = $ttl_other = $lhr_contracts = 0;
        foreach ($pdwork_closed as $pdwork) {
            if ($pdwork->work_type == 1) $ttl_lp = $pdwork->row_qnty; // лесных планов
            elseif ($pdwork->work_type == 2) {
                $ttl_lhr = $pdwork->forestry_qnty; // ЛХР, учитываем кол-во лесничеств
                $lhr_contracts = $pdwork->row_qnty; // ЛХР, количество контрактов
            }
            elseif ($pdwork->work_type == 4) $ttl_pol = $pdwork->forestry_qnty; // ПОЛ, учитываем кол-во лесничеств
            elseif ($pdwork->work_type == 13 || $pdwork->work_type == 14) $ttl_other += $pdwork->row_qnty; // учитываем кол-во договоров
            else $ttl_other += $pdwork->forestry_qnty; //учитываем кол-во лесничеств
        }
        $ttl_pd = $ttl_lp + $ttl_lhr + $ttl_pol + $ttl_other; // всего

        settype($ttl_lp, 'integer'); 
        settype($ttl_lhr, 'integer');
        settype($ttl_pol, 'integer');
        settype($ttl_other, 'integer');
        settype($ttl_pd, 'integer');

        
    //подсчет документации в работе
    
       $ttlinw_pd = $ttlinw_lp = $ttlinw_lhr = $ttlinw_pol = $ttlinw_other = $lhrinw_contracts = 0;

       $ttlinw_dlu = $ttlinw_rnz = $ttlinw_ld = $ttlinw_useles = $ttlinw_plv = $ttlinw_pincl = $ttlinw_ozu = $ttlinw_puglz = $ttlinw_ulpzp = $ttlinw_ppt = $ttlinw_pmt = $ttlinw_transfer = $ttlinw_kip = $ttlinw_fireprev = $ttlinw_hunt = $ttlinw_oopt = $ttlinw_prup = $ttlinw_ovos = $ttlinw_szz = $ttlinw_pdv = $ttlinw_pnoolr = 0;


       $completed = 0;


        if(!$completed) {
                        
            // Количество документов в работе:
            $pdwork_active = PdWork::find()
                ->select(['work_type' =>'work_name', 'forestry_qnty' => 'SUM(IF(forestry_quantity = 0 or forestry_quantity is NULL, 1, forestry_quantity))', 'row_qnty' => 'COUNT(*)' ])
                ->groupBy('work_name')
                ->where("completed = 0")
                ->all();
            
            
            foreach ($pdwork_active as $pdwork) {
                if ($pdwork->work_type == 1) $ttlinw_lp = $pdwork->row_qnty; // лесных планов
                elseif ($pdwork->work_type == 2) {
                    $ttlinw_lhr = $pdwork->forestry_qnty; // ЛХР, учитываем кол-во лесничеств
                    $lhrinw_contracts = $pdwork->row_qnty; // ЛХР, количество контрактов
                }
                elseif ($pdwork->work_type == 4) $ttlinw_pol = $pdwork->forestry_qnty; // ПОЛ, учитываем кол-во лесничеств
                elseif ($pdwork->work_type == 3) $ttlinw_dlu += $pdwork->forestry_qnty; //проектная документация лесного участка
                elseif ($pdwork->work_type == 5) $ttlinw_rnz += $pdwork->forestry_qnty; //проект рекультивации нарушенных земель
                elseif ($pdwork->work_type == 6) $ttlinw_ld += $pdwork->forestry_qnty; //лесная декларация
                elseif ($pdwork->work_type == 7) $ttlinw_useles += $pdwork->forestry_qnty; //отчет об использовании (защите, воспроиизводстве) лесов
                elseif ($pdwork->work_type == 8) $ttlinw_plv += $pdwork->forestry_qnty; //проект лесовосстановления
                elseif ($pdwork->work_type == 9) $ttlinw_pincl += $pdwork->forestry_qnty; //проект изменения целевого назначения лесов
                elseif ($pdwork->work_type == 10) $ttlinw_ozu += $pdwork->forestry_qnty; //проект по проектированию особо защитных участков
                elseif ($pdwork->work_type == 11) $ttlinw_puglz += $pdwork->forestry_qnty; //проект установления (изменения) границ лесопарковых зон (зеленых зон)
                elseif ($pdwork->work_type == 12) $ttlinw_ulpzp += $pdwork->forestry_qnty; //установление лесопаркового зеленого пояса
                elseif ($pdwork->work_type == 13) $ttlinw_ppt += $pdwork->row_qnty; //проект планирования территории
                elseif ($pdwork->work_type == 14) $ttlinw_pmt += $pdwork->row_qnty; //проект межевания территории 
                elseif ($pdwork->work_type == 15) $ttlinw_transfer += $pdwork->forestry_qnty; //перевод из состава земель лесного фонда
                elseif ($pdwork->work_type == 16) $ttlinw_kip += $pdwork->forestry_qnty; //концепция инвестиционного рынка
                elseif ($pdwork->work_type == 17) $ttlinw_fireprev += $pdwork->forestry_qnty; //проект противопожарного обустройства лесов
                elseif ($pdwork->work_type == 18) $ttlinw_hunt += $pdwork->forestry_qnty; //проект организации охотничьего хозяйства
                elseif ($pdwork->work_type == 19) $ttlinw_oopt += $pdwork->forestry_qnty; //проект организации ООПТ
                elseif ($pdwork->work_type == 20) $ttlinw_prup += $pdwork->forestry_qnty; //проект организации усадебного парка
                elseif ($pdwork->work_type == 21) $ttlinw_ovos += $pdwork->forestry_qnty; //проект оценки на окружающую среду
                elseif ($pdwork->work_type == 22) $ttlinw_szz += $pdwork->forestry_qnty;//проект организации санитарно-защитной зоны
                elseif ($pdwork->work_type == 23) $ttlinw_pdv += $pdwork->forestry_qnty;//проект нормативов предельно допустимых выбросов
                elseif ($pdwork->work_type == 24) $ttlinw_pnoolr += $pdwork->forestry_qnty; //проект нормативов образования отходов и лимитов на их размещение
                else $ttlinw_other += $pdwork->forestry_qnty; //учитываем кол-во лесничеств
            }
            $ttlinw_pd = $ttlinw_lp + $ttlinw_lhr + $ttlinw_pol + $ttlinw_other; // всего

           /* $ttlinw_dlu;
            $ttlinw_rnz;
            $ttlinw_ld;
            $ttlinw_useles;
            $ttlinw_plv;
            $ttlinw_pincl;            
            $ttlinw_ozu;
            $ttlinw_puglz;
            $ttlinw_ulpzp;
            $ttlinw_ppt;
            $ttlinw_pmt;
            $ttlinw_transfer;
            $ttlinw_kip; 
            $ttlinw_fireprev;
            $ttlinw_hunt;
            $ttlinw_oopt;
            $ttlinw_prup;
            $ttlinw_ovos;
            $ttlinw_szz;
            $ttlinw_pdv;
            $ttlinw_pnoolr;*/
            

           settype($ttlinw_lp, 'integer'); 
           settype($ttlinw_lhr, 'integer');
           settype($ttlinw_pol, 'integer');
           settype($ttlinw_other, 'integer');
           settype($ttlinw_pd, 'integer');
        

           }

           //перевод даты 
           //$mtime = strtotime($date) * 1000;


        //код для графика по датам
           $j = 0;
           $count = 0; //счетчик числа добавленых отчетов в сутки
           $countAll = 0; //счетчик числа добавленых отчетов всего
           foreach ($pdworks as $pdwork) {
                if ($pdwork->date_create != NULL) {
                    $dataCreate[$j] = $pdwork->date_create; //массив со всеми датами
                    if ($j !=0){
                        if ($dataCreate[$j] != $dataCreate[$j-1]){ 
                            $dataOne[] = $pdwork->date_create; //массив с уникальными датами
                            $quantity[] = $count; //массив с числом отчетов за каж. дату
                            $count = 0; //счетчик сбрасывается, когда дата меняется
                            $quantityAll[] = $countAll; //массив с числом отчетов всего за каж. дату
                        }
                    }
                    else $dataOne[] = $pdwork->date_create;
                    $count++;
                    $countAll++;
                    if ($pdwork->completed == 1) $countAll--;
                    $j++;
                }
           }
        $quantity[] = $count;   //добавляем последнее число в массив
        $quantityAll[] = $countAll; //добавляем последнее число в массив

        for ($i=0; $i < count($dataOne); $i++) { 
            $dataOneChange[$i] = date("d-m-Y", strtotime($dataOne[$i]));
            $depension[$i] = [strtotime($dataOne[$i])*1000, $quantityAll[$i]]; //формируем зависимость кол-ва от времени и переводим время в нужный формат
        }

// echo '<pre>';
// var_dump($quantityAll);
// var_dump($dataOne);
// //echo $count;
// echo '</pre>';


        // foreach ($pdworks as $pdwork) {
        //     if ($pdwork->date_create == $yesterday) {
        //         echo "Hello!";
        //     }
        // }


//код для вертикального графика

    $branches = Branch::find()->select(['branch_id', 'name'])->orderBy(['branch_id' => SORT_ASC])->orderBy(['name' => SORT_ASC])->all(); 

    // Определяем текущий год
        $ouryear =  ['and' , ['>=', 'fact_datefinish', "$thisyear"], ['<','fact_datefinish', "$nextyear"]];
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime("-1 days"));
        
        $newwT = 0; //количество новых сегодня в работе
        $newcT = 0; //количество новых сегодня завершенных

       
//цикл по филиалам
    foreach ($branches as $branch){
            $branchName = $branch->name; //название филиала
            $brID = $branch->branch_id;

        if ($brID != 0){

//подсчет документации в работе для каждого филиала
            $pdwork_active = PdWork::find()->select(['work_type' =>'work_name', 'forestry_qnty' => 'SUM(IF(forestry_quantity = 0 or forestry_quantity is NULL, 1, forestry_quantity))', 'row_qnty' => 'COUNT(*)' , 'date_create'])->groupBy('work_name')->orderBy(['date_create' => SORT_ASC])->where("branch = $brID")->andWhere("completed = 0")->all();

            $brw_once = $brw_other = 0;
            
            foreach ($pdwork_active as $pdwork) {
                if ($pdwork->work_type == 1 || $pdwork->work_type == 13 || $pdwork->work_type == 14) $brw_once = $pdwork->row_qnty; // лесных планов
                else $brw_other += $pdwork->forestry_qnty; //учитываем кол-во лесничеств*/
            }
            $brw_pd = $brw_once + $brw_other; // всего в работе

                
            //проверка, что отчет отправлен сегодня
           //  $pdworkTod_active = PdWork::find()->select(['work_type' =>'work_name', 'forestry_qnty' => 'SUM(IF(forestry_quantity = 0 or forestry_quantity is NULL, 1, forestry_quantity))', 'row_qnty' => 'COUNT(*)'])->groupBy('work_name')->where("branch = $brID")->andWhere("completed = 0")->andWhere("date_create = $today")->all();

           $brwT_once = $brwT_other = 0; //сегодняшние
           //  foreach ($pdworkTod_active as $pdwork){
           //     // if (($pdwork->date_create != NULL) && ($pdwork->date_create == $today)){
           //          if ($pdwork->work_type == 1 || $pdwork->work_type == 13 || $pdwork->work_type == 14)  $brwT_once = $pdwork->row_qnty; // лесных планов
           //          else $brwT_other += $pdwork->forestry_qnty; //учитываем кол-во лесничеств*/
           //     // }
           //     // echo $pdwork->date_create;
           //     // echo '<br>';
           //     // $count_w++;
           // }

            
            $brwT_pd = $brwT_once + $brwT_other; // всего в работе за сегодня
            $newwT += $brwT_pd;

                                                                   
            //подсчет завершенной документации для каждого филиала
            $count_cl = 0;
            $pdwork_closed = PdWork::find()->select(['work_type' =>'work_name', 'forestry_qnty' => 'SUM(IF(forestry_quantity = 0 or forestry_quantity is NULL, 1, forestry_quantity))', 'row_qnty' => 'COUNT(*)'])->groupBy('work_name')->where("branch = $brID")->andWhere("completed = 1")->andWhere($ouryear)->all();

            $brc_once = $brc_other = 0;
            $brcT_once = $brcT_other = 0;

            foreach ($pdwork_closed as $pdwork) {
               if ($pdwork->work_type == 1 || $pdwork->work_type == 13 || $pdwork->work_type == 14) $brc_once = $pdwork->row_qnty; // лесных планов
                else $brc_other += $pdwork->forestry_qnty; //учитываем кол-во лесничеств
                //проверка, что отчет отправлен сегодня
                // echo $pdwork->date_create;
                // echo '<br>';

                // if (($pdwork->date_create != NULL) && ($pdwork->date_create == $today)){
                //     if ($pdwork->work_type == 1 || $pdwork->work_type == 13 || $pdwork->work_type == 14)  $brcT_once = $pdwork->row_qnty; // лесных планов
                //     else $brcT_other += $pdwork->forestry_qnty; //учитываем кол-во лесничеств*/
                // }
                // $count_cl++;
            }

            $brc_pd = $brc_once + $brc_other; // всего завершено 
            $brcT_pd = $brcT_once + $brcT_other; // всего завершено за сегодня
            $newcT += $brcT_pd;


                                              
            $name[] = $branchName;
            $docc[] = $brc_pd;
            $docw[] = $brw_pd;

            }
        }

        echo $newwT;
        echo '<br>';
        echo $newcT; 

        // echo $count_w;
        // echo '<br>';
        // echo $count_cl; 

        // echo '<pre>';
        // var_dump ($pdworkTod_active);
        // echo '</pre>';




       

                 

       
        
        return $this->render('chart', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'req' => $req,
            'dates'=>$dates,
            'asum'=>$asum,
            'plotdepend'=>$plotdepend, 
            'plotmassiv' =>$plotmassiv,  
            'usage' =>$usage,
            'typeusework' =>$typeusework,   
             'ttlinw_lp' => $ttlinw_lp,
            'ttlinw_lhr' => $ttlinw_lhr,
            'ttlinw_pol' => $ttlinw_pol,
            'ttlinw_other' => $ttlinw_other,
            'ttlinw_pd' => $ttlinw_pd,  
            'ttlinw_dlu' => $ttlinw_dlu,
            'ttlinw_rnz' => $ttlinw_rnz,
            'ttlinw_ld' => $ttlinw_ld,
            'ttlinw_useles' => $ttlinw_useles,
            'ttlinw_plv' => $ttlinw_plv,
            'ttlinw_pincl' => $ttlinw_pincl,            
            'ttlinw_ozu' => $ttlinw_ozu,
            'ttlinw_puglz' => $ttlinw_puglz,
            'ttlinw_ulpzp' => $ttlinw_ulpzp,
            'ttlinw_ppt' => $ttlinw_ppt,
            'ttlinw_pmt' => $ttlinw_pmt,
            'ttlinw_transfer' => $ttlinw_transfer,
            'ttlinw_kip' => $ttlinw_kip, 
            'ttlinw_fireprev' => $ttlinw_fireprev,
            'ttlinw_hunt' => $ttlinw_hunt,
            'ttlinw_oopt' => $ttlinw_oopt,
            'ttlinw_prup' => $ttlinw_prup,
            'ttlinw_ovos' => $ttlinw_ovos,
            'ttlinw_szz' => $ttlinw_szz,
            'ttlinw_pdv' => $ttlinw_pdv,
            'ttlinw_pnoolr' => $ttlinw_pnoolr,
            'pdtypework' => $pdtypework,
            'depension' => $depension, 
            //'dataOne' => $dataOne,
            'quantity' => $quantity,
            'dataOneChange' => $dataOneChange,
            'name' => $name,
            'docc' => $docc,
            'docw' => $docw,
            'newwT' => $newwT,
            'newcT' => $newcT
        ]);

    }

    

    


    /**
     * Displays a single ForestWork model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        
        // Если запрашиваем PDF-документ
        if (isset($_GET['format']) && $_GET['format'] == 'pdf') {

            $content = $this->renderPartial('view', [ 'model' => $this->findModel($id) ]);
            $curdate = date("Y-m-d");

            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8,
                'format' => Pdf::FORMAT_A4, 
                'orientation' => Pdf::ORIENT_PORTRAIT, 
                'destination' => Pdf::DEST_BROWSER,
                'filename' => "Отчет_ПОЛ_{$curdate}.pdf",
                'content' => $content,
                'cssInline' => '
                    body {color: #000; font-size: 9pt;}
                    p {font-size: 8pt;}
                    .report_header {padding: 30px 0 0 120px; float: left;}
                    h1 {font-size: 15pt;}

                    .table {margin-top: 80px;}
                    .table.pol th, .table.pol td {border-color: #000}
                    th, td:nth-child(1), td:nth-child(3), td:nth-child(4) {text-align: center;}
                    table#w0 th {text-align: left;}
                    .table thead tr th {vertical-align: middle}
                    

                    .hide_all_details, .show_all_details, .markers, .markerRed, .btn {display:none}
                    .rli_logo {float: left; width: 250px}
                ',
                'methods' => [ 
                    'SetTitle' => 'Отчет ПОЛ',
                //     'SetHeader'=>['Форма 6-ПОЛ-к'], 
                //     'SetFooter'=>['Дата {DATE j-m-Y}||{PAGENO}'],
                ],
                'options' => [ 
                    'title' => 'Отчет_ПОЛ_{$curdate}',
                    'defaultheaderline' => 0, // 1 or 0 - line under the header
                    'defaultfooterline' => 0,
                    'dpi' => 300,
                    'img_dpi' => 300,
                ]
            ]);
            
            return $pdf->render();
        }


        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ForestWork model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ForestWork();

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['view', 'id' => $model->id]);
        // }

        if ($model->load(Yii::$app->request->post())) {
// Если поля в отчете не заполнены значениями при добавлении в БД проставляем нули
            for ($i = 1; $i <= 17; $i++) {
                $ai = "a".$i;
                $bi = "b".$i;
                if ($model->$ai == '') $model->$ai = 0;
                if ($model->$bi == '') $model->$bi = 0;
            }

            if ($model->save()) {
            return $this->redirect(['index']);
            }

            // if ($model->save()) {
            // return $this->redirect(['view', 'id' => $model->id]);
            // }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ForestWork model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ForestWork model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ForestWork model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ForestWork the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ForestWork::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

	public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }







    /** Генерация сводного отчета по ПОЛ за текущую и предыдущую недели - КРАТКАЯ ВЕРСИЯ **/

    public function actionSummaryReportPol()
    {
        // Модель для получения даты отчета
        $reportDate_model = new ReportDateRequest();

        if (isset($repDate)) echo $reportDate = $repDate;

        elseif($reportDate_model->load(\Yii::$app->request->post())) {
            // var_dump(\Yii::$app->request->post());
            // var_dump($reportDate_model);
            $reportDate = $reportDate_model->reportDate;
        }

        else $reportDate = '';


        $isDate = is_numeric(strtotime($reportDate));
        if ( !$isDate || strlen($reportDate) != 10 ) { $reportDate = ''; }


        // Если в адресной строке передается дата, используем ее как дату отчета
        // В противном случае дата отчета - текущая дата
        // $reportDate = isset($_POST['reportDate']) ? $_POST['reportDate'] : '';


        // Формируем объект даты из даты :)
        $reportDateObj = new \DateTime($reportDate); // new DateTime(); // без параметра - текущая дата
        $reportDate_model->reportDate = $reportDateObj->format('Y-m-d'); // добавляем дату отчета в модель
        $repDate = $reportDateObj->format('Y-m-d');

        // Определяем номер дня недели
        $weekDayNum = $reportDateObj->format('w');

        // Если наша дата не ВС, то находим следующее ВС, иначе текущее ВС является концом недели
        if ($weekDayNum != 0) { $reportDateObj->modify('next sunday'); }

        // Определяем границы текущей и предыдущей недель
        $thisWeekEnd = $reportDateObj->format('Y-m-d');
        $thisWeekStart = $reportDateObj->modify('previous monday')->format('Y-m-d');
        $prevWeekEnd = $reportDateObj->modify('previous sunday')->format('Y-m-d');
        $prevWeekStart = $reportDateObj->modify('previous monday')->format('Y-m-d');


        // $d = getdate(); // текущее время
        // echo $d['wday']." - номер дня недели<br>"; // Номер дня недели, начиная с 0 - воскресенье

        // Определяем границы текущей и предыдущей недель для условий запроса в БД
        // if ( $d['wday'] != 0 ) {    // Проверяем, что сегодня не воскресенье
        //     $thisWeekEnd = date("Y-m-d", strtotime("next Sunday"));
        //     $thisWeekStart = date("Y-m-d", strtotime("-6 day", strtotime("next Sunday")));
        // } else {
        //     $thisWeekEnd = date("Y-m-d");
        //     $thisWeekStart = date("Y-m-d", strtotime("-6 day"));
        // }
        //     $prevWeekEnd = date("Y-m-d", strtotime("last Sunday"));
        //     $prevWeekStart = date("Y-m-d", strtotime("-6 day", strtotime("last Sunday")));


            // Эмуляция отчета по состоянию на предыдущие недели
             // $thisWeekEnd = date("Y-m-d", strtotime("-77 day", strtotime("next Sunday")));
             // $thisWeekStart = date("Y-m-d", strtotime("-83 day", strtotime("next Sunday")));
             // $prevWeekEnd = date("Y-m-d", strtotime("-77 day", strtotime("last Sunday")));
             // $prevWeekStart = date("Y-m-d", strtotime("-83 day", strtotime("last Sunday")));

        
        // Контроль определяемых дат: Вывод границ недель - текущей и предыдущей
        // echo '$thisWeekEnd = '.$thisWeekEnd."<br>";
        // echo '$thisWeekStart = '.$thisWeekStart."<br>";
        // echo '$prevWeekEnd = '.$prevWeekEnd."<br>";
        // echo '$prevWeekStart = '.$prevWeekStart."<br>";


        // Ограничения для имитации отсутствия отчетов
            $noreport = ""; //"id != 139";
            $noreport2 = ""; //"id != 107";


        $query = forestWork::find()->where(['and', "date >= \"$thisWeekStart\"", "date <= \"$thisWeekEnd\"", $noreport, $noreport2, ]);

        /*$pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);*/

        $reportsThisWeek = $query
            ->orderBy([ 'id' => SORT_ASC, /*'timestamp' => SORT_ASC, 'branch_id' => SORT_ASC, 'federal_subject_id' => SORT_ASC, */])
            //->offset($pagination->offset)
            //->limit($pagination->limit)
            ->all();

        
        $query2 = forestWork::find()->where(['and', "date >= \"$prevWeekStart\"", "date <= \"$prevWeekEnd\"", $noreport, $noreport2, ]);

        $reportsPrevWeek = $query2
            ->orderBy(['id' => SORT_ASC /*'timestamp' => SORT_ASC, 'id' => SORT_DESC, */])
            ->all();



        // $cubik = array();

        if (count($reportsPrevWeek) > 0) { // если есть записи за прошлую неделю
            // Добавляем в массив данные по прошлой неделе
            foreach ($reportsPrevWeek as $report):
                $attl = $bttl = 0;
                for ($i = 1; $i <= 17; $i++) {
                  $attl += $report->{"a".$i};
                  $bttl += $report->{"b".$i}; 
                }
                
                // $cubik[$report->branch_id][$report->federal_subject_id]['attlprevious'] = $attl;

                // Данные за прошлую неделю сохраняем в том числе и для того, чтобы 
                // в случае, их отсутствия за текущую неделю (отчет еще не сдан),
                // учитывать в расчетах данные предыдущей недели
                $cubik[$report->branch_id][$report->federal_subject_id]['attlprevious'] = $attl;
                $cubik[$report->branch_id][$report->federal_subject_id]['bttlprevious'] = $bttl;
            endforeach;
        }


        $prev = 'Ничего нет ';
        if (count($reportsThisWeek) > 0) { // если есть записи за текущую неделю
            // Добавляем в массив данные по текущей неделе
            foreach ($reportsThisWeek as $report):
                // Подсчитываем суммарные значения по общему количеству ПОЛ и выполненных ПОЛ.
                $attl = $bttl = 0;

                for ($i = 1; $i <= 17; $i++) {
                  $attl += $report->{"a".$i};
                  $bttl += $report->{"b".$i};
                }

                // $cubik[$report->branch_id][$report->federal_subject_id] = ['attlcurrent' => $attl, 'bttlcurrent' => $bttl, ];

                $cubik[$report->branch_id][$report->federal_subject_id]['attlcurrent'] = $attl;
                $cubik[$report->branch_id][$report->federal_subject_id]['bttlcurrent'] = $bttl;
               
            endforeach;
        }




        $branches = branch::find()->select(['branch_id', 'name'])->where('branch_id != 0')->orderBy(['name' => SORT_ASC])->all();
        $subjects = federalSubject::find()->select(['federal_subject_id', 'name'])->orderBy(['name' => SORT_ASC])->all();


        // $repDate = "2020-02-02";
        // $repDate = $reportDate_model->reportDate;


        // Если запрашиваем PDF-документ
        if (isset($_GET['format']) && $_GET['format'] == 'pdf') {

            // $repDate = $reportDate_model->reportDate;
            // $repDate = "2020-02-02";

            $content = $this->renderPartial('summarypol', compact('cubik', 'branches', 'subjects', 'prev', 'reportDate_model', 'repDate'));
            $curdate = date("Y-m-d");


            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8,
                'format' => Pdf::FORMAT_A4, 
                'orientation' => Pdf::ORIENT_PORTRAIT, 
                'destination' => Pdf::DEST_BROWSER,
                'filename' => "Отчет_форма_6-ПОЛ-к_{$repDate}.pdf",
                'content' => $content,
                'cssInline' => '
                    body {color: #000;}
                    .table {margin-top: 80px}
                    .table-bordered thead tr th, .table-bordered tbody tr th, .table-bordered tfoot tr th, .table-bordered thead tr td, .table-bordered tbody tr td, .table-bordered tfoot tr td {border: 1px solid #000;}
                    .table thead tr th, .table tbody tr th, .table tfoot tr th, .table thead tr td, .table tbody tr td, .table tfoot tr td {padding: 10px;}
                    th, td:nth-child(2), td:nth-child(3), td:nth-child(4) {text-align: center;}
                    .table thead tr th {vertical-align: middle}
                    h1 {font-size: 17pt; padding: 150px 0 0 150px; float: left;}
                    .tabheader1 th, .tabheader2 th {font-size: 9pt;}
                    .colnumbers td {font-size: 10pt; text-align: center; color: #666}

                    .vertical { font-size: 10pt;}

                    .message_head td, tfoot td {font-weight: bold; font-size: 10pt; background: #f0f0f0;}
                    tfoot td {background: #e0e0e0;}

                    .subpart td:nth-child(1) {padding-left: 14pt;}
                    .subpart td {color: #666;  font-size: 9pt;}
                    
                    .completedpol {background: #99ffaa;}
                    .hide_all_details, .show_all_details, .markers, .markerRed, .markerGreen, .btn {display:none}
                    .rli_logo {float: left; width: 300px}
                ',
                'methods' => [ 
                    'SetHeader'=>['Форма 6-ПОЛ-к'], 
                    'SetFooter'=>['Дата {DATE j-m-Y}||{PAGENO}'],
                    'SetTitle' => 'Форма 6-ПОЛ-к',
                ],
                'options' => [ 
                    'defaultheaderline' => 0, // 1 or 0 - line under the header
                    'defaultfooterline' => 0,
                    'dpi' => 300,
                    'img_dpi' => 300,
                    'options' => ['title' => 'Форма 6-ПОЛ-к {$repDate}'],
                ]
            ]);
            
            return $pdf->render();
         }


        return $this->render('summarypol', compact('cubik', 'branches', 'subjects', 'prev', 'reportDate_model'));

        // return $this->renderPartial('summarypol', [
        //     'cubik' => $cubik,
            //'reportsThisWeek' => $reportsThisWeek,
            // 'pagination' => $pagination,
        // ]);
    }





/** Генерация сводного отчета по ПОЛ за текущую и предыдущую недели - ДЕТАЛЬНАЯ ВЕРСИЯ **/

    public function actionSummaryReportPolDetail()
    {
        
        // Модель для получения даты отчета
        $reportDate_model = new ReportDateRequest();

        if (isset($repDate)) echo $reportDate = $repDate;
        elseif($reportDate_model->load(\Yii::$app->request->post())) $reportDate = $reportDate_model->reportDate;
        else $reportDate = '';

        $isDate = is_numeric(strtotime($reportDate));
        if ( !$isDate || strlen($reportDate) != 10 ) { $reportDate = ''; }

        // Формируем объект даты из даты :)
        $reportDateObj = new \DateTime($reportDate); // new DateTime(); // без параметра - текущая дата
        $reportDate_model->reportDate = $reportDateObj->format('Y-m-d'); // добавляем дату отчета в модель
        $repDate = $reportDateObj->format('Y-m-d');

        // Определяем номер дня недели
        $weekDayNum = $reportDateObj->format('w');

        // Если наша дата не ВС, то находим следующее ВС, иначе текущее ВС является концом недели
        if ($weekDayNum != 0) { $reportDateObj->modify('next sunday'); }

        // Определяем границы текущей и предыдущей недель
        $thisWeekEnd = $reportDateObj->format('Y-m-d');
        $thisWeekStart = $reportDateObj->modify('previous monday')->format('Y-m-d');
        // $prevWeekEnd = $reportDateObj->modify('previous sunday')->format('Y-m-d');
        // $prevWeekStart = $reportDateObj->modify('previous monday')->format('Y-m-d');



        // $d = getdate(); // текущее время

        // // Определяем границы текущей и предыдущей недель для условий запроса в БД
        // if ( $d['wday'] != 0 ) {    // Проверяем, что сегодня не воскресенье
        //     $thisWeekEnd = date("Y-m-d", strtotime("next Sunday"));
        //     $thisWeekStart = date("Y-m-d", strtotime("-6 day", strtotime("next Sunday")));
        // } else {
        //     $thisWeekEnd = date("Y-m-d");
        //     $thisWeekStart = date("Y-m-d", strtotime("-6 day"));
        // }

            // Эмуляция отчета по состоянию на предыдущую неделю
             // $thisWeekEnd = date("Y-m-d", strtotime("-77 day", strtotime("next Sunday")));
             // $thisWeekStart = date("Y-m-d", strtotime("-83 day", strtotime("next Sunday")));


        // Запрос за неделю
        $query = forestWork::find()->where(['and', "date >= \"$thisWeekStart\"", "date <= \"$thisWeekEnd\""]);
        // Запрос с начала года нарастающим итогом
        $startpoint = '2020-01-01';
        $query = forestWork::find()->where(['and', "date >= \"$startpoint\"", "date <= \"$thisWeekEnd\""]);

        $reportsThisWeek = $query->orderBy(['timestamp' => SORT_ASC, 'branch_id' => SORT_ASC, 'federal_subject_id' => SORT_ASC, ])->all();


        if (count($reportsThisWeek) == 0) $cubik = 0;
        else {
            // Добавляем в массив данные по текущей неделе
            foreach ($reportsThisWeek as $report):
                // Подсчитываем суммарные значения по общему количеству ПОЛ и выполненных ПОЛ.
                $attl = $bttl = 0;

                for ($i = 1; $i <= 17; $i++) {
                  $attl += $report->{"a".$i};
                  $bttl += $report->{"b".$i};
                  $cubik[$report->branch_id][$report->federal_subject_id]["a$i"] = $report->{"a".$i};
                  $cubik[$report->branch_id][$report->federal_subject_id]["b$i"] = $report->{"b".$i};
                }

                $cubik[$report->branch_id][$report->federal_subject_id]['attlcurrent'] = $attl;
                $cubik[$report->branch_id][$report->federal_subject_id]['bttlcurrent'] = $bttl;
            endforeach;
        }

        $branches = branch::find()->select(['branch_id', 'name'])->where('branch_id != 0')->orderBy(['name' => SORT_ASC])->all();
        $subjects = federalSubject::find()->select(['federal_subject_id', 'name'])->orderBy(['name' => SORT_ASC])->all();


         
        // Если запрашиваем PDF-документ
        if (isset($_GET['format']) && $_GET['format'] == 'pdf') {

            $content = $this->renderPartial('summarypoldetail', compact('cubik', 'branches', 'subjects', 'reportDate_model'));
            $curdate = date("Y-m-d");

            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8,
                'format' => Pdf::FORMAT_A3,
                'orientation' => Pdf::ORIENT_LANDSCAPE,
                'destination' => Pdf::DEST_BROWSER,
                'filename' => "Отчет_форма_6-ПОЛ_{$curdate}.pdf",
                'content' => $content,
                'cssInline' => '
                    body {color: #000;}
                    .table {margin-top: 100px}
                    .table-bordered thead tr th, .table-bordered tbody tr th, .table-bordered tfoot tr th, .table-bordered thead tr td, .table-bordered tbody tr td, .table-bordered tfoot tr td {border: 1px solid #000;}
                    .table thead tr th, .table tbody tr th, .table tfoot tr th, .table thead tr td, .table tbody tr td, .table tfoot tr td {padding: 16px;}
                    th, h1 {text-align: center;}
                    h1 {font-size: 18pt; padding-top: 200px; float: left;}
                    .tabheader1 th, .tabheader2 th, .colnumbers th {font-size: 12pt;}
                    .tabheader2 th {color: rgb(255,255,255)}
                    .colnumbers td {font-size: 10pt; text-align: center; color: #333}

                    .vertical { font-size: 10pt;}

                    .message_head td, tfoot td {font-weight: bold; font-size: 14pt; background: #f0f0f0;}
                    tfoot td {background: #e0e0e0;}

                    .subpart td:nth-child(1) {padding-left: 20pt;}
                    .subpart td {color: #666;  font-size: 12pt;}
                    
                    .completedpol {background: #99ffaa;}
                    .hide_all_details, .show_all_details, .markers, .btn {display:none}
                    .rli_logo {float: left; width: 300px}
                ',
                'methods' => [
                    'SetHeader'=>['Форма 6-ПОЛ'],
                    'SetFooter'=>['Дата {DATE j-m-Y}||{PAGENO}'],
                    'SetTitle' => 'Форма 6-ПОЛ',
                ],
                'options' => [ 
                    'defaultheaderline' => 0, // 1 or 0 - line under the header
                    'defaultfooterline' => 0,
                    'dpi' => 300,
                    'img_dpi' => 300,
                    'options' => ['title' => 'Форма 6-ПОЛ'],
                ]
            ]);
            
            return $pdf->render();
         }

         // echo '<pre>';
         // var_dump($bttl);
         // echo '</pre>';




        return $this->render('summarypoldetail', compact('cubik', 'branches', 'subjects', 'reportDate_model'));
    }



    /** Субъекты по филиалам **/
    public function actionBranchSubject()
    {
        // $branches = branch::find()->select(['branch_id', 'name'])->where('branch_id != 0')->orderBy(['name' => SORT_ASC])->all();
        // $subjects = federalSubject::find()->select(['federal_subject_id', 'name'])->orderBy(['name' => SORT_ASC])->all();
        // $responsibility = responsibilityArea::find()->orderBy(['branch_id' => SORT_ASC])->all();

        $subr = responsibilityArea::find()->with('branch', 'federalSubject')->orderBy(['branch_id' => SORT_ASC])->all();

        // $responsibility = responsibilityArea::find()
        //     //->select(['responsibility_area_id', 'federal_subject_id', 'branch_id', /*'branch_name' => "branch.name"*/])
        //     ->from (['responsibility_area'])
        //     ->leftJoin('branch','responsibility_area.branch_id = branch.branch_id')
        //     ->orderBy(['branch_id' => SORT_ASC])->all();

        return $this->render('branchsubject', compact('subr'));
    }


    /** Инструкция по заполнению и отправке отчета по ПОЛ **/
    public function actionInstructionPol()
    {
        return $this->render('instructionpol');
    }



    public function actionInstructionPolPdf()
    {
        $content = $this->renderPartial('instructionpol');

        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'format' => Pdf::FORMAT_A4, 
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            'destination' => Pdf::DEST_BROWSER, 
            'filename' => 'Инструкция_ПОЛ.pdf',
            'content' => $content,  
            // 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => '.pdf_but {display: none}
                            p, li {font-family: serif; font-size12px; line-height: 1.3}
                            .forest-work-index {padding-right: 0}
            ', 
            'options' => ['title' => 'Инструкция по заполнению отчета по ПОЛ'],
            'methods' => [ 
                'SetHeader'=>['Инструкция по заполнению отчета по ПОЛ'], 
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);
        
        return $pdf->render();
    }



}
