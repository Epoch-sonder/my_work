<?php

namespace app\modules\forest_work\controllers;

use Yii;
use app\modules\forest_work\models\ForestWork;
use app\modules\forest_work\models\SearchForestWork;
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

        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionChart()
    {
        
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




// $query = forestWork::find()->where(['and', "date >= \"$monday\"", "date <= \"$sunday\"" ]);

// $reportsThisWeek = $query
//     ->orderBy(['timestamp' => SORT_ASC, 'branch_id' => SORT_ASC, 'federal_subject_id' => SORT_ASC, ])
//     ->all();


// if (count($reportsThisWeek) > 0) { // если есть записи за текущую неделю

//     // Добавляем в массив данные по текущей неделе
//     foreach ($reportsThisWeek as $report):
//         // Подсчитываем суммарные значения по общему количеству ПОЛ и выполненных ПОЛ.
//         $attl = $bttl = 0;

//         for ($i = 1; $i <= 17; $i++) {
//           $attl += $report->{"a".$i};
//           $bttl += $report->{"b".$i};
//         }

//         $cubik[$report->branch_id][$report->federal_subject_id] = ['attlcurrent' => $attl, 'bttlcurrent' => $bttl, ];

//     endforeach;
// }




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

        
        return $this->render('chart', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'req' => $req,
        ]);

        // return $this->render('chart');
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
