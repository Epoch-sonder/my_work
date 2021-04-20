<?php

namespace app\controllers;

use Yii;
use app\models\NsiContent;
use app\models\SearchNsiContent;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NsiContentController implements the CRUD actions for NsiContent model.
 */
class NsiContentController extends Controller
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
     * Lists all NsiContent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchNsiContent();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $file = file_get_contents('/var/www/cluster/web/docs/nsi/10200003.000');
        //echo $file;
        // echo '<pre>';
        // var_dump($file);
        // echo '</pre>';


        $lines = explode("\n", $file);

        // echo '<pre>';
        // var_dump($lines);
        // echo '</pre>';

        foreach ($lines as $line) {
            //$notspace = trim($line);
            $sokr = substr($line, 0, 5);
            $ost = substr($line, 5);
            // //echo '<pre>'.$ost.'</pre>';
            $notspace = trim($ost);
            // //echo '<pre>'.$notspace.'</pre>';
            // $trimmed = trim($notspace, "�");
            // //echo '<pre>'.$trimmed.'</pre>';
            $cod1 = substr($notspace, 0, 7);
            $class1 = substr($notspace, 7, 6);
            $name1 = substr($notspace, 13);
            //echo '<br>';
            echo '<pre>'.$sokr.'</pre>';
            //echo '<br>';
            echo '<pre>'.$cod1.'</pre>';
            //echo '<br>';
            echo '<pre>'.$class1.'</pre>';
            //echo '<br>';
            echo '<pre>'.$name1.'</pre>';
        }

       

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single NsiContent model.
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
     * Creates a new NsiContent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new NsiContent();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing NsiContent model.
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
     * Deletes an existing NsiContent model.
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
     * Finds the NsiContent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NsiContent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = NsiContent::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
