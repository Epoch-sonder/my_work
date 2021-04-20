<?php

namespace app\modules\audit\controllers;

use Yii;
use app\modules\audit\models\MunicRegion;
use app\modules\audit\models\SearchMunicRegion;
use app\modules\audit\models\ForestgrowRegionSubject;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * MunicRegionController implements the CRUD actions for MunicRegion model.
 */
class MunicRegionController extends Controller
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
     * Lists all MunicRegion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchMunicRegion();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MunicRegion model.
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
     * Creates a new MunicRegion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $LPsRegionSub = ForestgrowRegionSubject::find()->select(['region_id', 'subject_id'])->asArray()->all();
        foreach ($LPsRegionSub as $LPRegionSub){
            if (isset( $RegSubArr[$LPRegionSub['subject_id']]))  $RegSubArr[$LPRegionSub['subject_id']] =  $RegSubArr[$LPRegionSub['subject_id']] . ',' . $LPRegionSub['region_id'];
            else $RegSubArr[$LPRegionSub['subject_id']] = $LPRegionSub['region_id'];
        }

        $model = new MunicRegion();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'RegSubArr'=>$RegSubArr,
        ]);
    }

    /**
     * Updates an existing MunicRegion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $LPsRegionSub = ForestgrowRegionSubject::find()->select(['region_id', 'subject_id'])->asArray()->all();
        foreach ($LPsRegionSub as $LPRegionSub){
            if (isset( $RegSubArr[$LPRegionSub['subject_id']]))  $RegSubArr[$LPRegionSub['subject_id']] =  $RegSubArr[$LPRegionSub['subject_id']] . ',' . $LPRegionSub['region_id'];
            else $RegSubArr[$LPRegionSub['subject_id']] = $LPRegionSub['region_id'];
        }
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'RegSubArr'=>$RegSubArr,
        ]);
    }

    /**
     * Deletes an existing MunicRegion model.
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
     * Finds the MunicRegion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MunicRegion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MunicRegion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
