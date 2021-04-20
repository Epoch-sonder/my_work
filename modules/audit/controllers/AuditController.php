<?php

namespace app\modules\audit\controllers;

use app\modules\audit\models\AuditPerson;
use app\modules\audit\models\AuditProcess;
use app\modules\audit\models\OivSubject;
use app\modules\audit\models\AuditType;
use app\modules\audit\models\Branch;
use app\modules\audit\models\FederalDistrict;
use app\modules\audit\models\FederalSubject;
use app\modules\audit\models\UploadForm;
use app\modules\forest_work\models\ReportDateRequest;
use app\modules\lu\models\LuProcess;
use kartik\mpdf\Pdf;
use Yii;
use app\modules\audit\models\Audit;
use app\modules\audit\models\SearchAudit;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;


/**
 * AuditController implements the CRUD actions for Audit model.
 */
class AuditController extends Controller
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
     * Lists all Audit models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchAudit();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (Yii::$app->user->identity->role_id == 15)
            return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
        else
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);


    }

    /**
     * Displays a single Audit model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Audit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionSummary()
    {



        $form = new Audit();
        if ($form->load(Yii::$app->request->post())) {
            return $this->redirect(['summary?' . 'from_date=' . $zakup_id . 'to_date=' . $zakup_id]);
        }


        $dateThis = date_default_timezone_get();
        $dateThis = date("Y", strtotime($dateThis . ""));

        if(Yii::$app->request->get('from_date') == null){
            $fromDate = $dateThis."-01-01";
        }
        else{
            $fromDate = Yii::$app->request->get('from_date');
        }
        if(Yii::$app->request->get('to_date') == null){

            $toDate = $dateThis."-12-31";
        }
        else{
            $toDate = Yii::$app->request->get('to_date');
        }

        $audit = Audit::find()
            ->andFilterWhere(['>=', 'date_start', $fromDate ])
            ->andFilterWhere(['<=', 'date_start', $toDate ])
            ->orderBy(['date_start' => SORT_ASC])
            ->all();
        $oiv = OivSubject::find()->all();
        $auditPerson = AuditPerson::find()->all();
        $auditProcess = AuditProcess::find()->orderBy(['audit_person' => SORT_ASC])->all();
        $auditType = AuditType::find()->all();
        $fed_sub = FederalSubject::find()->all();
        $fed_dis = FederalDistrict::find()->all();
        $branch = Branch::find()->all();




        $arrayMonth =array( 1 => "января", "февраля","марта", "апреля","мая","июня","июля","августа","сентября","октября","ноября","декабря" );
        $arrayMonthR =array( 1 => "январь", "февраль","март", "апрель","май","июнь","июль","август","сентябрь","октябрь","ноябрь","декабрь" );
        $sumQuantity = 0;
        $sumFio = 0;
        $sumFioAudit = 0;
        $sumMoneyD = 0;
        $sumMoneyA = 0;
        $sumMoneyT = 0;
        $sumMoneyO = 0;
        $oneSumMoneyD = 0;
        $oneSumMoneyA = 0;
        $oneSumMoneyT = 0;
        $oneSumMoneyO = 0;
        $sumAll = 0;
        $sumDateRange = 0;
        $sumChapter = 0;
        $same = 0;
        $auditМany = null;
        $auditOne = null;
        $allAuditSum = 0;
        $auditOneFed = 1;
        $auditPersonMany = null;
        $auditPersonsNumber = null;
        $dateMonthOne = null;
        $sumAllMoneyMonth = 0;
        $audiyForMounth = 0;
        $sumMoneyMonthD = 0;
        $sumMoneyMonthA = 0;
        $sumMoneyMonthT = 0;
        $sumMoneyMonthO = 0;
        $sumFioMonth = 0;
        $dateProcessId = null;
        $FedSub = 0;
        $FedSubId = 0;
        $FedSubOne = null;




        if (isset($_GET['format']) && $_GET['format'] == 'pdf') {
            $content = $this->renderPartial('summary', compact( 'FedSub','FedSubId','FedSubOne','dateProcessId','arrayMonthR','sumFioMonth','sumMoneyMonthD','sumMoneyMonthA','sumMoneyMonthT','sumMoneyMonthO','sumAllMoneyMonth','audiyForMounth','dateMonthOne','sumDateRange','sumChapter','same','auditМany','auditOne','allAuditSum','auditOneFed','auditPersonMany','auditPersonsNumber','sumAll','oneSumMoneyD','oneSumMoneyA','oneSumMoneyT','oneSumMoneyO','sumMoneyD','sumMoneyA','sumMoneyT','sumMoneyO','sumFioAudit','sumFio','sumQuantity','arrayMonth','oiv','fromDate','toDate','fed_dis','auditType','form','branch','fed_sub','auditPerson','auditProcess','audit'
            ));
            $DateF = $fromDate;
            $DateF = new \DateTime($DateF); // new DateTime(); // без параметра - текущая дата
            $DateF = $DateF->format('d-m-Y');
            $DateT = $toDate;
            $DateT = new \DateTime($DateT); // new DateTime(); // без параметра - текущая дата
            $DateT = $DateT->format('d-m-Y');
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8,
                'format' => Pdf::FORMAT_A4,
                'orientation' => Pdf::ORIENT_PORTRAIT,
                'destination' => Pdf::DEST_BROWSER,
                'filename' => "TEST_C_{$DateF}_ПО_{$DateT}.pdf",
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
                    .table-striped > tbody > tr:nth-of-type(odd) {
                    background-color: #f0f0f0;}
                    .subpart td:nth-child(1) {padding-left: 14pt;}
                    .subpart td {color: #666;  font-size: 9pt;}
                    
                    .completedpol {background: #99ffaa;}
                    .hide_all_details, .show_all_details, .markers, .markerRed, .markerGreen, .btn {display:none}
                    .rli_logo {float: left; width: 300px;height:600px;  }
                    .plan-schedule {font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif; border-collapse: collapse;color: #686461;}
                    th { border-bottom: 3px solid #B9B29F; padding: 10px; text-align: left;}
                    td { padding: 10px;}
                    tr { background: #fff; color: #fff}
                    .name-phase {background: #E8E6D1;}
                    .help-block{ display: none; }
                    .top-margin{ margin-top: 18px; display: none !important; }
                    #luprocess-date_finish-kvdate {  width: 155px;max-width: 155px;display: none !important;}
                    #luprocess-volume { width: 50px; max-width: 50px; display: none !important;}
                    #luprocess-staff{ width: 50px;max-width: 50px; display: none !important;}
                    #luprocess-person_responsible{ width: 150px;max-width: 150px; display: none !important;}
                    #luprocess-mtr{ width: 110px; max-width: 110px;}
                    .input-group{max-width: 200px; width: 170px;display: none !important;}
                    #luprocess-date_finish{ max-width: 150px;width: 118px;display: none !important;}
                    .displaySelect{display:none}
                    img {width: 230px;float:left;height:330px; }
                    .tableTH *{font-weight: 400 !important;}
                    .Text_Ogl{ text-align: center;}
                    
                    
                    
                   
                ',
                'methods' => [
                    'SetHeader' => ['TEST'],
                    'SetFooter' => ['Дата {DATE j-m-Y}'],
                    'SetTitle' => 'TEST',
                ],
                'options' => [
                    'defaultheaderline' => 0, // 1 or 0 - line under the header
                    'defaultfooterline' => 0,
                    'dpi' => 300,
                    'img_dpi' => 300,
                    'options' => ['title' => 'TEST'],
                ]
            ]);

            return $pdf->render();
        }
        if (Yii::$app->request->get('old_version') == 1){
            $summary = 'summaryold';
        }
        else {
            $summary = 'summary';
        }
        return $this->render($summary, [
            'FedSub'=>$FedSub,
            'FedSubId'=>$FedSubId,
            'FedSubOne'=>$FedSubOne,
            'dateProcessId'=>$dateProcessId,
            'arrayMonthR'=>$arrayMonthR,
            'sumFioMonth'=>$sumFioMonth,
            'sumMoneyMonthD'=>$sumMoneyMonthD,
            'sumMoneyMonthA'=>$sumMoneyMonthA,
            'sumMoneyMonthT'=>$sumMoneyMonthT,
            'sumMoneyMonthO'=>$sumMoneyMonthO,
            'sumAllMoneyMonth'=>$sumAllMoneyMonth,
            'audiyForMounth'=>$audiyForMounth,
            'dateMonthOne'=>$dateMonthOne,
            'sumDateRange'=>$sumDateRange,
            'sumChapter'=>$sumChapter,
            'same'=>$same,
            'auditМany'=>$auditМany,
            'auditOne'=>$auditOne,
            'allAuditSum'=>$allAuditSum,
            'auditOneFed'=>$auditOneFed,
            'auditPersonMany'=>$auditPersonMany,
            'auditPersonsNumber'=>$auditPersonsNumber,
            'sumAll'=>$sumAll,
            'oneSumMoneyD'=>$oneSumMoneyD,
            'oneSumMoneyA'=>$oneSumMoneyA,
            'oneSumMoneyT'=>$oneSumMoneyT,
            'oneSumMoneyO'=>$oneSumMoneyO,
            'sumMoneyD'=>$sumMoneyD,
            'sumMoneyA'=>$sumMoneyA,
            'sumMoneyT'=>$sumMoneyT,
            'sumMoneyO'=>$sumMoneyO,
            'sumFioAudit'=>$sumFioAudit,
            'sumFio'=>$sumFio,
            'sumQuantity'=>$sumQuantity,
            'arrayMonth'=>$arrayMonth,
            'oiv'=>$oiv,
            'fromDate'=>$fromDate,
            'toDate'=>$toDate,
            'fed_dis'=>$fed_dis,
            'auditType'=>$auditType,
            'form'=>$form,
            'branch'=>$branch,
            'fed_sub'=>$fed_sub,
            'auditPerson'=>$auditPerson,
            'auditProcess'=>$auditProcess,
            'audit'=>$audit
        ]);
    }
    /** Инструкция  **/
    public function actionInstruction()
    {
        return $this->render('instructionaudit');
    }
    public function actionInstructionAuditPdf()
    {
        $content = $this->renderPartial('instructionaudit');

        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'filename' => 'Инструкция_Проверки.pdf',
            'content' => $content,
            // 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => '.pdf_but {display: none}
                            p, li {font-family: serif; font-size12px; line-height: 1.3}
                            .forest-work-index {padding-right: 0}
            ',
            'options' => ['title' => 'Инструкция по контролю исполнения переданных полномочий'],
            'methods' => [
                'SetHeader'=>['Инструкция по контролю исполнения переданных полномочий'],
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);

        return $pdf->render();
    }


    public function actionCreate()
    {
        $model = new Audit();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(['index']);
        }


        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Audit model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        $model = $this->findModel($id);
        $model2 = new UploadForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'model2' => $model2,
        ]);
    }

    /**
     * Deletes an existing Audit model.
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
     * Finds the Audit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Audit the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Audit::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



    public function actionUpload()
    {
        //  Если получаем данные через запрос Ajax
        if(\Yii::$app->request->isAjax){

            $model2 = new UploadForm();

            // $zk = "no";
            // if(isset($_POST['zakup_num'])) $zk = "yes";


            // Тест на наличие переменных в глобальных массивах
            $req = false;
            ob_start();

            $checkNum = Yii::$app->request->post('UploadForm');
            echo $checkNum['check_num'];


            $req = ob_get_contents();
            ob_end_clean();

            // Используем переменную из _POST для формирования имени папки для загружаемого файла
            $uploaddir = './docs/audit/audit/'.Yii::$app->request->post('UploadForm')['check_num'].'/';


            // При передаче номера закупки через сессию формируем имя папки используя переменную из сессии
            // $uploaddir = './docs/lu/zakupki/'.Yii::$app->session->get('zakup_num').'/';
            // if ($session->has('zakup_num') ) $uploaddir = $uploaddir . $session->get('zakup_num'); // проверяем, есть ли в сессии переменная

            $model2->requestFalhCa = UploadedFile::getInstance($model2, 'requestFalhCa');
            $model2->requestCaBranch = UploadedFile::getInstance($model2, 'requestCaBranch');
            $model2->answerBranchCa = UploadedFile::getInstance($model2, 'answerBranchCa');
            $model2->answerCaFalh = UploadedFile::getInstance($model2, 'answerCaFalh');
            $model2->orderAudit = UploadedFile::getInstance($model2, 'orderAudit');

            if ($filename = $model2->upload($uploaddir)) {
                // file is uploaded successfully

                // return json_encode( $req );
                return json_encode( $filename );

            }
            else
                return json_encode( "nofiles" );
        }

        return $this->redirect(['index']);
    }



    public function actionFileListRequest()
    {
        //  Если получаем данные через запрос Ajax
        if(\Yii::$app->request->isAjax){

            $docDir = Yii::$app->request->post('docDir');
            $docNameMask = Yii::$app->request->post('docNameMask'); // например RequestPdDzz*
            $checkNum = Yii::$app->request->post('auditNum');

            // Если нет переменной с именем папки в посте
            // if(!$docDir) return 'не передано имя директории';

            // Проверяем, существует ли папка
            if (file_exists($docDir)) {

                $files=FileHelper::findFiles($docDir, [ 'only' => [$docNameMask], 'recursive' => false ]); //'recursive' => true - в этой папке, включая вложенные
                if (isset($files[0])) {
                    // echo '<div class="file_list">';
                    foreach ($files as $index => $file) {
                        $docName = substr($file, strrpos($file, '/') + 1);
                        echo '<i class="fas fa-file-pdf"></i> ' . Html::a($docName, '/docs/audit/audit/'.$checkNum.'/'.$docName , ['target'=>'_blank']) . "<br/>";
                    }
                    // echo '</div>';
                    // return 'есть файлы';
                    return ;
                }
                else {
                    // echo "Нет загруженных файлов";
                    return 'Нет загруженных файлов';
                }
            }
            // Если нет папки с файлами для закупки
            else return "Нет загруженных файлов";
        }

        // Если получили запрос к экшену не через аякс
        return $this->redirect(['/audit/audit']);
    }









}
