<?php

namespace app\modules\lu\controllers;

use app\modules\audit\models\AuditType;
use app\modules\lu\models\LuObject;
use app\modules\lu\models\LuPhase;
use app\modules\lu\models\LuProcessDate;
use app\modules\lu\models\LuProcessStep;
use app\modules\lu\models\LuZakupCard;
use app\modules\lu\models\SearchLuObject;
use app\modules\lu\models\UploadForm;
//use app\modules\lu\models\LuProcessUploadForm;
use app\modules\lu\models\ZakupCard;
use app\modules\user\models\Branch;
use kartik\mpdf\Pdf;
use Yii;
use app\modules\lu\models\LuProcess;
use app\modules\lu\models\SearchLuProcess;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * LuProcessController implements the CRUD actions for LuProcess model.
 */
class LuProcessController extends Controller
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
     * Lists all LuProcess models.
     * @return mixed
     */
    public function actionIndex()
    {
         $zakup_id = Yii::$app->request->get('zakup');

        $searchModel = new SearchLuProcess();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->query
            ->andWhere(['zakup' => $zakup_id])
            ->orderBy(['id' => SORT_ASC]);

        $stphase = LuPhase::find()->orderBy('sort_order ASC')->all();
        $stepproces = LuProcess::getProcessST();
        $changeDateS = LuProcessDate::find()->where(['zakup_card'=>$zakup_id])->all();
        $dataSTARTING = ZakupCard::find()->where(['id'=>$zakup_id])->one();
        $dateST = 0;
        $branch = Branch::find()->all();
        $process_empty = 1;

        $object_zakup = LuObject::find()->where(['zakup'=>$zakup_id])->all();

        $check_process = LuProcess::find()->where(['lu_zakup_card'=>$zakup_id])->all();
        if(!empty($check_process)){ $process_empty = 0;}
        $model = new LuProcess();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index?' . 'zakup=' . $zakup_id]);}

        $model3 = new LuProcessDate();
        if ($model3->load(Yii::$app->request->post()) && $model3->save()) {
                    return $this->redirect(['index?' . 'zakup=' . $zakup_id]);}

        $stepSort= LuProcessStep::find()->all();

        $model2 = new UploadForm();
        $arrayMonth =array( 1 => "января", "февраля","марта", "апреля","мая","июня","июля","августа","сентября","октября","ноября","декабря" );


        $id_st201 = 0;
        $id_st203 = 0;
        $id_st209 = 0;
        $id_st210 = 0;
        $id_st211 = 0;
        $id_st214 = 0;
        $id_st207 = 0;
        $id_st208 = 0;
        $id_st216 = 0;
        $id_st304 = 0;
        $id_st401 = 0;
        $id_st402 = 0;
        $id_st404 = 0;
        $id_st405 = 0;





        if (isset($_GET['format']) && $_GET['format'] == 'pdf') {
            $content = $this->renderPartial('index', compact('object_zakup', 'id_st201', 'id_st203', 'id_st209', 'id_st210', 'id_st211', 'id_st214', 'id_st207', 'id_st208', 'id_st216', 'id_st304', 'id_st401', 'id_st402', 'id_st404', 'id_st405',
'arrayMonth', 'zakup_id',  'searchModel','dataProvider','model','process_empty','check_process','stepSort','branch','dateST','dataSTARTING','stphase','stepproces'));
            $repDate = $dataSTARTING['date_placement'];
            $repDate = new \DateTime($repDate); // new DateTime(); // без параметра - текущая дата
            $repDate = $repDate->format('d-m-Y');


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
                    .rli_logo {float: left; width: 300px;height:600px;  }
                    .plan-schedule {font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif; border-collapse: collapse;color: #686461;}
                    caption {padding: 10px; color: #fff; background: #88C86F;font-size: 18px; text-align: left;font-weight: bold;}
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
                    
                    img {width: 200px;float:left;height:300px; }
                    .caption {color:#fff;}
                    
                    
                   
                ',
                'methods' => [
                    'SetHeader' => ['Форма 6-ПОЛ-к'],
                    'SetFooter' => ['Дата {DATE j-m-Y}'],
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
        return $this->render('index', [
            'changeDateS'=>$changeDateS,



            'id_st201'=>$id_st201,
            'id_st203'=>$id_st203,
            'id_st209'=>$id_st209,
            'id_st210'=>$id_st210,
            'id_st211'=>$id_st211,
            'id_st214'=>$id_st214,
            'id_st207'=>$id_st207,
            'id_st208'=>$id_st208,
            'id_st216'=>$id_st216,
            'id_st304'=>$id_st304,
            'id_st401'=>$id_st401,
            'id_st402'=>$id_st402,
            'id_st404'=>$id_st404,
            'id_st405'=>$id_st405,
            'arrayMonth'=>$arrayMonth,
            'model2' => $model2,
            'model3'=>$model3,
            'object_zakup'=>$object_zakup,
            'zakup_id'=>$zakup_id,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=>$model,
            'process_empty'=>$process_empty,
            'check_process'=>$check_process,
            'stepSort'=>$stepSort,
            'branch'=>$branch,
            'dateST'=>$dateST,
            'dataSTARTING'=>$dataSTARTING,
            'stphase'=>$stphase,
            'stepproces'=> $stepproces,
        ]);

    }

    /**
     * Displays a single LuProcess model.
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
     * Creates a new LuProcess model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LuProcess();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing LuProcess model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
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

            // echo "yes post ";
            // echo "<pre>";
            // print_r($_POST);
            // echo "</pre>";

            $zakup_num = Yii::$app->request->post('UploadForm');
            echo $zakup_num['zakup_num'];
//            $docsStep = Yii::$app->request->post('UploadForm');
//            echo $docsStep['docsStep'];
//            $step_num = Yii::$app->request->post('UploadForm');
//            echo $step_num['step_num'];

            // echo "yes files ";
            // echo "<pre>";
            // var_dump($_FILES);
            // echo "</pre>";

            $req = ob_get_contents();
            ob_end_clean();


            // Используем переменную из _POST для формирования имени папки для загружаемого файла
            $uploaddir = './docs/lu/zakupki/'. Yii::$app->request->post('UploadForm')['zakup_num'] . '/';


            // При передаче номера закупки через сессию формируем имя папки используя переменную из сессии
            // $uploaddir = './docs/lu/zakupki/'.Yii::$app->session->get('zakup_num').'/';
            // if ($session->has('zakup_num') ) $uploaddir = $uploaddir . $session->get('zakup_num'); // проверяем, есть ли в сессии переменная

            $model2->docsStep = UploadedFile::getInstance($model2, 'docsStep');

            if ($filename = $model2->upload($uploaddir)) {
                // file is uploaded successfully

//                 return json_encode( $req );
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
            $zakupNum = Yii::$app->request->post('zakupNum');


            // Если нет переменной с именем папки в посте
            // if(!$docDir) return 'не передано имя директории';

            // Проверяем, существует ли папка
            if (file_exists($docDir)) {

                $files=FileHelper::findFiles($docDir, [ 'only' => [$docNameMask], 'recursive' => false ]); //'recursive' => true - в этой папке, включая вложенные
                if (isset($files[0])) {
                    // echo '<div class="file_list">';
                    foreach ($files as $index => $file) {
                        $docName = substr($file, strrpos($file, '/') + 1);
                        echo '<i class="fas fa-file-pdf"></i> ' . Html::a($docName, '/docs/lu/zakupki/'.$zakupNum.'/'.$docName , ['target'=>'_blank']) . "<br/>";
                    }
                    // echo '</div>';
                    // return 'есть файлы';
                    return ;
                }
                else {
                    // echo "Нет загруженных файлов";
                    return '';
                }
            }
            // Если нет папки с файлами для закупки
            else return "";
        }

        // Если получили запрос к экшену не через аякс
        return $this->redirect(['/lu/zakup-card']);
    }


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
     * Deletes an existing LuProcess model.
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
     * Finds the LuProcess model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LuProcess the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LuProcess::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
