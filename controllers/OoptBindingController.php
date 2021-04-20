<?php

namespace app\controllers;

use app\modules\audit\models\MunicRegion;
use Yii;
use app\models\OoptBinding;
use app\models\SearchOoptBinding;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OoptBindingController implements the CRUD actions for OoptBinding model.
 */
class OoptBindingController extends Controller
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
     * Lists all OoptBinding models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchOoptBinding();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OoptBinding model.
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
     * Creates a new OoptBinding model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OoptBinding();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing OoptBinding model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing OoptBinding model.
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
     * Finds the OoptBinding model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OoptBinding the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OoptBinding::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionChangeMunic()
    {
        if(\Yii::$app->request->isAjax) {
            $subjectId = Yii::$app->request->post('subjectId');
//            $municKod = Forestry::find()->where(['id'=> $forestryId ])->select('forestry_kod')->one();
            $munics = MunicRegion::find()
                ->where(['federal_subject' => $subjectId ])
                ->all();
            if ($munics != null){
                foreach ($munics as $munic){
                    echo '<option value="' . $munic['id'] . '">' . $munic['name'] . '</option>';
                }
            }
            else {
                echo '<option  value > Нет муниципальных районов</option>';
            }
            return  false;
        }
        return $this->redirect(['index']);
    }


}
