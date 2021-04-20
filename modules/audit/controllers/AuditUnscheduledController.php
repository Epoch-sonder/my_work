<?php

namespace app\modules\audit\controllers;

use app\modules\audit\models\UploadFormUnsPlusExpert;
use Yii;
use app\modules\audit\models\AuditUnscheduled;
use app\modules\audit\models\SearchAuditUnscheduled;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * AuditUnscheduledController implements the CRUD actions for AuditUnscheduled model.
 */
class AuditUnscheduledController extends Controller
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
     * Lists all AuditUnscheduled models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchAuditUnscheduled();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AuditUnscheduled model.
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
     * Creates a new AuditUnscheduled model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AuditUnscheduled();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AuditUnscheduled model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model2 = new UploadFormUnsPlusExpert();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'model2' => $model2,
        ]);
    }

    /**
     * Deletes an existing AuditUnscheduled model.
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
     * Finds the AuditUnscheduled model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AuditUnscheduled the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuditUnscheduled::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUpload()
    {
        //  Если получаем данные через запрос Ajax
        if(\Yii::$app->request->isAjax){

            $model2 = new UploadFormUnsPlusExpert();

            // Используем переменную из _POST для формирования имени папки для загружаемого файла
            $uploaddir = './docs/audit/unscheduled/'.Yii::$app->request->post('UploadFormUnsPlusExpert')['check_num'].'/';

            // При передаче номера закупки через сессию формируем имя папки используя переменную из сессии
            $model2->requisitesRequest = UploadedFile::getInstance($model2, 'requisitesRequest');
            $model2->requisitesResponse = UploadedFile::getInstance($model2, 'requisitesResponse');
            $model2->completedWork = UploadedFile::getInstance($model2, 'completedWork');
            $model2->conclusionByWork = UploadedFile::getInstance($model2, 'conclusionByWork');
            $model2->proposalsByWork = UploadedFile::getInstance($model2, 'proposalsByWork');

            if ($filename = $model2->upload($uploaddir)) return json_encode( $filename );
            else return json_encode( "nofiles" );
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
                        $fileIcon = explode(".", $docName);
                        if ($fileIcon['1'] == 'pdf'){
                            $icon = '<i class="fas fa-file-pdf" style="color: #c00"></i> ';
                        }
                        if ($fileIcon['1'] == 'docx'){
                            $icon = '<i class="fas fa-file-word"  style="color: #2384e8"></i> ';
                        }
                        if ($fileIcon['1'] == 'doc'){
                            $icon = '<i class="fas fa-file-word"  style="color: #2384e8"></i> ';
                        }
                        echo  $icon . Html::a($docName, '/docs/audit/unscheduled/'.$checkNum.'/'.$docName , ['target'=>'_blank']) . "<br/>";
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
