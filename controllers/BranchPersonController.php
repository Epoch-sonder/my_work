<?php

namespace app\controllers;

use app\models\Branch;
use app\modules\audit\models\Brigade;
use app\modules\audit\models\ForestgrowRegion;
use Yii;
use app\models\BranchPerson;
use app\models\SearchBranchPerson;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BranchPersonController implements the CRUD actions for BranchPerson model.
 */
class BranchPersonController extends Controller
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
     * Lists all BranchPerson models.
     * @return mixed
     */
    public function actionIndex()
    {
        $branchList = Branch::find()->orderBy(['name' => SORT_ASC])->all();
        $searchModel = new SearchBranchPerson();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $brigages = Brigade::find()->select(['id','brigade_number'])->asArray()->all();
        foreach ($brigages as $brigage) $brigageName[$brigage['id']] = $brigage['brigade_number'];
        if (!isset($brigageName)) $brigageName = '';
//        $forestgrows= ForestgrowRegion::find()->select(['id','name'])->asArray()->all();
//        foreach ($forestgrows as $forestgrow){
//            $forestgrowName[$forestgrow['id']] = $forestgrow['name'];
//        }



        return $this->render('index', [
             'branchList'=>$branchList,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'brigageName' => $brigageName,
//            'forestgrowName' => $forestgrowName,
        ]);
    }

    /**
     * Displays a single BranchPerson model.
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
     * Creates a new BranchPerson model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BranchPerson();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BranchPerson model.
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
     * Deletes an existing BranchPerson model.
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
     * Finds the BranchPerson model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BranchPerson the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BranchPerson::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }







    public function actionViewSpecialist()
    {
        //  Если получаем данные через запрос Ajax
        if(Yii::$app->request->isAjax){
            $branch = Yii::$app->request->post('branch');
            $peoples = BranchPerson::find()->where(['=', 'branch', $branch])
                ->orderBy(['fio' => SORT_ASC])->asArray()->all();
            if ($peoples){
                foreach ($peoples as $people) {
                        echo '<option value="' . $people['id'] . '">' . $people['fio'] . '</option>';
                }
            }
            else{
                echo '<option value="NO" selected="" disabled=""> Не найдено специалистов</option>';
            }

            return true;

        }
        return $this->redirect(['index']);

    }

    public function actionDeleteTraining()
    {
        //  Если получаем данные через запрос Ajax
        if(Yii::$app->request->isAjax){
            $people = Yii::$app->request->post('people');
            $tran1 = Yii::$app->request->post('tran1');
            $tran2 = Yii::$app->request->post('tran2');
            $tran3 = Yii::$app->request->post('tran3');
            if ($tran1 == 'true') $tran1 = 1;
            else $tran1 = '';
            if ($tran2 == 'true') $tran2 = 2;
            else $tran2 = '';
            if ($tran3 == 'true') $tran3 = 3;
            else $tran3 = '';
            if ($people == 666){
                $branchPersons = BranchPerson::find()->all();
                foreach ($branchPersons as $branchPerson){
                    if ($branchPerson->num_brigade == null){
                        if ($tran1 == 1) {$branchPerson->training_process_1 = null;}
                        if ($tran2 == 2) {$branchPerson->training_process_2 = null;}
                        if ($tran3 == 3) {$branchPerson->training_process_3 = null;}
                        $branchPerson->save();
                    }
                }
                return '<h1> Очищены от тренировки № '.$tran1.' '.$tran2.' '.$tran3.' у всех специалистов</h1> 
                        <a class="btn btn-primary close-modal" data-modal="#modal1" href="#" style="margin-top:10px ">Вернуться</a>
                        <script>$(".close-modal").on("click", function(){
                            $(".glyphicon").css("display", "block")
                            modal = $(".close-modal").data("modal");
                            $(modal).removeClass("open");
                            $(modal).parents(".overlay").removeClass("open");
                        });</script>';
            }
            else{
                $arrayPeople = explode(",", $people);
                $arrayPeople = array_combine($arrayPeople,$arrayPeople);
                $branchPersons = BranchPerson::find()->all();
                $namePeople = '';
                foreach ($branchPersons as $branchPerson){
                    if (isset($arrayPeople[$branchPerson['id']])){
                        if ($branchPerson->num_brigade == null){
                            if ($tran1 == 1) {$branchPerson->training_process_1 = null;}
                            if ($tran2 == 2) {$branchPerson->training_process_2 = null;}
                            if ($tran3 == 3) {$branchPerson->training_process_3 = null;}
                            $branchPerson->save();
                        }

                        else{
                            $brigade = Brigade::find()->where(['=','id',$branchPerson->num_brigade])->one();
                            if ($tran1 == 1 and $brigade->forestgrow_region != $branchPerson->training_process_1) {$branchPerson->training_process_1 = null;}
                            if ($tran2 == 2 and $brigade->forestgrow_region != $branchPerson->training_process_2) {$branchPerson->training_process_2 = null;}
                            if ($tran3 == 3 and $brigade->forestgrow_region != $branchPerson->training_process_3) {$branchPerson->training_process_3 = null;}
                            $branchPerson->save();
                        }
                        if ($namePeople) $namePeople .= ', '.$branchPerson->fio ;
                        else $namePeople = $branchPerson->fio;
                    }

                }

                return '<h1> Очищены от тренировок № '.$tran1.' '.$tran2.' '.$tran3.' у специалистов:</h1> 
                        <h3> '.$namePeople.'</h3> 
                        <a class="btn btn-primary close-modal" data-modal="#modal1" href="#" style="margin-top:10px ">Вернуться</a>
                         <script>$(".close-modal").on("click", function(){
                            $(".glyphicon").css("display", "block")
                            modal = $(".close-modal").data("modal");
                            $(modal).removeClass("open");
                            $(modal).parents(".overlay").removeClass("open");
                        });</script>';
            }

            return false;

        }
        return $this->redirect(['index']);

    }















}
