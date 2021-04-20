<?php

namespace app\modules\lu\controllers;

use app\modules\lu\models\Cityregion;
use app\modules\lu\models\Forestry;
use app\modules\lu\models\ForestryDefense;
use app\modules\lu\models\LuObject;
use app\modules\lu\models\Month;
use app\modules\lu\models\Oopt;
use app\modules\lu\models\Subforestry;
use app\modules\lu\models\TaxationWay;
use Yii;
use app\modules\lu\models\LuObjectProcess;
use app\modules\lu\models\SearchLuObjectProcess;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LuObjectProcessController implements the CRUD actions for LuObjectProcess model.
 */
class LuObjectProcessController extends Controller
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
     * Lists all LuObjectProcess models.
     * @return mixed
     */
    public function actionIndex()
    {
        $zakup_id = Yii::$app->request->get('zakup');
        $step_id = Yii::$app->request->get('step');

        $object_name = LuObject::find()
            ->where(['zakup' => Yii::$app->request->get('zakup')])
            ->orderBy(['fed_subject' => SORT_ASC])
            ->orderBy(['region' => SORT_ASC])
            ->all();
        //Записываем в переменную массив из id
        $arrayNumObject = array_column($object_name , 'id');
        $taxationWay = TaxationWay::find()->all();
        $month_all = Month::find()->all();

        $object_process = array();
        //Записываем в переменную массив все данные которые есть в бд
        for ($i=0;$i < count($arrayNumObject);$i++){
            $objects_process = LuObjectProcess::find()
                ->where( ['lu_object'=>$arrayNumObject[$i] , 'lu_process_step' => Yii::$app->request
                ->get('step')])
                ->all();
            $object_process = array_merge($object_process,$objects_process);
        }

        $object_names_arr = array();
        //Записываем в переменную массив все данные которые есть в бд
        foreach($object_name as $object_names){
            if($object_names->land_cat == 1){
                $names_obj = Forestry::find()
                    ->where(['subject_kod' => $object_names['fed_subject'] , 'forestry_kod' => $object_names['region']])
                    ->all();
                $object_names_arr = array_merge($object_names_arr, $names_obj);
            }
            elseif($object_names->land_cat == 2){
                $names_obj = ForestryDefense::find()
                    ->where(['subject_kod' => $object_names['fed_subject'] , 'forestry_kod' => $object_names['region']])
                    ->all();
                $object_names_arr = array_merge($object_names_arr, $names_obj);
            }
            elseif($object_names->land_cat == 3 ){
                $names_obj = Cityregion::find()
                    ->where(['subject_kod' => $object_names['fed_subject'] , 'cityregion_kod' => $object_names['region']])
                    ->all();
                $object_names_arr = array_merge($object_names_arr, $names_obj);
            }
            elseif($object_names->land_cat == 4 ){
                $names_obj = Oopt::find()
                    ->where(['subject_kod' => $object_names['fed_subject'] , 'oopt_kod' => $object_names['region']])
                    ->all();
                $object_names_arr = array_merge($object_names_arr, $names_obj);
            }
//            elseif($object_names->land_cat == 5 ){
//                $names_obj = Oopt::find()
//                    ->where(['subject_kod' => $object_names['fed_subject'] , 'oopt_kod' => $object_names['region']])
//                    ->all();
//                $object_names_arr = array_merge($object_names_arr, $names_obj);
//            }
        }

        $searchModel = new SearchLuObjectProcess();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = new LuObjectProcess();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'zakup' => $zakup_id,'step' =>  $step_id  ,]);
        }

        return $this->render('index', [
            'taxationWay'=>$taxationWay,
            'object_names_arr'=>$object_names_arr,
            'object_name'=>$object_name,
            'month_all'=>$month_all,
            'arrayNumObject'=>$arrayNumObject,
            'object_process'=>$object_process,
            'model' => $model,
            'step_id'=>$step_id,
            'zakup_id'=>$zakup_id,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }

    /**
     * Displays a single LuObjectProcess model.
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
     * Creates a new LuObjectProcess model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $zakup_id = Yii::$app->request->get('zakup');
        $object_id = Yii::$app->request->get('object');
        $step_id = Yii::$app->request->get('step');

        $searchModel = new SearchLuObjectProcess();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = new LuObjectProcess();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['create', 'zakup' => $zakup_id,'step' =>  $step_id  , 'object' => $object_id]);

        }

        return $this->render('create', [
            'model' => $model,
            'step_id'=>$step_id,
            'object_id'=>$object_id,
            'zakup_id'=>$zakup_id,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing LuObjectProcess model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $zakup_id = Yii::$app->request->get('zakup');
        $object_id = Yii::$app->request->get('object');
        $step_id = Yii::$app->request->get('step');
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['create', 'zakup' => $zakup_id,'step' => $step_id  , 'object' => $object_id]);
        }

        return $this->render('update', [
            'model' => $model,
            'step_id'=>$step_id,
            'object_id'=>$object_id,
            'zakup_id'=>$zakup_id,
        ]);
    }

    /**
     * Deletes an existing LuObjectProcess model.
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
     * Finds the LuObjectProcess model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LuObjectProcess the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LuObjectProcess::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
