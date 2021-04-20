<?php

namespace app\modules\audit\controllers;

use app\models\BranchPerson;
use app\models\CaCurator;
use app\models\ForestryMunic;
use app\modules\audit\models\Branch;
use app\modules\audit\models\FederalSubject;
use app\modules\audit\models\ForestgrowRegion;
use app\modules\audit\models\ForestgrowRegionSubject;
use app\modules\audit\models\ForestgrowZone;
use app\modules\audit\models\MunicRegion;
use app\modules\audit\models\TrainingPerson;
use app\modules\audit\models\UploadFormTraining;
use app\modules\lu\models\Forestry;
use app\modules\pd\models\ResponsibilityArea;
use app\modules\pd\models\SubForestry;
use app\modules\pd\models\User;
use Faker\Provider\Person;
use kartik\mpdf\Pdf;
use Yii;
use app\modules\audit\models\TrainingProcess;
use app\modules\audit\models\SearchTrainingProcess;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * TrainingProcessController implements the CRUD actions for TrainingProcess model.
 */
class TrainingProcessController extends Controller
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
     * Lists all TrainingProcess models.
     * @return mixed
     */
    public function actionIndex()
    {
        $TrainingPs = TrainingPerson::find()->orderBy(['fio' => SORT_ASC])->select(['id','fio','workplace_other'])->all();
        $branchPeopleNames = BranchPerson::find()->orderBy(['fio' => SORT_ASC])->select(['id','fio'])->asArray()->all();
        $searchModel = new SearchTrainingProcess();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'branchPeopleNames'=>$branchPeopleNames,
            'TrainingPs'=>$TrainingPs,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TrainingProcess model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $branchName = Branch::find()->select('name')->asArray()->where(['branch_id' => $model->branch])->one();
        $subjectName = FederalSubject::find()->select('name')->asArray()->where(['federal_subject_id' => $model->subject])->one();
        $municName = MunicRegion::find()->select('name')->asArray()->where(['id' => $model->munic_region])->one();
        $forestgrowName = ForestgrowRegion::find()->select('name')->asArray()->where(['id' => $model->forestgrow_region])->one();
        $forestryName = Forestry::find()->select('forestry_name')->asArray()->where(['forestry_kod' => $model->forestry])->andWhere(['subject_kod'=> $model->subject ])->one();
        $subforestryName = SubForestry::find()->select('subforestry_name')->asArray()->where(['id' => $model->subforestry])->one();
        $trforestryName = Forestry::find()->select('forestry_name')->asArray()->where(['forestry_kod' => $model->training_forestry])->andWhere(['subject_kod'=> $model->subject ])->one();
        $trsubforestryName = SubForestry::find()->select('subforestry_name')->asArray()->where(['id' => $model->training_subforestry])->one();
        $personNames = TrainingPerson::find()->orderBy(['fio' => SORT_ASC])->select(['id','fio','workplace_other'])->asArray()->all();
        $branchPeopleNames = BranchPerson::find()->orderBy(['fio' => SORT_ASC])->select(['id','fio'])->asArray()->all();


        $peopleNameAll = '';
        $arrayPeople = $model->person;
        $arrayPeople = explode(",", $arrayPeople);
        $arrayPeople = array_flip($arrayPeople);
        foreach ($branchPeopleNames as $branchPeopleName){
            if (isset($arrayPeople[$branchPeopleName['id']])){
                if ($peopleNameAll == null) $peopleNameAll =  '<h5 style="margin-top: 10px">' . $branchPeopleName['fio'] . '</h5>' ;
                else  $peopleNameAll = $peopleNameAll  .'<h5>' . $branchPeopleName['fio'] . '</h5>' ;
            }
        }
        foreach ($personNames as $personName){
            if (isset($arrayPeople[$personName['id'].'(666)'])){
                if ($peopleNameAll == null) $peopleNameAll =  '<h5 style="margin-top: 10px">' . $personName['fio'].' (' .$personName['workplace_other'].')' . '</h5>' ;
                else  $peopleNameAll = $peopleNameAll  .'<h5>' . $personName['fio'] .' (' .$personName['workplace_other'].')' .  '</h5>' ;
            }
        }

        $model2 =  $this->findModel($id);
        if ($model2->load(Yii::$app->request->post()) && $model2->save())
            return $this->redirect(['index']);



        return $this->render('view', [
            'peopleNameAll'=>$peopleNameAll,
            'forestgrowName' => $forestgrowName,
            'subjectName' => $subjectName,
            'municName' => $municName,
            'forestryName' => $forestryName,
            'subforestryName' => $subforestryName,
            'trforestryName' => $trforestryName,
            'trsubforestryName' => $trsubforestryName,
            'personName' => $personName,
            'branchName' => $branchName,
            'model' => $model,
            'model2' => $model2,
        ]);
    }

    /**
     * Creates a new TrainingProcess model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $branchList = Branch::find()->orderBy(['name' => SORT_ASC])->all();
        $areas = ResponsibilityArea::find()->all();
        $LPsRegionSub = ForestgrowRegionSubject::find()->select(['region_id', 'subject_id'])->asArray()->all();
        foreach ($areas as $area){
            if (isset(  $AreaArr[$area['branch_id']])) $AreaArr[$area['branch_id']] = $AreaArr[$area['branch_id']] . ',' . $area['federal_subject_id'];
            else $AreaArr[$area['branch_id']] = $area['federal_subject_id'];
        }
        foreach ($LPsRegionSub as $LPRegionSub){
            if (isset( $RegSubArr[$LPRegionSub['subject_id']]))  $RegSubArr[$LPRegionSub['subject_id']] =  $RegSubArr[$LPRegionSub['subject_id']] . ',' . $LPRegionSub['region_id'];
            else $RegSubArr[$LPRegionSub['subject_id']] = $LPRegionSub['region_id'];
        }



        $model = new TrainingProcess();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->verified) {
                $persons = $model->person;
                $persons = explode(",", $persons);
                foreach ($persons as $person){
                    $var = 1;
                    $people = BranchPerson::findOne($person);
                    if ($people->training_process_1 !=  $model->forestgrow_region  and !$people->training_process_1){
                        $people->training_process_1 = $model->forestgrow_region ;
                        $var = 0;
                    }
                    elseif ($people->training_process_2 !=  $model->forestgrow_region  and $var and !$people->training_process_2 and $people->training_process_1 !=  $model->forestgrow_region  ){
                        $people->training_process_2 = $model->forestgrow_region ;
                        $var = 0;
                    }
                    elseif ($people->training_process_3 !=  $model->forestgrow_region  and $var and !$people->training_process_3 and $people->training_process_1 !=  $model->forestgrow_region  and $people->training_process_2 !=  $model->forestgrow_region  ){
                        $people->training_process_3 = $model->forestgrow_region ;
                    }
                    $people->save();
                }
            }
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'branchList'=>$branchList,
            'AreaArr'=>$AreaArr,
            'RegSubArr'=>$RegSubArr,
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TrainingProcess model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        $branchList = Branch::find()->orderBy(['name' => SORT_ASC])->all();
        $areas = ResponsibilityArea::find()->all();
        $LPsRegionSub = ForestgrowRegionSubject::find()->select(['region_id', 'subject_id'])->asArray()->all();

        foreach ($areas as $area){
            if (isset(  $AreaArr[$area['branch_id']])) $AreaArr[$area['branch_id']] = $AreaArr[$area['branch_id']] . ',' . $area['federal_subject_id'];
            else $AreaArr[$area['branch_id']] = $area['federal_subject_id'];
        }

        foreach ($LPsRegionSub as $LPRegionSub){
            if (isset( $RegSubArr[$LPRegionSub['subject_id']]))  $RegSubArr[$LPRegionSub['subject_id']] =  $RegSubArr[$LPRegionSub['subject_id']] . ',' . $LPRegionSub['region_id'];
            else $RegSubArr[$LPRegionSub['subject_id']] = $LPRegionSub['region_id'];
        }

        $model = $this->findModel($id);
        $model2 = new UploadFormTraining();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->verified) {
                $persons = $model->person;
                $persons = explode(",", $persons);
                foreach ($persons as $person){
                    if (similar_text($person,'(666)') < 5){
                        $var = 1;
                        $people = BranchPerson::findOne($person);
                        if ($people->training_process_1 !=  $model->forestgrow_region  and !$people->training_process_1){
                            $people->training_process_1 = $model->forestgrow_region ;
                            $var = 0;
                        }
                        elseif ($people->training_process_2 !=  $model->forestgrow_region  and $var and !$people->training_process_2 and $people->training_process_1 !=  $model->forestgrow_region  ){
                            $people->training_process_2 = $model->forestgrow_region ;
                            $var = 0;
                        }
                        elseif ($people->training_process_3 !=  $model->forestgrow_region  and $var and !$people->training_process_3 and $people->training_process_1 !=  $model->forestgrow_region  and $people->training_process_2 !=  $model->forestgrow_region  ){
                            $people->training_process_3 = $model->forestgrow_region ;
                        }
                        $people->save();
                    }
                }
            }
//                    $people->training_process_1 = null;
//                    $people->training_process_2 = null;
//                    $people->training_process_3 = null;
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'branchList'=>$branchList,
            'AreaArr'=>$AreaArr,
            'RegSubArr'=>$RegSubArr,
            'model' => $model,
            'model2' => $model2,
        ]);
    }

    /**
     * Deletes an existing TrainingProcess model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpload()
    {

        //  Если получаем данные через запрос Ajax
        if(\Yii::$app->request->isAjax){
//            if (Yii::$app->request->post('namePeople') == null) $namePeople = 'XYI';
//            else  $namePeople = Yii::$app->request->post('namePeople');


            $model2 = new UploadFormTraining();

            // $zk = "no";
            // if(isset($_POST['zakup_num'])) $zk = "yes";


            // Тест на наличие переменных в глобальных массивах
            $req = false;
            ob_start();

            $checkNum = Yii::$app->request->post('UploadFormTraining');
            echo $checkNum['check_num'];

            $req = ob_get_contents();
            ob_end_clean();


            // Используем переменную из _POST для формирования имени папки для загружаемого файла
            $uploaddir = './docs/audit/training/'.Yii::$app->request->post('UploadFormTraining')['check_num'].'/';


            // При передаче номера закупки через сессию формируем имя папки используя переменную из сессии
            // $uploaddir = './docs/lu/zakupki/'.Yii::$app->session->get('zakup_num').'/';
            // if ($session->has('zakup_num') ) $uploaddir = $uploaddir . $session->get('zakup_num'); // проверяем, есть ли в сессии переменная

            if ($model2->load(Yii::$app->request->post())) $model2->people = $model2->namePeople . '_';
            $model2->stripCard = UploadedFile::getInstance($model2, 'stripCard');
            $model2->pppCard = UploadedFile::getInstance($model2, 'pppCard');
            $model2->pppMap = UploadedFile::getInstance($model2, 'pppMap');
            $model2->invite = UploadedFile::getInstance($model2, 'invite');
            $model2->act = UploadedFile::getInstance($model2, 'act');
            $model2->orderBranch = UploadedFile::getInstance($model2, 'orderBranch');
            $model2->orderOiv = UploadedFile::getInstance($model2, 'orderOiv');
            $model2->taxCard = UploadedFile::getInstance($model2, 'taxCard');
            $model2->statement = UploadedFile::getInstance($model2, 'statement');

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
                        $url = 'title="docs/audit/training/' . $checkNum . '/'.$docName .'"';
                        echo '<i class="fas fa-file-pdf"></i> ' . Html::a($NameMask, '/docs/audit/training/' . $checkNum . '/'.$docName , ['target'=>'_blank' ,'label' => 'Home', 'class'=>'name'] ) .'<span style="color: #337ab7;"  class="glyphicon glyphicon-trash trashfile" '.$url.'></span>'. '<br/>';

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
                var_dump(file_exists($fullname));
                return 'нет';
            }

        }

        // Если получили запрос к экшену не через аякс
        return $this->redirect(['/audit/training-process']);
    }





    public function actionChangeForestry()
    {
        if(\Yii::$app->request->isAjax){
            $subjectId = Yii::$app->request->post('subjectId');
            $municId = Yii::$app->request->post('municId');
            if ($municId == 0){
                echo '<option  value="0" > --- Выберите муниципальный район ---</option>';
                return  false;
            }
            else{
                $allForestyMunic = ForestryMunic::find()->where(['and',['subject_kod'=> $subjectId],['munic_region'=> $municId]])->asArray()->all();

                foreach ($allForestyMunic as $forestyMunic)
                    (isset($arrAllforest)) ? $arrAllforest .=  ',' . $forestyMunic["forestry_kod"] : $arrAllforest = $forestyMunic["forestry_kod"];

                $arrAllforest = explode(",", $arrAllforest);

                $forestys = Forestry::find()->where(['and',['=','subject_kod', $subjectId],['forestry_kod' => $arrAllforest]])->asArray()->all();

                if ($forestys != null){
                    echo '<option  value="0" selected> --- Не выбрано ---</option>';
                    foreach ($forestys as $forestry)
                        echo '<option value="' . $forestry['forestry_kod'] . '">' . $forestry['forestry_name'] . '</option>';
                }
                else {
                    echo '<option  value="0" > Нет лесничеств</option>';
                }
                return  true;
            }

        }
        return $this->redirect(['index']);
    }


    public function actionChangeSubforestry()
    {
        if(\Yii::$app->request->isAjax) {
            $subjectId = Yii::$app->request->post('subjectId');
            $forestryKod = Yii::$app->request->post('forestryKod');
            $subforestr = SubForestry::find()
                ->where(['subject_kod' => $subjectId ])
                ->andWhere(['forestry_kod' => $forestryKod ])
                ->all();
            if ($subforestr != null){
                foreach ($subforestr as $subforestry){
                    echo '<option value="' . $subforestry['id'] . '">' . $subforestry['subforestry_name'] . '</option>';
                }
            }
            else {
                echo '<option  value="0" > Нет участковых лесничеств</option>';
            }
            return  false;
        }
        return $this->redirect(['index']);
    }
    public function actionChangeMunic()
    {
        if(\Yii::$app->request->isAjax) {
            $subjectId = Yii::$app->request->post('subjectId');
            $forestgrowId = Yii::$app->request->post('forestgrowId');
//            $municKod = Forestry::find()->where(['id'=> $forestryId ])->select('forestry_kod')->one();
            $munics = MunicRegion::find()
                ->where(['federal_subject' => $subjectId ])
                ->andWhere(['forestgrow_region' => $forestgrowId ])
                ->all();
            if ($munics != null){
                    echo '<option  value="0" > --- Не выбрано --- </option>';
                foreach ($munics as $munic){
                    echo '<option value="' . $munic['id'] . '">' . $munic['name'] . '</option>';
                }
            }
            else {
                echo '<option  value="0" > Нет муниципальных районов</option>';
            }
            return  false;
        }
        return $this->redirect(['index']);
    }
    public function actionChangePeople()
    {
        if(\Yii::$app->request->isAjax) {
            $branchId = Yii::$app->request->post('branchId');
            $arrayPeople = Yii::$app->request->post('arrayPeople');
            $arrayPeople = explode(",", $arrayPeople);
            $arrayPeople = array_flip($arrayPeople);
            if ($branchId == 999){
                $branchName = Branch::find()->select('name')->asArray()->all();
                $branchPeoples = BranchPerson::find()->where(['is','date_dismissial',null])->orderBy(['fio' => SORT_ASC])->all();
                $TrainingPs = TrainingPerson::find()->where(['=','workplace_rli','666'])->orderBy(['fio' => SORT_ASC])->all();
                foreach ($branchPeoples as $branchPeople){
                    if (!isset($arrayPeople[$branchPeople->id])){
                        echo '<option value="' . $branchPeople['id'] . '">' . $branchPeople['fio'] . ' (' . $branchName[$branchPeople['branch']]['name']  . ')' . '</option>';
                    }

                }
                foreach ($TrainingPs as $TrainingP){
                    $idNotLes = $TrainingP->id .'(666)';
                    if (!isset($arrayPeople[$idNotLes])){
                        echo '<option value="' . $TrainingP['id'] .'(666)' . '">' . $TrainingP['fio'] . ' (' . $TrainingP['workplace_other'] . ')' . '</option>';
                    }
                }
            }
            elseif ($branchId == 666){
                $TrainingPs = TrainingPerson::find()->where(['=','workplace_rli','666'])->orderBy(['fio' => SORT_ASC])->all();
                if ($TrainingPs){
                    foreach ($TrainingPs as $TrainingP){
                        $idNotLes = $TrainingP->id .'(666)';
                        if (!isset($arrayPeople[$idNotLes])){
                            echo '<option value="' . $TrainingP['id'] .'(666)' . '">' . $TrainingP['fio']. ' (' . $TrainingP['workplace_other'] . ')' . '</option>';
                        }
                    }
                }
                else {
                    echo '<option  disabled selected> Не найдено участников</option>';
                }
            }
            else{
                $branchPeoples = BranchPerson::find()->where(['=','branch',"$branchId"])->orderBy(['fio' => SORT_ASC])->all();
                if ($branchPeoples){
                    foreach ($branchPeoples as $branchPeople){
                        if (!isset($arrayPeople[$branchPeople->id])){
                            echo '<option value="' . $branchPeople['id'] . '">' . $branchPeople['fio'] . '</option>';
                        }
                    }
                }
                else {
                    echo '<option  disabled selected> Не найдено участников</option>';
                }

            }
            return  false;
        }
        return $this->redirect(['index']);
    }
    public function actionViewPeople()
    {
        if(\Yii::$app->request->isAjax) {

//            $branchId = Yii::$app->request->post('branchId');
            $arrayPeople = Yii::$app->request->post('arrayPeople');
            $arrayPeople = explode(",", $arrayPeople);
            $arrayPeople = array_flip($arrayPeople);

            $branchName = Branch::find()->all();
            $branchPeoples = BranchPerson::find()->orderBy(['fio' => SORT_ASC])->all();
            $TrainingPs = TrainingPerson::find()->where(['=','workplace_rli','666'])->orderBy(['fio' => SORT_ASC])->all();
            foreach ($branchPeoples as $branchPeople){
                if (isset($arrayPeople[$branchPeople->id])){
                    echo '<option value="' . $branchPeople['id'] . '">' . $branchPeople['fio'] . ' (' . $branchName[$branchPeople['branch']]['name']  . ')' . '</option>';
                }

            }
            if ($TrainingPs){
                foreach ($TrainingPs as $TrainingP){
                    $idNotLes = $TrainingP->id .'(666)';
                    if (isset($arrayPeople[$idNotLes])){
                        echo '<option value="' . $TrainingP['id'] .'(666)' . '">' . $TrainingP['fio']. ' (' . $TrainingP['workplace_other'] . ')' . '</option>';
                    }
                }
            }
            return  false;
        }
        return $this->redirect(['index']);
    }



    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TrainingProcess model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TrainingProcess the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TrainingProcess::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    /** Инструкция  **/
    public function actionInstruction()
    {
        return $this->render('instructionprocess');
    }
    public function actionInstructionAuditPdf()
    {
        $content = $this->renderPartial('instructionprocess');

        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'filename' => 'Инструкция_Тренировки.pdf',
            'content' => $content,
            // 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => '.pdf_but {display: none}
                            p, li {font-family: serif; font-size12px; line-height: 1.3}
                            .forest-work-index {padding-right: 0}
            ',
            'options' => ['title' => 'Инструкция по контролю проведения тренировочных процессов'],
            'methods' => [
                'SetHeader'=>['Инструкция по контролю проведения тренировочных процессов'],
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);

        return $pdf->render();
    }
}
