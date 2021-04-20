<?php

namespace app\modules\pd\controllers;

use Yii;
use app\modules\pd\models\PdWorkProcess;
use app\modules\pd\models\SearchPdWorkProcess;
use app\modules\pd\models\PdWork;
use app\modules\pd\models\PdWorktype;
use app\modules\pd\models\Branch;
use app\modules\pd\models\BasedocType;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pd\models\UploadFormProcess;
use yii\web\UploadedFile;

/**
 * PdWorkProcessController implements the CRUD actions for PdWorkProcess model.
 */
class PdWorkProcessController extends Controller
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
     * Lists all PdWorkProcess models.
     * @return mixed
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;
        // $pdwork_id = $request->post('pd_work');
        $pdwork_id = $request->get('pd_work');


        // Выводим стадии для проектной документации только если указан айдишник этой документации в GET-запросе
        if ($pdwork_id) {

            $searchModel = new SearchPdWorkProcess();
            $dataProvider = $searchModel->search($request->queryParams);

            $dataProvider->query
                ->andWhere(['pd_work' => $pdwork_id])
                ->orderBy(['report_date' => SORT_DESC, 'timestamp' => SORT_DESC]);
             
            $pdwork = PdWork::find()->where(['id'=>$pdwork_id])->one();
            $pdwork->pdworktype = PdWorkType::find()->where(['id' => $pdwork->work_name])->one();
            $pdwork->branchname = Branch::find()->where(['branch_id' => $pdwork->branch])->one();
            $pdwork->docName = BasedocType::find()->where(['id' => $pdwork->basedoc_type])->one();

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'pdwork' => $pdwork,
            ]);

        }

        // Если в GET-запросе нет параметра pd_work переводим на страницу со списком работ
        return $this->redirect(['/pd/pd-work']);
        // return Yii::$app->runAction('pd/pd-work/index');

    }

    /**
     * Displays a single PdWorkProcess model.
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
     * Creates a new PdWorkProcess model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

	//  public function actions()
	// {
 //    return [
 //        'upload'=>[
 //            'class'=>'trntv\filekit\actions\UploadAction',
 //            'fileStorage' => 'docsStorage'
 //        ]
 //    ];
	// }


    // Стандартный экшн из Gii
    // public function actionCreate()
    // {
    //     $model = new PdWorkProcess();

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }


    public function actionCreate()
    {
        // Запрашиваем модель UploadFormProcess
         $model2 = new UploadFormProcess;


        // $pdwork_id = Yii::$app->request->post('pd_work');
        $request = Yii::$app->request;
        $pdwork_id = $request->get('pd_work');


        // Добавляем стадию для проектной документации только если указан айдишник этой документации в GET-запросе
        if ($pdwork_id) {

            $searchModel = new SearchPdWorkProcess();
            $dataProvider = $searchModel->search($request->queryParams);

            $dataProvider->query
                ->andWhere(['pd_work' => $pdwork_id])
                ->orderBy(['report_date' => SORT_DESC, 'timestamp' => SORT_DESC]);



            $model = new PdWorkProcess();

            // После кнопки сохранить получаем данные из $model(сразу сохраняем) и $model2
            if ($model->load(Yii::$app->request->post()) && $model2->load(Yii::$app->request->post())) {

                if (!(PdWorkProcess::find()->where(['=','pd_work',$model['pd_work']])->one())){
                    $pdwork = PdWork::findOne($model["pd_work"]);
                    $pdwork->work_datastart = $model["report_date"];
                    $pdwork->no_report = 0;
                    $pdwork->save();
                }

                $model->save();

                // Если pd_step = 5, то ищем запись в PDWORK и меняем значение completed на 1 и fact_datefinish на дату(сегодня)
                if ( $model->pd_step == 5){
                    $pdwork = PdWork::findOne($model["pd_work"]);
                    $pdwork->completed = '1';
                    $pdwork->fact_datefinish = date('Y-m-d');
                    $pdwork->save();
                }

                // pdProcess загруженный в форме фаил
                if (UploadedFile::getInstance($model2, 'pdProcess')){

                    // Узнаем id сохранившейся записи
                    $idprocess = $model->id;
                    // Путь до файла
                    $uploaddir = './docs/pd/'.Yii::$app->request->post('UploadFormProcess')['pd_work'] .'/';

                    $model2->pdProcess = UploadedFile::getInstance($model2, 'pdProcess');
                    $filename = $model2->upload($uploaddir , $idprocess);
                }


                $this->refresh();
            }
   

            $model->pd_work = $pdwork_id;
            $model->person_responsible = Yii::$app->user->identity->id;

            // Данные для размещения в заголовке страницы - какой ПД принадлежит стадия
            $pdwork = PdWork::find()->where(['id'=>$pdwork_id])->one();
            $pdwork->pdworktype = PdWorkType::find()->where(['id' => $pdwork->work_name])->one();
            $pdwork->branchname = Branch::find()->where(['branch_id' => $pdwork->branch])->one();
            $pdwork->docName = BasedocType::find()->where(['id' => $pdwork->basedoc_type])->one();

            // return $this->render('create', [
            //     'model' => $model,
            //     'pdwork' => $pdwork,
            // ]);

            return $this->render('create', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'pdwork' => $pdwork,
                'model2' => $model2,
            ]);
        }

        // Если в GET-запросе нет параметра pd_work переводим на страницу со списком работ
        return $this->redirect(['/pd/pd-work']);

    }


    /**
     * Updates an existing PdWorkProcess model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */




    public function actionUpdate($id)
    {
        $model2 = new UploadFormProcess;
        $request = Yii::$app->request;
        $pdwork_id = $request->get('pd_work');


        $searchModel = new SearchPdWorkProcess();
        $dataProvider = $searchModel->search($request->queryParams);

        $dataProvider->query
            ->andWhere(['pd_work' => $pdwork_id])
            ->orderBy(['report_date' => SORT_DESC, 'timestamp' => SORT_DESC]);


        $model = $this->findModel($id);

        //Смотреть actionCreate
        if ($model->load(Yii::$app->request->post())  && $model->save() && $model2->load(Yii::$app->request->post())) {

            if ( $model->pd_step == 5){
                $pdwork = PdWork::findOne($model["pd_work"]);
                $pdwork->completed = '1';
                $pdwork->fact_datefinish = date('Y-m-d');
                $pdwork->save();
            }
            $idprocess = $model->id;

            $uploaddir = './docs/pd/'.Yii::$app->request->post('UploadFormProcess')['pd_work'] .'/';
            $model2->pdProcess = UploadedFile::getInstance($model2, 'pdProcess');
            $filename = $model2->upload($uploaddir , $idprocess);

            $this->refresh();
            // return $this->redirect(['view', 'id' => $model->id], 'pd_work' => $pdwork_id);
            return $this->redirect(['create', 'pd_work' => $pdwork_id]);
        }

        
        // Добавляем стадию для проектной документации только если указан айдишник этой документации в GET-запросе
        if ($pdwork_id) {
   
            // $model->pd_work = $pdwork_id;
            // $model->person_responsible = Yii::$app->user->identity->id;

            // Данные для размещения в заголовке страницы - какой ПД принадлежит стадия
            $pdwork = PdWork::find()->where(['id'=>$pdwork_id])->one();
            $pdwork->pdworktype = PdWorkType::find()->where(['id' => $pdwork->work_name])->one();
            $pdwork->branchname = Branch::find()->where(['branch_id' => $pdwork->branch])->one();
            $pdwork->docName = BasedocType::find()->where(['id' => $pdwork->basedoc_type])->one();

            return $this->render('create', [
                'model2' => $model2,
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'pdwork' => $pdwork,
            ]);
        }

        // Если в GET-запросе нет параметра pd_work переводим на страницу со списком работ
        return $this->redirect(['/pd/pd-work']);

    }

    /**
     * Deletes an existing PdWorkProcess model.
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
     * Finds the PdWorkProcess model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PdWorkProcess the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdWorkProcess::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
