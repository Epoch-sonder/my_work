<?php

namespace app\modules\lu\controllers;

use Yii;
use app\modules\lu\models\VegetPeriod;
use app\modules\lu\models\SearchVegetPeriod;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VegetPeriodController implements the CRUD actions for VegetPeriod model.
 */
class VegetPeriodController extends Controller
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
     * Lists all VegetPeriod models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchVegetPeriod();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VegetPeriod model.
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
     * Creates a new VegetPeriod model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new VegetPeriod();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing VegetPeriod model.
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
     * Deletes an existing VegetPeriod model.
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



    public function actionGetPeriod()
    {
        //  Если получаем данные через запрос Ajax
        if(\Yii::$app->request->isAjax){

            $cur_subject = Yii::$app->request->post('cur_subject');
            if($cur_subject == null) return '';

            $dateborders = VegetPeriod::find()->where(['subject_id' => $cur_subject])->one();

            $months = array(1 => 'января', 'февраля', 'марта', 'апрель', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');

            // $vpss = date_format($vps, 'd') . ' ' . $months[date( 'n' )]; // date( 'n' ) возвращает номер текущего месяца
            $vps = date_create_from_format('Y-m-d', $dateborders->veget_start); // Преобразуем строку с датой в дату
            $vegetPeriodStart = $vps->format('d') . ' ' . $months[$vps->format('n')];

            // $vegetPeriodFinish = $dateborders->veget_finish;
            $vpf = date_create_from_format('Y-m-d', $dateborders->veget_finish); // Преобразуем строку с датой в дату
            $vegetPeriodFinish = $vpf->format('d') . ' ' . $months[$vpf->format('n')];

            return ($vegetPeriodStart . ' - ' . $vegetPeriodFinish);
        }

        return $this->redirect(['/lu/zakup-card']);
    }


    /**
     * Finds the VegetPeriod model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VegetPeriod the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VegetPeriod::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
