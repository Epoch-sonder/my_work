<?php

namespace app\modules\lu\controllers;

use app\models\BranchPerson;
use app\modules\lu\models\User;
use app\modules\lu\models\ZakupCard;
use app\modules\pd\models\Branch;
use Yii;
use app\modules\lu\models\GpsTracking;
use app\modules\lu\models\SearchGpsTracking;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GpsTrackingController implements the CRUD actions for GpsTracking model.
 */
class GpsTrackingController extends Controller
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
     * Lists all GpsTracking models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchGpsTracking();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $arrayMonth =array( 1 => "января", "февраля","марта", "апреля","мая","июня","июля","августа","сентября","октября","ноября","декабря" );
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'arrayMonth' => $arrayMonth,
        ]);
    }

    /**
     * Displays a single GpsTracking model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $branch = Branch::find()->where(['=','branch_id',$model->branch])->select(['name'])->one();
        $contract = ZakupCard::find()->where(['=','id',$model->contract])->select(['zakup_num'])->one();
        $specialist = BranchPerson::find()->where(['=','id',$model->specialist])->select(['fio'])->one();
        $party_leader = BranchPerson::find()->where(['=','id',$model->party_leader])->select(['fio'])->one();
        $fio_responsible = User::find()->where(['=','id',$model->fio_responsible])->select(['fio'])->one();

        return $this->render('view', [
            'branch' => $branch,
            'contract' => $contract,
            'specialist' => $specialist,
            'party_leader' => $party_leader,
            'fio_responsible' => $fio_responsible,
            'model' => $model,
        ]);
    }

    /**
     * Creates a new GpsTracking model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GpsTracking();
        if ($model->load(Yii::$app->request->post())) {
            $model->fio_responsible = Yii::$app->user->identity->id;
            $model->date_create = date("Y-m-d");
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing GpsTracking model.
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
     * Deletes an existing GpsTracking model.
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
     * Finds the GpsTracking model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GpsTracking the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GpsTracking::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionConfirmationGps()
    {
        if(\Yii::$app->request->isAjax){
            $arrayMonthR =array( 1 => "января", "февраля","марта", "апреля","мая","июня","июля","августа","сентября","октября","ноября","декабря" );

            $dateDefold = new \DateTime(date_default_timezone_get());
            $dateD =$dateDefold->format('d');
            $dateM =$dateDefold->format('m');
            $dateM *= 1;
            $dateY =$dateDefold->format('Y');
            $dateDefold = $dateDefold->format('Y-m-d');

            $month = Yii::$app->request->post('month');
            $pageID = Yii::$app->request->post('id_page');
            $track_gps = GpsTracking::findOne($pageID);
            switch ($month){
               case 1:
                   $track_gps->april_recd = $dateDefold;
                   break;
               case 2:
                   $track_gps->may_recd = $dateDefold;
                   break;
               case 3:
                   $track_gps->june_recd = $dateDefold;
                   break;
               case 4:
                   $track_gps->july_recd = $dateDefold;
                   break;
               case 5:
                   $track_gps->august_recd = $dateDefold;
                   break;
               case 6:
                   $track_gps->september_recd = $dateDefold;
                   break;
               case 7:
                   $track_gps->october_recd = $dateDefold;
                   break;
               case 8:
                   $track_gps->november_recd = $dateDefold;
                   break;
            }
            $track_gps->save();
            return '<div class="date_view">'.  $dateD.' '.$arrayMonthR[$dateM].' '.$dateY.'</div>';
       }

        return $this->redirect(['index']);
    }
    public function actionVerifiedGps()
    {
        if(\Yii::$app->request->isAjax){
            $month = Yii::$app->request->post('month');
            $pageID = Yii::$app->request->post('id_page');
            $track_gps = GpsTracking::findOne($pageID);
            switch ($month){
               case 1:
                   $track_gps->april_check = 1;
                   break;
               case 2:
                   $track_gps->may_check = 1;
                   break;
               case 3:
                   $track_gps->june_check = 1;
                   break;
               case 4:
                   $track_gps->july_check = 1;
                   break;
               case 5:
                   $track_gps->august_check = 1;
                   break;
               case 6:
                   $track_gps->september_check = 1;
                   break;
               case 7:
                   $track_gps->october_check = 1;
                   break;
               case 8:
                   $track_gps->november_check = 1;
                   break;
            }
            $track_gps->save();
            return true;
       }

        return $this->redirect(['index']);
    }

    public function actionDeleteTracking()
    {
        if(\Yii::$app->request->isAjax){
            $month = Yii::$app->request->post('month');
            $pageID = Yii::$app->request->post('id_page');
            $track_gps = GpsTracking::findOne($pageID);
            switch ($month){
               case 1:
                   $track_gps->april_check = 0;
                   $track_gps->april_recd = '';
                   break;
               case 2:
                   $track_gps->may_check = 0;
                   $track_gps->may_recd = '';
                   break;
               case 3:
                   $track_gps->june_check = 0;
                   $track_gps->june_recd = '';
                   break;
               case 4:
                   $track_gps->july_check = 0;
                   $track_gps->july_recd = '';
                   break;
               case 5:
                   $track_gps->august_check = 0;
                   $track_gps->august_recd = '';
                   break;
               case 6:
                   $track_gps->september_check = 0;
                   $track_gps->september_recd = '';
                   break;
               case 7:
                   $track_gps->october_check = 0;
                   $track_gps->october_recd = '';
                   break;
               case 8:
                   $track_gps->november_check = 0;
                   $track_gps->november_recd = '';
                   break;
            }
            $track_gps->save();
            return true;
       }

        return $this->redirect(['index']);
    }

}
