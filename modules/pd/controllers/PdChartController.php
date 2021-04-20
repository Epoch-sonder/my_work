<?php

namespace app\modules\pd\controllers;

use app\models\CaCurator;
use app\modules\pd\models\User;
use Yii;
use app\modules\pd\models\PdWork;

use app\modules\audit\models\FederalDistrict;
use app\modules\pd\models\Branch;
use app\modules\pd\models\ResponsibilityArea;
use app\modules\pd\models\SearchPdWork;
use app\modules\pd\models\PdWorktype;
use app\modules\pd\models\FederalSubject;
use app\modules\pd\models\Forestry;
use app\modules\pd\models\BranchEmulator;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;


/**
 * PdWorkController implements the CRUD actions for PdWork model.
 */
class PdChartController extends Controller
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
     * Lists all PdWork models.
     * @return mixed
     */
    public function actionIndex($completed = 0)
    {
        $searchModel = new SearchPdWork();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $branches = Branch::find()->select(['branch_id', 'name'])->orderBy(['branch_id' => SORT_ASC])->orderBy(['name' => SORT_ASC])->all(); 

        //$branches = Branch::find()->select(['branch_id', 'name'])->orderBy(['branch_id' => SORT_ASC])->orderBy(['name' => SORT_ASC])->all(); 




       
        // Определяем филиал принадлежности текущего пользователя
        $branchID = Yii::$app->user->identity->branch_id;

            // Эмулируем работу от имени филиала (для ограничения зоны видимости)
            $branchEmul_model = new BranchEmulator();

            if ($branchEmul_model->load(\Yii::$app->request->post())) {
                $branchEmul = $branchEmul_model->branchEmul;
                // Сохраняем номер эмулируемого филиала в сессии
                \Yii::$app->session['branchEmul'] = $branchEmul;
            }
            elseif (Yii::$app->session['branchEmul']) {
                $branchEmul = Yii::$app->session['branchEmul'];
                $branchEmul_model->branchEmul = $branchEmul;
            }
            else {
                $branchEmul = $branchID;
                $branchEmul_model->branchEmul = $branchID;
                // Сохраняем номер эмулируемого филиала в сессии
                \Yii::$app->session['branchEmul'] = $branchEmul;
            }


         
        // Для пользователей не из ЦА выводим только отчеты их филиала
        // if($branchID != 0) $dataProvider->query->andWhere("pd_work.branch = $branchID");
        if($branchEmul != 0 ) {
            $condBranch = 'pd_work.branch = '.$branchEmul;
            $dataProvider->query->andWhere("pd_work.branch = $branchEmul");
        }
        else $condBranch = '';



        if( Yii::$app->request->get('onlymy') == '1'){
            $userID = Yii::$app->user->identity->id;
            if ($userID == 79 or $userID == 15 or $userID==131){
                $branchsFio = CaCurator::find()->where("person_kod = $userID")->select('branch_kod')->asArray()->all();
                foreach ($branchsFio as $branchFio) $params[] = $branchFio["branch_kod"];
                $dataProvider->query->andWhere(['in', 'pd_work.branch', $params]);
            }
        }

        $dataProvider->query->andWhere("pd_work.completed = $completed");



        $ttl_pd = $ttl_lp = $ttl_lhr = $ttl_pol = $ttl_other = $lhr_contracts = 0;
        if(!$completed) {
            // SELECT work_name, SUM(IF(forestry_quantity = 0 or forestry_quantity is NULL, 1, forestry_quantity)) forestry_quantity, COUNT(id) row_quantity FROM pd_work GROUP BY work_name 
            
            // Количество документов в работе:
            $pdwork_active = PdWork::find()
                ->select(['work_type' =>'work_name', 'forestry_qnty' => 'SUM(IF(forestry_quantity = 0 or forestry_quantity is NULL, 1, forestry_quantity))', 'row_qnty' => 'COUNT(*)' ])
                ->groupBy('work_name')
                ->where($condBranch)
                ->andWhere("completed = 0")
                ->all();
            
            
            foreach ($pdwork_active as $pdwork) {
                if ($pdwork->work_type == 1) $ttl_lp = $pdwork->row_qnty; // лесных планов
                elseif ($pdwork->work_type == 2) {
                    $ttl_lhr = $pdwork->forestry_qnty; // ЛХР, учитываем кол-во лесничеств
                    $lhr_contracts = $pdwork->row_qnty; // ЛХР, количество контрактов
                }
                elseif ($pdwork->work_type == 4) $ttl_pol = $pdwork->forestry_qnty; // ПОЛ, учитываем кол-во лесничеств
                elseif ($pdwork->work_type == 13 || $pdwork->work_type == 14) $ttl_other += $pdwork->row_qnty; // учитываем кол-во договоров
                else $ttl_other += $pdwork->forestry_qnty; //учитываем кол-во лесничеств
            }
            $ttl_pd = $ttl_lp + $ttl_lhr + $ttl_pol + $ttl_other; // всего
        }

       

        // Определяем текущий год
        $dataChange = date_default_timezone_get();
        $dataChange = date("Y", strtotime($dataChange . ""));

        // Завершенные работы за указанный год, если не указано - за текущий
        if ( ($dateComp = Yii::$app->request->get('request_date')) && $completed )
            $dateComp = ['and' , ['>=' , 'fact_datefinish', "$dateComp-01-01"] , ['<=','fact_datefinish', "$dateComp-12-31"]];
        else
            $dateComp =  ['and' , [">=", "fact_datefinish", "$dataChange-01-01"], ['<=','fact_datefinish', "$dataChange-12-31"]];
        
        // Запрос завершенных работ за год
        $pdwork_closed = PdWork::find()
            ->select(['work_type' =>'work_name', 'forestry_qnty' => 'SUM(IF(forestry_quantity = 0 or forestry_quantity is NULL, 1, forestry_quantity))', 'row_qnty' => 'COUNT(*)' ])
            ->groupBy('work_name')
            ->where($condBranch)
            ->andWhere("completed = 1")
            ->andWhere($dateComp)
            ->all();

        // Количество документов, закрытых в текущем году:
        $ttlc_lp = $ttlc_lhr = $ttlc_pol = $ttlc_other = $lhrc_contracts = 0;
        foreach ($pdwork_closed as $pdwork) {
            if ($pdwork->work_type == 1) $ttlc_lp = $pdwork->row_qnty; // лесных планов
            elseif ($pdwork->work_type == 2) {
                $ttlc_lhr = $pdwork->forestry_qnty; // ЛХР, учитываем кол-во лесничеств
                $lhrc_contracts = $pdwork->row_qnty; // ЛХР, количество контрактов
            }
            elseif ($pdwork->work_type == 4) $ttlc_pol = $pdwork->forestry_qnty; // ПОЛ, учитываем кол-во лесничеств
            elseif ($pdwork->work_type == 13 || $pdwork->work_type == 14) $ttlc_other += $pdwork->row_qnty; // учитываем кол-во договоров
            else $ttlc_other += $pdwork->forestry_qnty; //учитываем кол-во лесничеств
        }
        $ttlc_pd = $ttlc_lp + $ttlc_lhr + $ttlc_pol + $ttlc_other; // всего


//цикл по филиалам
        foreach ($branches as $branch){
            $branchName = $branch->name; //название филиала
            $brID = $branch->branch_id;

            if ($brID != 0){

//подсчет документации в работе для каждого филиала
                $pdwork_active = PdWork::find()->select(['work_type' =>'work_name', 'forestry_qnty' => 'SUM(IF(forestry_quantity = 0 or forestry_quantity is NULL, 1, forestry_quantity))', 'row_qnty' => 'COUNT(*)' ])->groupBy('work_name')->where("branch = $brID")->andWhere("completed = 0")->all();

                $brw_lp = $brw_lhr = $brw_pol = $brw_other = 0;

                foreach ($pdwork_active as $pdwork) {
                    if ($pdwork->work_type == 1) $brw_lp = $pdwork->row_qnty; // лесных планов
                            elseif ($pdwork->work_type == 2) {
                        $brw_lhr = $pdwork->forestry_qnty; // ЛХР, учитываем кол-во лесничеств
                    }
                    elseif ($pdwork->work_type == 4) $brw_pol = $pdwork->forestry_qnty; // ПОЛ, учитываем кол-во лесничеств
                    elseif ($pdwork->work_type == 13 || $pdwork->work_type == 14) $brw_other += $pdwork->row_qnty; // учитываем кол-во договоров
                    else $brw_other += $pdwork->forestry_qnty; //учитываем кол-во лесничеств*/
                }

                $brw_pd = $brw_lp + $brw_lhr + $brw_pol + $brw_other; // всего
                                                        
//подсчет завершенной документации для каждого филиала
                $pdwork_closed = PdWork::find()->select(['work_type' =>'work_name', 'forestry_qnty' => 'SUM(IF(forestry_quantity = 0 or forestry_quantity is NULL, 1, forestry_quantity))', 'row_qnty' => 'COUNT(*)' ])->groupBy('work_name')->where("branch = $brID")->andWhere("completed = 1")->andWhere($dateComp)->all();

                $brc_lp = $brc_lhr = $brc_pol = $brc_other = $brc_contracts = 0;

                foreach ($pdwork_closed as $pdwork) {
                    if ($pdwork->work_type == 1) $brc_lp = $pdwork->row_qnty; // лесных планов
                        elseif ($pdwork->work_type == 2) {
                            $brc_lhr = $pdwork->forestry_qnty; // ЛХР, учитываем кол-во лесничеств
                            $brс_contracts = $pdwork->row_qnty; // ЛХР, количество контрактов
                        }
                        elseif ($pdwork->work_type == 4) $brc_pol = $pdwork->forestry_qnty; // ПОЛ, учитываем кол-во лесничеств
                        elseif ($pdwork->work_type == 13 || $pdwork->work_type == 14) $brc_other += $pdwork->row_qnty; // учитываем кол-во договоров
                        else $brc_other += $pdwork->forestry_qnty; //учитываем кол-во лесничеств
                }

                $brc_pd = $brc_lp + $brc_lhr + $brc_pol + $brc_other; // всего
                                              
                $name[] = $branchName;
                $docc[] = $brc_pd;
                $docw[] = $brw_pd;

                //$notec[] = [$branchName, $brc_pd]; 
                //$note[] = [$branchName, $brw_pd];
            }
        }

        // echo '<pre>';
        // var_dump ($notec);
        // echo '</pre>';

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'completed' => $completed,
            'branchEmul_model' => $branchEmul_model,
            'ttl_pd' => $ttl_pd,
            'ttl_lp' => $ttl_lp,
            'ttl_lhr' => $ttl_lhr,
            'ttl_pol' => $ttl_pol,
            'ttl_other' => $ttl_other,
            'ttlc_pd' => $ttlc_pd,
            'ttlc_lp' => $ttlc_lp,
            'ttlc_lhr' => $ttlc_lhr,
            'ttlc_pol' => $ttlc_pol,
            'ttlc_other' => $ttlc_other,
            'lhr_contracts' => $lhr_contracts,
            'lhrc_contracts' => $lhrc_contracts,
            'name' => $name,
            'docc' => $docc,
            'docw' => $docw,
        ]);
    }


    /**
     * Displays a single PdWork model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
 
}
