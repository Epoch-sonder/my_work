<?php

namespace app\modules\lu\controllers;

use app\models\BranchPerson;
use app\models\SearchBranchPerson;
use app\modules\lu\models\UploadFormVaccination;
use Yii;
use app\modules\lu\models\Vaccination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * VaccinationController implements the CRUD actions for Vaccination model.
 */
class VaccinationController extends Controller
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
     * Lists all Vaccination models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchBranchPerson();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Vaccination model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $vaccinations = Vaccination::find()->where(['=','person_id',$id])->all();
        $branchPerson = BranchPerson::find()->where(['=','id',$id])->one();
        $arrayMonthR =array( 1 => "января", "февраля","марта", "апреля","мая","июня","июля","августа","сентября","октября","ноября","декабря" );

        return $this->render('view', [
            'vaccinations' => $vaccinations,
            'branchPerson' => $branchPerson,
            'arrayMonthR' => $arrayMonthR,
        ]);
    }

    /**
     * Creates a new Vaccination model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Vaccination();
        $model2 = new UploadFormVaccination();
        if ($model->load(Yii::$app->request->post()) && $model2->load(Yii::$app->request->post()) ) {

            // загрузка файла
            $model2 = new UploadFormVaccination();
            $model2->vaccin = UploadedFile::getInstance($model2, 'vaccin');
            // путь файла
            $filename = $model2->upload();

            // какая вакцина 1,2 или 3
            if ($model->vaccin == 1) $numVaccin = 'first_vaccination';
            elseif ($model->vaccin == 2) $numVaccin = 'second_vaccination';
            elseif ($model->vaccin == 3) $numVaccin = 'third_vaccination';

            // массив с людьми
            $peoples =  explode(",", $model->person_id);

            foreach ($peoples as $people){
                // Добавление людей в базу
                $vaccin = new Vaccination();
                $vaccin->person_id = $people;
                $vaccin->$numVaccin = $model->date_cheak;
                $vaccin->url_docs = $filename;
                $vaccin->save(false);
            }

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'model2' => $model2,
        ]);
    }

    /**
     * Updates an existing Vaccination model.
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
     * Deletes an existing Vaccination model.
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
     * Finds the Vaccination model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Vaccination the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Vaccination::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionRenderPeople()
    {
        if(\Yii::$app->request->isAjax){
            $branchId = Yii::$app->request->post('branchId');
            $vaccin = Yii::$app->request->post('vaccin');
            $arrayPeople = Yii::$app->request->post('arrayPeople');
            // массив с людьми
            $arrayPeople = explode(",", $arrayPeople);
            $arrayPeople = array_flip($arrayPeople);

            if ($vaccin == 1){
                if ($branchId == 0) $allPeoples = BranchPerson::find()->orderBy(['fio'=>SORT_ASC])->all();
                else $allPeoples = BranchPerson::find()->where(['=','branch', $branchId])->orderBy(['fio'=>SORT_ASC])->all();

                foreach ($allPeoples as $allPeople){
                    if (!isset($arrayPeople[$allPeople->id])){
                        echo '<option value="' . $allPeople['id'] . '">' . $allPeople['fio'] . '</option>';

                    }
                }

            }

            if ($vaccin == 2){
                if ($branchId == 0) $allPeoples = BranchPerson::find()->orderBy(['fio'=>SORT_ASC])->all();
                else $allPeoples = BranchPerson::find()->where(['=','branch', $branchId])->orderBy(['fio'=>SORT_ASC])->all();

                $dataDefold = new \DateTime(date_default_timezone_get());
                $monthMinusDate = $dataDefold->modify('-3 month')->format('Y-m-d');

                $peoplesVaccin = Vaccination::find()->where(['IS NOT','first_vaccination', null])->where(['>=' , 'first_vaccination', "$monthMinusDate"])->orderBy(['first_vaccination'=>SORT_DESC])->all();
                foreach ($peoplesVaccin as $peopleVaccin){
                    if (!isset($arrayVaccin[$peopleVaccin->person_id])){
                        $arrayVaccin[$peopleVaccin->person_id] = $peopleVaccin->person_id;
                    }
                }
                foreach ($allPeoples as $allPeople){
                    if (!isset($arrayPeople[$allPeople->id]) and isset($arrayVaccin[$allPeople->id])){
                        echo '<option value="' . $allPeople['id'] . '">' . $allPeople['fio'] . '</option>';
                    }
                }
            }

            if ($vaccin == 3){
                if ($branchId == 0) $allPeoples = BranchPerson::find()->orderBy(['fio'=>SORT_ASC])->all();
                else $allPeoples = BranchPerson::find()->where(['=','branch', $branchId])->orderBy(['fio'=>SORT_ASC])->all();

                $dataDefold = new \DateTime(date_default_timezone_get());
                $monthMinusDate = $dataDefold->modify('-13 month')->format('Y-m-d');

                $peoplesVaccin = Vaccination::find()->where(['IS NOT','second_vaccination', null])->where(['>=' , 'second_vaccination', "$monthMinusDate"])->orderBy(['second_vaccination'=>SORT_DESC])->all();
                foreach ($peoplesVaccin as $peopleVaccin){
                    if (!isset($arrayVaccin[$peopleVaccin->person_id])){
                        $arrayVaccin[$peopleVaccin->person_id] = $peopleVaccin->person_id;
                    }
                }
                foreach ($allPeoples as $allPeople){
                    if (!isset($arrayPeople[$allPeople->id]) and isset($arrayVaccin[$allPeople->id])){
                        echo '<option value="' . $allPeople['id'] . '">' . $allPeople['fio'] . '</option>';
                    }
                }
            }


            return true;
        }

        return $this->redirect(['index']);
    }

    public function actionViewPeople()
    {
        if(\Yii::$app->request->isAjax){
            $arrayPeople = Yii::$app->request->post('arrayPeople');
            $arrayPeople = explode(",", $arrayPeople);
            $arrayPeople = array_flip($arrayPeople);

            $allPeoples = BranchPerson::find()->orderBy(['fio'=>SORT_ASC])->all();
            foreach ($allPeoples as $allPeople){
                if (isset($arrayPeople[$allPeople->id])){
                    echo '<option value="' . $allPeople['id'] . '">' . $allPeople['fio'] . '</option>';

                }
            }

            return true;
        }

        return $this->redirect(['index']);
    }

}
