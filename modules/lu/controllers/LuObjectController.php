<?php

namespace app\modules\lu\controllers;

use app\modules\lu\models\SubforestryDefense;
use app\modules\pd\models\SubForestry;
use Yii;
use app\modules\lu\models\LuObject;
use app\modules\lu\models\SearchLuObject;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LuObjectController implements the CRUD actions for LuObject model.
 */
class LuObjectController extends Controller
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
     * Lists all LuObject models.
     * @return mixed
     */
    public function actionIndex()
    {
        
        $zakup_id = Yii::$app->request->get('zakup');

        // Если известно для какой закупки хотим смотреть объекты, смотрим
        if ($zakup_id) {

            $searchModel = new SearchLuObject();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            $dataProvider->query
                ->andWhere(['zakup' => $zakup_id])
                ->orderBy(['id' => SORT_ASC]);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'zakup_id' => $zakup_id,
            ]);
        }

        // Если номер закупки отсутствует, редиректим на список закупок
        return $this->redirect(['/lu/zakup-card']);
    }

    /**
     * Displays a single LuObject model.
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
     * Creates a new LuObject model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $zakup_id = Yii::$app->request->get('zakup');

        // Если известно для какой закупки объекты
        if ($zakup_id) {

            $searchModel = new SearchLuObject();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            $dataProvider->query
                ->andWhere(['zakup' => $zakup_id])
                ->orderBy(['id' => SORT_ASC]);

            

            $model = new LuObject();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                // return $this->redirect(['view', 'id' => $model->id], 'zakup_id' => $zakup_id);
             }

            return $this->render('create', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'zakup_id' => $zakup_id,
            ]);

        }

        // Если номер закупки отсутствует, редиректим на список закупок
        return $this->redirect(['/lu/zakup-card']);

    }

    // Изначальный экшен Create
    // {
    //     $model = new LuObject();

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Updates an existing LuObject model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $zakup_id = Yii::$app->request->get('zakup');

        // Если известно для какой закупки объекты
        if ($zakup_id) {

            $searchModel = new SearchLuObject();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            $dataProvider->query
                ->andWhere(['zakup' => $zakup_id])
                ->orderBy(['id' => SORT_ASC]);



            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'zakup_id' => $zakup_id,
            ]);

        }

        // Если номер закупки отсутствует, редиректим на список закупок
        return $this->redirect(['/lu/zakup-card']);

    }

    /**
     * Deletes an existing LuObject model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionChangeLes()
    {
        if(\Yii::$app->request->isAjax){

            $lesId = Yii::$app->request->post('lesId');
            $subId = Yii::$app->request->post('subId');
            $landCatId = Yii::$app->request->post('landCatId');
            if($landCatId == 1) {
                $Subforestys = SubForestry::find()
                    ->where(['=', 'subject_kod', $subId])
                    ->andWhere(['forestry_kod' => $lesId])->all();
                if ($Subforestys != null){
                    echo '<option  value="0" selected> --- Не выбрано ---</option>';
                    foreach ($Subforestys as $Subforesty) {
                        echo '<option value="' . $Subforesty['subforestry_kod'] . '">' . $Subforesty['subforestry_name'] . '</option>';
                    }
                }
                else {
                    echo '<option  value="0" > Нет лесничеств</option>';
                }
                return false;
            }
            elseif ($landCatId == 2) {
                $SubforestryDefenses = SubforestryDefense::find()
                    ->where(['=', 'subject_kod', $subId])
                    ->andWhere(['=', 'forestry_kod', $lesId])->all();
                if ($SubforestryDefenses != null){
                    echo '<option  value="0" selected> --- Не выбрано ---</option>';
                    foreach ($SubforestryDefenses as $SubforestryDefense) {
                        echo '<option value="' . $SubforestryDefense['id'] . '">' . $SubforestryDefense['subforestry_name'] . '</option>';
                    }
                }
                else {
                    echo '<option  value="0" > Нет лесничеств</option>';
                }
                return false;
            }
            else{
                return false;
            }

        }

        // Если получили запрос к экшену не через аякс
        return $this->redirect(['/lu/lu-object/create']);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the LuObject model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LuObject the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LuObject::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
