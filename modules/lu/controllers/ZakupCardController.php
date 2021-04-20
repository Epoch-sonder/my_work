<?php

namespace app\modules\lu\controllers;

use Yii;
use app\modules\lu\models\ZakupCard;
use app\modules\lu\models\SearchZakupCard;
use app\modules\lu\models\UploadForm;
use app\modules\lu\models\Forestry;
use app\modules\lu\models\ForestryDefense;
use app\modules\lu\models\Cityregion;
use app\modules\lu\models\Oopt;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use yii\helpers\Html;

/**
 * ZakupCardController implements the CRUD actions for ZakupCard model.
 */
class ZakupCardController extends Controller
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

                    // echo "yes files ";
                    // echo "<pre>";
                    // var_dump($_FILES);
                    // echo "</pre>";

                    $req = ob_get_contents();
                    ob_end_clean();


            // Используем переменную из _POST для формирования имени папки для загружаемого файла
            $uploaddir = './docs/lu/zakupki/'.Yii::$app->request->post('UploadForm')['zakup_num'].'/';


            // При передаче номера закупки через сессию формируем имя папки используя переменную из сессии
            // $uploaddir = './docs/lu/zakupki/'.Yii::$app->session->get('zakup_num').'/';
            // if ($session->has('zakup_num') ) $uploaddir = $uploaddir . $session->get('zakup_num'); // проверяем, есть ли в сессии переменная

            $model2->dzzRequestFile = UploadedFile::getInstance($model2, 'dzzRequestFile');
            $model2->dzzPdFile = UploadedFile::getInstance($model2, 'dzzPdFile');

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


    /**
     * Lists all ZakupCard models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchZakupCard();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ZakupCard model.
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
     * Creates a new ZakupCard model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ZakupCard();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
//            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ZakupCard model.
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
//            return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'model2' => $model2,
        ]);
    }

    /**
     * Deletes an existing ZakupCard model.
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
                    return 'Нет загруженных файлов';
                }
            } 
            // Если нет папки с файлами для закупки
            else return "Нет директории с файлами";
        }

        // Если получили запрос к экшену не через аякс
        return $this->redirect(['/lu/zakup-card']);
    }


// Актуализируем список лесничества/оопт/районов
// в зависимости от выбранного субъекта и категории земель
    public function actionActualizeForestryList()
    {
        //  Если получаем данные через запрос Ajax
        if(\Yii::$app->request->isAjax){

            // Если передан айди субъекта и категории земель
            if(Yii::$app->request->post('cur_subject') && Yii::$app->request->post('cur_land_cat')) {

                $cur_subject = Yii::$app->request->post('cur_subject');
                $cur_land_cat = Yii::$app->request->post('cur_land_cat');

                // Для земель Лесного фонда
                if ($cur_land_cat == 1) {
                    $regions = forestry::find()->where("subject_kod = $cur_subject")->orderBy(['forestry_name' => SORT_ASC])->all();

                    if (count($regions) > 0) { // если есть записи по запросу
                        foreach ($regions as $region) {
                            echo '<option value="'.$region->forestry_kod.'">'.$region->forestry_name.'</option>';
                        }
                    }
                    else{
                        echo '<option value="0"> Нет земель лесного фонда</option>';
                    }
                }
                // Для земель обороны и безопасности
                elseif ($cur_land_cat == 2 ) {
                    $regions = ForestryDefense::find()->where("subject_kod = $cur_subject")->orderBy(['forestry_name' => SORT_ASC])->all();
                    if (count($regions) > 0) { // если есть записи по запросу
                        foreach ($regions as $region) {
                            echo '<option value="'.$region->forestry_kod.'">'.$region->forestry_name.'</option>';
                        }
                    }
                    else{
                        echo '<option value="0"> Нет земель обороны и безопасности</option>';
                    }
                }
                // Для земель населенных пунктов
                elseif ($cur_land_cat == 3) {
                    $regions = cityregion::find()->where("subject_kod = $cur_subject")->orderBy(['cityregion_name' => SORT_ASC])->all();

                    if (count($regions) > 0) { // если есть записи по запросу
                        foreach ($regions as $region) {
                            echo '
<option value="'.$region->cityregion_kod.'">'.$region->cityregion_name.'</option>';
                        }
                    }
                    else{
                        echo '<option value="0"> Нет земель населенных пунктов</option>';
                    }
                }
                // Для земель ООПТ
                elseif ($cur_land_cat == 4) {
                    $regions = oopt::find()->where("subject_kod = $cur_subject")->orderBy(['oopt_name' => SORT_ASC])->all();

                    if (count($regions) > 0) { // если есть записи по запросу
                        foreach ($regions as $region) {
                            echo '
<option value="'.$region->oopt_kod.'">'.$region->oopt_name.'</option>';
                        }
                    }
                    else{
                        echo '<option value="0"> Нет земель ООПТ</option>';
                    }
                }
                // Для земель ООПТ
                elseif ($cur_land_cat == 5) {
                    echo '<option value="0"> Иные</option>';
                }


            }
        }

        // Если получили запрос к экшену не через аякс
        // return $this->redirect(['/lu/zakup-card']);
    }



    /**
     * Finds the ZakupCard model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ZakupCard the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ZakupCard::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
