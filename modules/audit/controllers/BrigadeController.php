<?php

namespace app\modules\audit\controllers;

use app\models\BranchPerson;
use app\modules\audit\models\Branch;
use app\modules\audit\models\BrigadeOnline;
use app\modules\audit\models\FederalSubject;
use app\modules\audit\models\ForestgrowRegionSubject;
use app\modules\audit\models\TrainingPerson;
use app\modules\audit\models\UploadFormBrigade;
use Yii;
use app\modules\audit\models\Brigade;
use app\modules\audit\models\SearchBrigade;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * BrigadeController implements the CRUD actions for Brigade model.
 */
class BrigadeController extends Controller
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
     * Lists all Brigade models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchBrigade();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Brigade model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $brigadeID = $this->findModel($id)['id'];
        $model2 = new BrigadeOnline();
        $branch = $this->findModel($id)['branch'];
        $branch = Branch::find()->where(['=','branch_id',"$branch"])->asArray()->select('name')->one();
        $subj = $this->findModel($id)['subject'];
        $subj = FederalSubject::find()->where(['=','federal_subject_id',"$subj"])->asArray()->select('name')->one();
        $branchPersons = BranchPerson::find()->where(['=','num_brigade',"$brigadeID"])->select(['id','fio'])->asArray()->all();
        $brigadeOnlines = BrigadeOnline::find()->where(['=','brigade_number',"$brigadeID"])->orderBy(['date_report' => SORT_DESC])->asArray()->all();

        $dateThis = date_default_timezone_get();
        $dateThis = new \DateTime($dateThis);

        if ($dateThis == $dateThis->modify('monday'))  $thisWeekStart = $dateThis->modify('monday')->format('Y-m-d');
        else $thisWeekStart = $dateThis->modify('monday')->format('Y-m-d');
        if ($dateThis == $dateThis->modify('sunday')) $thisWeekEnd = $dateThis->modify('sunday')->format('Y-m-d');
        else  $thisWeekEnd = $dateThis->modify('previous sunday')->format('Y-m-d');

        $thisWeekStart = new \DateTime($thisWeekStart);
        $thisWeekStart = $thisWeekStart->modify('-7 day')->format('Y-m-d');

        if ($model2->load(Yii::$app->request->post()) && $model2->save()) {
            return $this->redirect(['view', 'id' => $this->findModel($id)["id"]]);
        }
        return $this->render('view', [
            'model2' => $model2,
            'model' => $this->findModel($id),
            'branch'=>$branch,
            'subj'=>$subj,
            'branchPersons'=>$branchPersons,
            'brigadeOnlines'=>$brigadeOnlines,
            'thisWeekEnd'=>$thisWeekEnd,
            'thisWeekStart'=>$thisWeekStart,
        ]);
    }

    /**
     * Creates a new Brigade model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Brigade();
        $LPsRegionSub = ForestgrowRegionSubject::find()->select(['region_id', 'subject_id'])->asArray()->all();
        foreach ($LPsRegionSub as $LPRegionSub){
            if (isset( $RegSubArr[$LPRegionSub['subject_id']]))  $RegSubArr[$LPRegionSub['subject_id']] =  $RegSubArr[$LPRegionSub['subject_id']] . ',' . $LPRegionSub['region_id'];
            else $RegSubArr[$LPRegionSub['subject_id']] = $LPRegionSub['region_id'];
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->person){
                
                $PeoplesBrigade = BranchPerson::find()->where(['=','num_brigade',$model->id])->all();
                foreach ($PeoplesBrigade as $PeopleBrigade){
                    $PeopleBrigade->num_brigade = null;
                    $PeopleBrigade->save();
                }

                $arrayPeople = $model->person;
                $arrayPeople = explode(",", $arrayPeople);

                foreach ($arrayPeople as $arraPeople){
                    if (similar_text($arraPeople, '()') < 2){
//                        $peopleID = explode("(", $arraPeople);
//                        $people = TrainingPerson::findOne($peopleID['0']);
//                        $people->num_brigade = $model->id;
//                        $people->save();
                        $peopl = BranchPerson::findOne($arraPeople);
                        $peopl->num_brigade = $model->id;
                        $peopl->save();
                    }
//                    else{
//                        $peopl = BranchPerson::findOne($arraPeople);
//                        $peopl->num_brigade = $model->id;
//                        $peopl->save();
//                    }
                }
            }
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'RegSubArr'=>$RegSubArr,
        ]);
    }

    /**
     * Updates an existing Brigade model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        $model2 = new UploadFormBrigade();
        $model = $this->findModel($id);
        $LPsRegionSub = ForestgrowRegionSubject::find()->select(['region_id', 'subject_id'])->asArray()->all();
        foreach ($LPsRegionSub as $LPRegionSub){
            if (isset( $RegSubArr[$LPRegionSub['subject_id']]))  $RegSubArr[$LPRegionSub['subject_id']] =  $RegSubArr[$LPRegionSub['subject_id']] . ',' . $LPRegionSub['region_id'];
            else $RegSubArr[$LPRegionSub['subject_id']] = $LPRegionSub['region_id'];
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->person){
                $PeoplesBrigade = BranchPerson::find()->where(['=','num_brigade',$model->id])->all();
                foreach ($PeoplesBrigade as $PeopleBrigade){
                    $PeopleBrigade->num_brigade = null;
                    $PeopleBrigade->save();
                }

                $arrayPeople = $model->person;
                $arrayPeople = explode(",", $arrayPeople);
                foreach ($arrayPeople as $arraPeople){

                    if (similar_text($arraPeople, '()') < 2){
//                        $peopleID = explode("(", $arraPeople);
//                        $people = TrainingPerson::findOne($peopleID['0']);
//                        $people->num_brigade = $model->id;
//                        $people->save();
                        $peopl = BranchPerson::findOne($arraPeople);
                        $peopl->num_brigade = $model->id;
                        $peopl->save();
                    }
//                    else{
//                        $peopl = BranchPerson::findOne($arraPeople);
//                        $peopl->num_brigade = $model->id;
//                        $peopl->save();
//                    }
                }
            }
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'RegSubArr'=>$RegSubArr,
            'model2' => $model2,
        ]);
    }

    /**
     * Deletes an existing Brigade model.
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
    public function actionViewSpecialist()
    {
         //  Если получаем данные через запрос Ajax
        if(Yii::$app->request->isAjax){
            $forestryId = Yii::$app->request->post('forestryId');
            $arrayPeople = Yii::$app->request->post('arrayPeople');
            $arrayPeople = explode(",", $arrayPeople);
            $arrayPeople = array_combine($arrayPeople,$arrayPeople);
            $branch = Branch::find()->asArray()->all();
            $peoples = BranchPerson::find()->where(['=','training_process_1',"$forestryId"])
                ->orWhere(['=','training_process_2',"$forestryId"])
                ->orWhere(['=','training_process_3',"$forestryId"])
                ->andWhere(['is','num_brigade',null])
                ->andWhere(['is','date_dismissial',null])
                ->orderBy(['fio' => SORT_ASC])->asArray()->all();
            if ($peoples){
                foreach ($peoples as $people) {
                    if (!isset($arrayPeople[$people['id']])){
                        echo '<option value="' . $people['id'] . '">' . $people['fio'] . ' ('.$branch[$people['branch']]['name'].')'.  '</option>';
                    }
                }
            }
            else{
                echo '<option value="NO" selected="" disabled=""> Не найдено специалистов</option>';
            }

            return true;

        }
        return $this->redirect(['index']);

    }

    public function actionUpdateSpecialist()
    {
         //  Если получаем данные через запрос Ajax
        if(Yii::$app->request->isAjax) {
            if ($idPost = Yii::$app->request->post('idPost')) {
                $branch = Branch::find()->asArray()->all();
                $peopleLess = BranchPerson::find()->where(['=', 'num_brigade', $idPost])->all();

                $arrayPeople = Yii::$app->request->post('arrayPeople');
                $arrayPeople = explode(",", $arrayPeople);

                if ($arrayPeople) {
                    foreach ($arrayPeople as $arrPeople) {
                        foreach ($peopleLess as $peopleLes) {
                            if ($peopleLes['id'] == $arrPeople) {
                                echo '<option value="' . $peopleLes['id'] . '">' . $peopleLes['fio'] . ' ('.$branch[$peopleLes['branch']]['name'].')'. '</option>';
//                                echo '<option value="' . $peopleLes['id'].'(666)">' . $peopleLes['fio'] .'    (' . $peopleLes['workplace_other'].')'.'</option>';
                            }
                        }
                    }
                }


            }
            return true;
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Brigade model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Brigade the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Brigade::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }







    public function actionUpload()
    {

        //  Если получаем данные через запрос Ajax
        if(\Yii::$app->request->isAjax){
            $model2 = new UploadFormBrigade();
            // Используем переменную из _POST для формирования имени папки для загружаемого файла
            $uploaddir = './docs/audit/brigade/'.Yii::$app->request->post('UploadFormBrigade')['check_num'].'/';

            if ($model2->load(Yii::$app->request->post())) $model2->namePeople = $model2->namePeople . '_';
            $model2->fieldOrder = UploadedFile::getInstance($model2, 'fieldOrder');
            $model2->businessTrip = UploadedFile::getInstance($model2, 'businessTrip');
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
            $NameMask = Yii::$app->request->post('NameMaskRus');

            // Если нет переменной с именем папки в посте
            // if(!$docDir) return 'не передано имя директории';

            // Проверяем, существует ли папка
            if (file_exists($docDir)) {

                $files=FileHelper::findFiles($docDir, [ 'only' => [$docNameMask], 'recursive' => false ]); //'recursive' => true - в этой папке, включая вложенные
                if (isset($files[0])) {
                    // echo '<div class="file_list">';
                    sort($files);
                    foreach ($files as $index => $file) {
                        $docName = substr($file, strrpos($file, '/') + 1);
                        if ($NameMask == null) $NameMask = $docName;
                        //'<a><span class="glyphicon glyphicon-trash"></span></a>
//                        $url = 'style="color: #337ab7;" title="docs/audit/training/' . $checkNum . '/'.$docName .' class="glyphicon glyphicon-trash trashfile"';
                        $url = 'title="docs/audit/brigade/' . $checkNum . '/'.$docName .'"';
                        echo '<i class="fas fa-file-pdf"></i> ' . Html::a($NameMask, '/docs/audit/brigade/' . $checkNum . '/'.$docName , ['target'=>'_blank' ,'label' => 'Home', 'class'=>'name'] ) .'<span style="color: #337ab7;"  class="glyphicon glyphicon-trash trashfile" '.$url.'></span>'. '<br/>';

                        if ($NameMask == $docName){
                            $NameMask = null;
                        }
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
            else return '';
        }

        // Если получили запрос к экшену не через аякс
        return $this->redirect(['/audit/training-process']);
    }
    public function actionFileList()
    {

        //  Если получаем данные через запрос Ajax
        if(\Yii::$app->request->isAjax){

            $docDir = Yii::$app->request->post('docDir');
            $docNameMask = Yii::$app->request->post('docNameMask'); // например RequestPdDzz*
            $checkNum = Yii::$app->request->post('auditNum');
            $NameMask = Yii::$app->request->post('NameMaskRus');

            // Если нет переменной с именем папки в посте
            // if(!$docDir) return 'не передано имя директории';

            // Проверяем, существует ли папка
            if (file_exists($docDir)) {

                $files=FileHelper::findFiles($docDir, [ 'only' => [$docNameMask], 'recursive' => false ]); //'recursive' => true - в этой папке, включая вложенные
                if (isset($files[0])) {
                    sort($files);
                    foreach ($files as $index => $file) {
                        $docName = substr($file, strrpos($file, '/') + 1);
                        if ($NameMask == null) $NameMask = $docName;
                        echo '<i class="fas fa-file-pdf"></i> ' . Html::a($NameMask, '/docs/audit/brigade/' . $checkNum . '/'.$docName , ['target'=>'_blank' ,'label' => 'Home', 'class'=>'name'] ) . '<br/>';

                        if ($NameMask == $docName){
                            $NameMask = null;
                        }
                    }
                    return '';
                }
                else {

                    return '';
                }
            }
            else return '';
        }

        return $this->redirect(['/audit/training-process']);
    }
    public function actionFileDelete()
    {
        //  Если получаем данные через запрос Ajax
        if(\Yii::$app->request->isAjax){
            $namefile = Yii::$app->request->post('namefile');
//            $fullname = 'docs/audit/training/'.$num.'/'.$name;
//            $fullname = 'docs/audit/training/8/\stripCard_1608902508.pdf';
            $fullname = $namefile;
            if (file_exists($fullname) == true){
                unlink ($fullname) ;
                return 'Выполнено';
            }
            else{
//                var_dump(file_exists($fullname));
                return 'нет';
            }

        }
        // Если получили запрос к экшену не через аякс
        return $this->redirect(['/audit/training-process']);
    }















}
