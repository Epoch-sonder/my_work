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
use yii\base\BaseObject;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;


/**
 * PdWorkController implements the CRUD actions for PdWork model.
 */
class PdWorkController extends Controller
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
        ]);
    }


    /**
     * Displays a single PdWork model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
            // Запрос для получения данных типа ПД 
            // $pdworktype = PdWorktype::find()->where(['id'=>$id])->one();

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdWork model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id = null)
    {
        //$id_curators берем колонку 'person_kod' из масива и удаляем повторы
        $curators_branch = CaCurator::find()->select(['person_kod', 'branch_kod'])->asArray()->all();
        $id_curators = array_column($curators_branch, 'person_kod');
        $id_curators = array_unique($id_curators);
        $users_name = User::find()->select(['id','fio'])->asArray()->where(['in', 'id', $id_curators])->all();

        foreach ($curators_branch as $curator_branch){
            $id_branch_curators[$curator_branch['branch_kod']] = (int)$curator_branch['person_kod'];
        }
        foreach ($users_name as $user_name){
            $id_userCur[$user_name['id']] = $user_name['fio'];
        }

        $model = new PdWork();

        if (isset($id)) {
            $model->attributes = $this->findModel($id)->attributes;
            $model->id = null;
        }

        if ($model->load(Yii::$app->request->post())) {
            $dataDefold = date_default_timezone_get();
            $dataDefold = date("Y-m-d", strtotime($dataDefold . ""));
            $model->date_create = $dataDefold;
            if ($model->work_datastart == " ") $model->work_datastart = '2000-01-01';
            $model->save();
            // return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(['index']);
        }

//          Для многомерного масива функция array_unique
//        $first_names = array_map("unserialize", array_unique(array_map("serialize", $first_names)));



        return $this->render('create', [
            'model' => $model,
            'id_userCur'=>$id_userCur,
            'id_branch_curators'=>$id_branch_curators,
        ]);

    }

    /**
     * Updates an existing PdWork model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        //$id_curators берем колонку 'person_kod' из масива и удаляем повторы
        $curators_branch = CaCurator::find()->select(['person_kod', 'branch_kod'])->asArray()->all();
        $id_curators = array_column($curators_branch, 'person_kod');
        $id_curators = array_unique($id_curators);
        $users_name = User::find()->select(['id','fio'])->asArray()->where(['in', 'id', $id_curators])->all();

        foreach ($curators_branch as $curator_branch){
            $id_branch_curators[$curator_branch['branch_kod']] = (int)$curator_branch['person_kod'];
        }
        foreach ($users_name as $user_name){
            $id_userCur[$user_name['id']] = $user_name['fio'];
        }




        $model = $this->findModel($id);


        if ($model->load(Yii::$app->request->post())) {
            // return $this->redirect(['view', 'id' => $model->id]);
            // return $this->redirect(['index']);
            if ($model->completed and !$model->fact_datefinish) {
                $dateDefold = new \DateTime(date_default_timezone_get());
                $dateDefold = $dateDefold->format('Y-m-d');
                $model->fact_datefinish = $dateDefold;
            }
            $model->save();
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'id_userCur'=>$id_userCur,
            'id_branch_curators'=>$id_branch_curators,
        ]);
    }

    /**
     * Deletes an existing PdWork model.
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




    public function actionAmountDocs()
    {
        $fs = FederalSubject::find()->all();

        // Количество лесных планов
        $pdwork_docs = PdWork::find()->select('federal_subject')->all();

        if($pdwork_docs) {
            foreach ($pdwork_docs as $d){
               $s = $d->federal_subject;
               if (isset($amountdocs[$s])) $amountdocs[$s] += 1;
               else $amountdocs[$s] = 1;
            }
        }


        return $this->render('amountdocs', [
            'amountdocs' => $amountdocs,
            'fs' => $fs,
        ]);
    }



    /**
     * Finds the PdWork model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PdWork the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdWork::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



    // Актуализируем список лесничеств
    // в зависимости от выбранного субъекта
    public function actionActualizeForestryList()
    {
        //  Если получаем данные через запрос Ajax
        if(\Yii::$app->request->isAjax) {

            $cur_subject = Yii::$app->request->post('cur_subject');
            $selected_forestries = Yii::$app->request->post('selected_forestries');

            // Перечень выбранных ранее лесничеств в массив
            $selected_frtrs = explode(' ', trim($selected_forestries));


            // Если передан айди субъекта и категории земель
            if( $cur_subject ) {

                $forestries = forestry::find()
                    ->where("subject_kod = $cur_subject")
                    ->andWhere(['removed' => null]) // отображаем только неликвидированные
                    // ->andWhere(['not', ['removed' => null]])
                    ->orderBy(['forestry_name' => SORT_ASC])
                    ->all();

                // Формируем список чекбоксов лесничеств
                if (count($forestries) > 0) { // если есть записи по запросу
                    foreach ($forestries as $forestry) {

                        // echo '<label><input class="form-check-input" type="checkbox"';
                        echo '<input type="checkbox"';

                        // Перебираем массив отмеченных лесничеств
                        // Если было выбрано - омечаем чекбокс
                        foreach ($selected_frtrs as $selected_frtr) {
                            if ($forestry->forestry_kod == $selected_frtr) echo ' checked="checked"';
                        }
                        
                        echo ' value="'.$forestry->forestry_kod.'"> '.$forestry->forestry_name.'<br>';

                    }

                    echo '<br>';
                }
            }
        }

        // Если получили запрос к экшену не через аякс
        // return $this->redirect(['/pd/pd-work']);
    }



    /** Инструкция по заполнению и отправке отчета по ПОЛ **/
    public function actionInstructionPd()
    {
        return $this->render('instructionpd');
    }



    public function actionInstructionPdPdf()
    {
        $content = $this->renderPartial('instructionpd');

        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'format' => Pdf::FORMAT_A4, 
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            'destination' => Pdf::DEST_BROWSER, 
            'filename' => 'Инструкция_ПД.pdf',
            'content' => $content,  
            // 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => '.pdf_but {display: none}
                            p, li {font-family: serif; font-size12px; line-height: 1.3}
                            .forest-work-index {padding-right: 0}
            ', 
            'options' => ['title' => 'Инструкция по предоставлению отчетов о ходе выполнения работ'],
            'methods' => [ 
                'SetHeader'=>['Инструкция по предоставлению отчетов о ходе выполнения работ'], 
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);
        
        return $pdf->render();
    }


    public function actionSummaryDistrict()
    {
    	//обращаемся к переменным из базы данных
        //Если дата изначально не указана, то берет год сегодняшнего дня
        $dataDefold = date_default_timezone_get();
        $dataDefold = date("Y", strtotime($dataDefold . ""));

        if(Yii::$app->request->get('request_date') == null){
            $dataChange = date_default_timezone_get();
            $dataChange = date("Y", strtotime($dataChange . ""));
        }
        elseif (Yii::$app->request->get('request_date') > $dataDefold){
            $dataChange = $dataDefold;
        }
        else{
            $dataChange = Yii::$app->request->get('request_date');
        }
        $subjects = FederalSubject::find()->orderBy(['federal_district_id' => SORT_ASC])->all();
        $pdworks = PdWork::find()
            ->where(['or',
                ['and' , ['<=' , 'basedoc_datasign', $dataChange.'-12-31'] , ['>=','basedoc_datefinish', $dataChange.'-01-01']],
                ['and' , ['<=' , 'basedoc_datasign',  $dataChange.'-12-31'] , ['=','basedoc_datefinish', '2000-01-01']]
            ])
            ->all();
        $branchs = Branch::find()->where(['not in', 'branch_id', '0'])->all();
        $areas = ResponsibilityArea::find()->all();
        $districts = FederalDistrict::find()->orderBy(['name' => SORT_ASC])->all();
        //
        foreach ($subjects as $subject){

            $fo = $subject->federal_district_id; // $fo - Федеральный округ
            $fs = $subject->federal_subject_id; //$fs - Федеральный субъект
            $fsname = $subject->name; // заносим имя субъекта в переменную







            //условие если массив $summaryFo[Федеральный округ][Федеральный субъект] не пустой, и в случае выполнения задаём начальные значения переменным
            if( !isset($summaryFo[$fo][$fs])) {
                $summaryFo[$fo][$fs]['namesub'] = $fsname; //субъект
                $summaryFo[$fo][$fs]['summary'] = 0; //общее число всей проектной документации по субъекту
                $summaryFo[$fo][$fs]['work'] = 0; //общее число проектной документации в работе по субъекту
                $summaryFo[$fo][$fs]['completed'] = 0; //общее число законченной проектной документации по субъекту
                $summaryFo[$fo][$fs]['forest_plans'] = 0; //общее число лесных планов по субъекту
                $summaryFo[$fo][$fs]['forestry_regulations'] = 0; //общее число лесохозяйтсвенных регламентов по субъекту
                $summaryFo[$fo][$fs]['forestry_regulations_all'] = 0; //общее число лесохозяйтсвенных регламентов по субъекту
                $summaryFo[$fo][$fs]['forest_projects'] = 0; //общее число проектов освоения лесов по субъекту
                $summaryFo[$fo][$fs]['other_documentation'] = 0; //общее число иной документации по субъекту
            }

        }
        //цикл по всей документации (базе с филиалами, субъктами и документами)
        foreach ($pdworks as $pdwork){
            for ($i=1;$i<9;$i++){
                $pdSub = $pdwork->federal_subject;  //обращение к id субъектов
                $Completed = $pdwork->completed; //обращение к условию завершено или нет
                $branchId = $pdwork->branch; //обращение к id филиала

                //цикл по филиалам
                foreach ($branchs as $branch){
                    if ($branchId == $branch["branch_id"] )  //проверка совпадают ли id филиалов
                        $branchName = $branch->name; //в таком случае в переменную branchName записываем название филиала
                }

                if ($Completed == 1 and isset($summaryFo["$i"]["$pdSub"])){  //проверка условия завершена ли работа или нет
                    if(isset( $summaryFo[$i][$pdSub]['summary']))  $summaryFo[$i][$pdSub]['summary'] += 1; //если работа завершена, считаем общее число документации по субъекту
                    else   $summaryFo[$i][$pdSub]['summary'] = 1 ; 
                    if(isset( $summaryFo[$i][$pdSub]['completed']))  $summaryFo[$i][$pdSub]['completed'] += 1; //и общее число завершенной документации по субъекту
                    else   $summaryFo[$i][$pdSub]['completed'] = 1 ;

                }
                elseif ($Completed != 1 and isset($summaryFo["$i"]["$pdSub"])){
                    if(isset( $summaryFo[$i][$pdSub]['summary']))  $summaryFo[$i][$pdSub]['summary'] += 1; //в ином случае, считаем общее число документации по субъекту
                    else   $summaryFo[$i][$pdSub]['summary'] = 1 ;
                    if(isset( $summaryFo[$i][$pdSub]['work']))  $summaryFo[$i][$pdSub]['work'] += 1; //и документации в работе по субъекту
                    else   $summaryFo[$i][$pdSub]['work'] = 1 ;

                }
                if (isset($summaryFo["$i"]["$pdSub"]) ){
                    $summaryFo["$i"]["$pdSub"]['actual_branch']["$branchId"] = $branchName; //записывается название филиала в массив
                }

                if ($pdwork['work_name'] == 1){
                    if(isset( $summaryFo[$i][$pdSub]['forest_plans']))  $summaryFo[$i][$pdSub]['forest_plans'] += 1; //подсчет лесных планов по субъекту
                    else $summaryFo[$i][$pdSub]['forest_plans'] = 1;
                }
                elseif ($pdwork['work_name'] == 2){
                    if(isset( $summaryFo[$i][$pdSub]['forestry_regulations']))  {
                        $summaryFo[$i][$pdSub]['forestry_regulations_all'] += $pdwork->forestry_quantity;
                        $summaryFo[$i][$pdSub]['forestry_regulations'] += 1; //подсчет лесохоз. регламентов по субъекту
                    }
                    else {
                        $summaryFo[$i][$pdSub]['forestry_regulations_all'] = $pdwork->forestry_quantity;
                        $summaryFo[$i][$pdSub]['forestry_regulations'] = 1;
                    }

                }
                elseif ($pdwork['work_name'] == 4){
                    if(isset( $summaryFo[$i][$pdSub]['forest_projects']))  $summaryFo[$i][$pdSub]['forest_projects'] += 1; //подсчет проектов освоения лесов по субъекту
                    else $summaryFo[$i][$pdSub]['forest_projects'] = 1;

                }
                elseif($pdwork['work_name'] != 4 and $pdwork['work_name'] != 2 and $pdwork['work_name'] != 1) {
                    if(isset( $summaryFo[$i][$pdSub]['other_documentation']))  $summaryFo[$i][$pdSub]['other_documentation'] += 1; //подсчет иной документации по субъекту
                    else $summaryFo[$i][$pdSub]['other_documentation'] = 1;
                }

            }

        }

        //цикл по зонам ответсвенности 
        foreach ($areas as $area){
            for ($i=1;$i<9;$i++){
                $areaSub = $area->federal_subject_id; 
                $order = $area->with_order; //по приказу или нет 

                foreach ($branchs as $branch){
                    if ($area['branch_id'] == $branch['branch_id']){
                        $nameBranch = $branch['name'];
                    }
                }

//                $summaryFo[$i][$areaSub]['actual_branch'] = $nameBranch ;
                //условие проверки по приказу или нет принадлежит субъект зоне ответсвенности 
                if ($order == 1 and isset($summaryFo["$i"]["$areaSub"])){
                    $summaryFo[$i][$areaSub]['area_responsibility'] = $nameBranch ; //если да, то ей присваевается наименование филиала 
                }

            }
        }





        $total_work = 0; //общее число проектной документации в работе по ФО
        $total_completed = 0; //общее число проектной документации по ФО
        $total_sum = 0; //общее число проектной документации по ФО
        $ttl_fp_sum = 0; //общее число лесных планов по ФО
        $ttl_fr_sum = 0; //общее число лесохозяйственных регламентов по ФО
        $ttl_fpr_sum = 0; //общее число проектов освоения лесов по ФО
        $ttl_od_sum = 0; //общее число иной документации по ФО 
        $sumWorkFo =0 ; //общее число проектной документации в работе всего
        $sumCompFo = 0; //общее число число проектной документации всего
        $sumAllFo = 0; //общее число проектной документации всего
        $sumWorkFp = 0; //общее число лесных планов всего
        $sumWorkod = 0; //общее число лесохозяйственных регламентов всего
        $sumWorkFpr = 0; //общее число проектов освоения лесов всего
        $sumWorkFr = 0; //общее число иной документации всего

        return $this->render('summarydistrict', [
            'dataChange'=>$dataChange,
            'summaryFo'=>$summaryFo,
            'districts'=>$districts,
            'subjects'=>$subjects,
            'branchs'=>$branchs,
            'sumWorkFo' => $sumWorkFo,
            'sumCompFo' => $sumCompFo,
            'sumAllFo' => $sumAllFo,
            'sumWorkFp' => $sumWorkFp,
            'sumWorkod' => $sumWorkod,
            'sumWorkFpr' => $sumWorkFpr,
            'sumWorkFr' => $sumWorkFr,
            'total_work'=>$total_work,
            'total_completed'=>$total_completed,
            'total_sum'=>$total_sum,
            'ttl_fp_sum'=>$ttl_fp_sum,
            'ttl_fr_sum'=>$ttl_fr_sum,
            'ttl_fpr_sum'=>$ttl_fpr_sum,
            'ttl_od_sum'=>$ttl_od_sum,
        ]);

    }

    public function actionSummaryBranch()
    {
        $sumBranch = array();

        //Если дата изначально не указана, то берет год сегодняшнего дня
        $dataDefold = date_default_timezone_get();
        $dataDefold = date("Y", strtotime($dataDefold . ""));

        if(Yii::$app->request->get('request_date') == null){
            $dataChange = date_default_timezone_get();
            $dataChange = date("Y", strtotime($dataChange . ""));
        }
        elseif (Yii::$app->request->get('request_date') > $dataDefold){
            $dataChange = $dataDefold;
        }
        else{
            $dataChange = Yii::$app->request->get('request_date');
        }
        $subjects = FederalSubject::find()->all();
        $pdworks = PdWork::find()
            ->where(['or',
                ['and' , ['<=' , 'basedoc_datasign', $dataChange.'-12-31'] , ['>=','basedoc_datefinish', $dataChange.'-01-01']],
                ['and' , ['<=' , 'basedoc_datasign',  $dataChange.'-12-31'] , ['=','basedoc_datefinish', '2000-01-01']]
            ])
            ->all();
        $branchs = Branch::find()->where(['not in', 'branch_id', '0'])->orderBy(['name' => SORT_ASC])->all(); //сортировка филиалов по алфавиту
        $areas = ResponsibilityArea::find()->all();
        $districts = FederalDistrict::find()->all();

        //обращение к базе с документами
        foreach ($pdworks as $pdwork) {

            $pdSub = $pdwork->federal_subject;  //обращение к id субъектов
            $completed = $pdwork->completed; //обращение к условию завершено или нет
            $branchId = $pdwork->branch; //обращение к id филиала

            //цикл по субъектам
            foreach ($subjects as $subject){
                $subName=$subject->name; //название субъекта
                $fo = $subject->federal_district_id; //id федерального округа
                if($subject->federal_subject_id == $pdSub){
                    $sumBranch[$branchId][$pdSub]['name']=$subName; //название филиала 
                    foreach ($districts as $district) {
                        if ($fo == $district['federal_district_id']){
                            $foName = $district->name; 
                            $sumBranch[$branchId][$pdSub]['Fo'] = $foName; //название федерального округа 
                        }
                    }
                    //$sumBranch[$branchId][$pdSub]['Fo'] = $foName;
                }


            }

            //цикл по зонам ответственности
            foreach($areas as $area){
                if($area->with_order == 1 and $area->federal_subject_id ==$pdSub){  //проверка условия по приказу или нет
                    foreach ($branchs as $branch){ 
                        if ($area->branch_id == $branch['branch_id']){
                            $sumBranch[$branchId][$pdSub]['area_resp'] = $branch->name; //название зоны ответственности
                        }
                    }

                }
            }


            //обращение к базе данных PdWork
            //узнаем каким документом является
            if ($pdwork['work_name'] == 1){ //если 1 - лесной план
                if (!isset($sumBranch[$branchId][$pdSub]['forest_plans'])) $sumBranch[$branchId][$pdSub]['forest_plans'] = 1; 
                else $sumBranch[$branchId][$pdSub]['forest_plans'] += 1; //считаем число лесных планов по субъекту
            }
            elseif ($pdwork['work_name'] == 2){ //если 2 - лесхоз. регламент
                if (!isset($sumBranch[$branchId][$pdSub]['forestry_regulations'])) {
                    $sumBranch[$branchId][$pdSub]['forestry_regulations_all'] = $pdwork->forestry_quantity;
                    $sumBranch[$branchId][$pdSub]['forestry_regulations'] = 1; //подсчет лесохоз. регламентов по субъекту
                }
                else {
                    $sumBranch[$branchId][$pdSub]['forestry_regulations_all'] += $pdwork->forestry_quantity;
                    $sumBranch[$branchId][$pdSub]['forestry_regulations'] += 1;
                }
            }
            elseif ($pdwork['work_name'] == 4){ //если 4 - проект освоения лесов
                if (!isset($sumBranch[$branchId][$pdSub]['forest_projects'])) $sumBranch[$branchId][$pdSub]['forest_projects'] = 1; 
                else $sumBranch[$branchId][$pdSub]['forest_projects'] += 1; //считаем число проектов освоения лесов по субъекту
            }
            elseif($pdwork['work_name'] != 4 and $pdwork['work_name'] != 2 and $pdwork['work_name'] != 1) { //в остальных случаях - иная документация 
                if (!isset($sumBranch[$branchId][$pdSub]['other_documentation'])) $sumBranch[$branchId][$pdSub]['other_documentation'] = 1;
                else $sumBranch[$branchId][$pdSub]['other_documentation'] += 1; //считаем иную документацию по субъекту
            }
            if ($completed == 1){ //условие завершение работы проектной документации
                if (!isset($sumBranch[$branchId][$pdSub]['summary'])) $sumBranch[$branchId][$pdSub]['summary'] =1; 
                else $sumBranch[$branchId][$pdSub]['summary'] += 1; //если завершенна считаем общее число документации по субъекту

                if (!isset($sumBranch[$branchId][$pdSub]['completed'])) $sumBranch[$branchId][$pdSub]['completed'] =1;
                else $sumBranch[$branchId][$pdSub]['completed'] += 1; //и завершенную документацию по субъекту 
            }
            elseif($completed == 0){ //в ином случае
                if (!isset($sumBranch[$branchId][$pdSub]['summary'])) $sumBranch[$branchId][$pdSub]['summary'] =1; 
                else $sumBranch[$branchId][$pdSub]['summary'] += 1; //считаем общее число документации по субъекту
                if (!isset($sumBranch[$branchId][$pdSub]['work'])) $sumBranch[$branchId][$pdSub]['work'] =1;
                else $sumBranch[$branchId][$pdSub]['work'] += 1; //и документацию в работе по субъекту
            }


        }








        //var_dump($subName);





        $total_work = 0; //общее число проектной документации в работе по филиалу
        $total_completed = 0; //общее число завершенной проектной документации по филиалу
        $total_sum = 0; //общее число проектной документации по филиалу
        $ttl_fp_sum = 0; //общее число лесных планов по филиалу
        $ttl_fr_sum = 0; //общее число лесхоз. регламентов по филиалу
        $ttl_fpr_sum = 0; //общее число проектов освоения лесов по филиалу
        $ttl_od_sum = 0; //общее число иной документации по филиалу
        $sumWorkFo =0 ; //общее число проектной документации в работе всего
        $sumCompFo = 0; //общее число завершенной проектной документации всего
        $sumAllFo = 0; //общее число проектной документации всего
        $sumWorkFp = 0; //общее число лесных планов всего
        $sumWorkod = 0; //общее число иной документации всего
        $sumWorkFpr = 0; //общее число проектов освоения лесов всего
        $sumWorkFr = 0; //общее число лесхоз. регламентов всего



        return $this->render('summarybranch', [
            'dataChange'=>$dataChange,
            'sumBranch' => $sumBranch,
            'branchs'=>$branchs,
            'subjects'=>$subjects,
            'pdworks'=>$pdworks,
            'areas'=>$areas,
            'sumWorkFo' => $sumWorkFo,
            'sumCompFo' => $sumCompFo,
            'sumAllFo' => $sumAllFo,
            'sumWorkFp' => $sumWorkFp,
            'sumWorkod' => $sumWorkod,
            'sumWorkFpr' => $sumWorkFpr,
            'sumWorkFr' => $sumWorkFr,
            'total_work'=>$total_work,
            'total_completed'=>$total_completed,
            'total_sum'=>$total_sum,
            'ttl_fp_sum'=>$ttl_fp_sum,
            'ttl_fr_sum'=>$ttl_fr_sum,
            'ttl_fpr_sum'=>$ttl_fpr_sum,
            'ttl_od_sum'=>$ttl_od_sum,
        ]);

    }

    public function actionSummaryProject()
    {
        $dateNow = date_default_timezone_get();

        if (Yii::$app->request->get('request_date'))
            $dataExpired =  Yii::$app->request->get('request_date') . '-31';
        elseif (Yii::$app->request->get('quarter')) {
            if (Yii::$app->request->get('year')) $this_year = Yii::$app->request->get('year');
            else $this_year = date("Y", strtotime($dateNow . ""));
            switch (Yii::$app->request->get('quarter')) {
                case 1:
                    $month = '03';
                    break;
                case 2:
                    $month = '06';
                    break;
                case 3:
                    $month = '09';
                    break;
                case 4:
                    $month = '12';
                    break;
            }
            $dataExpired = $this_year.'-'.$month.'-31';
        }
        else
            $dataExpired = date("Y-m-d", strtotime($dateNow . ""));

        $dataDefoldY = date("Y", strtotime($dateNow . ""));
        $dataDefoldM = date("m", strtotime($dateNow . ""));
        if (Yii::$app->request->get('request_date')) $dateDefold = Yii::$app->request->get('request_date');
        else $dateDefold = $dataDefoldY . '-' . $dataDefoldM;

        $branchs = Branch::find()->select(['branch_id','name'])->orderBy(['name'=>SORT_ASC])->asArray()->all();
        $branchs['38'] = $branchs['33'];
        unset($branchs['33']);

        if (Yii::$app->request->get('quarter')){
            $quarter = Yii::$app->request->get('quarter');
            $year = Yii::$app->request->get('year');
            if (!$year) $year = date("Y", strtotime( date_default_timezone_get() . ""));

            switch ($quarter) {
                case 1:
                    $start = '01';
                    $end = '03';
                    break;
                case 2:
                    $start = '04';
                    $end = '06';
                    break;
                case 3:
                    $start = '07';
                    $end = '09';
                    break;
                case 4:
                    $start = '10';
                    $end = '12';
                    break;
            }
            $newAllPd = PdWork::find()->where(['and' , ['>=' , 'date_create', "$year-$start-01"] , ['<=','date_create', "$year-$end-31"] ])->all();
            $completedAllPd = PdWork::find()->where(['and' , ['>=' , 'fact_datefinish', "$year-$start-01"] , ['<=','fact_datefinish', "$year-$end-31"] ])->andWhere(['=','completed','1'])->all();
            $workAllPd = PdWork::find()->where( ['=','completed','0'])->andWhere(['and' , ['>=' , 'basedoc_datasign', "$year-$start-01"] , ['<=','basedoc_datasign', "$year-$end-31"] ])->all();
            // Количество документов в работе:
            $pdwork_active = PdWork::find()
                ->select(['work_type' =>'work_name', 'forestry_qnty' => 'SUM(IF(forestry_quantity = 0 or forestry_quantity is NULL, 1, forestry_quantity))', 'row_qnty' => 'COUNT(*)' ])
                ->groupBy('work_name')
                ->andWhere("completed = 0")
                ->andWhere(['and' , ['>=' , 'basedoc_datasign', "$year-$start-01"] , ['<=','basedoc_datasign', "$year-$end-31"] ])
                ->all();
            // Запрос завершенных работ за год
            $pdwork_closed = PdWork::find()
                ->select(['work_type' =>'work_name', 'forestry_qnty' => 'SUM(IF(forestry_quantity = 0 or forestry_quantity is NULL, 1, forestry_quantity))', 'row_qnty' => 'COUNT(*)' ])
                ->groupBy('work_name')
                ->andWhere("completed = 1")
                ->andWhere(['and' , [">=", "fact_datefinish", "$year-$start-01"], ['<=','fact_datefinish', "$year-$end-31"]])
                ->all();
        }
        else{
            $newAllPd = PdWork::find()->where(['and' , ['>=' , 'date_create', "$dateDefold-01"] , ['<=','date_create', "$dateDefold-31"] ])->all();
            $completedAllPd = PdWork::find()->where(['and' , ['>=' , 'fact_datefinish', "$dataDefoldY-01-01"] , ['<=','fact_datefinish', "$dateDefold-31"] ])->andWhere(['=','completed','1'])->all();
            $workAllPd = PdWork::find()->where( ['=','completed','0'])->all();
            // Количество документов в работе:
            $pdwork_active = PdWork::find()
                ->select(['work_type' =>'work_name', 'forestry_qnty' => 'SUM(IF(forestry_quantity = 0 or forestry_quantity is NULL, 1, forestry_quantity))', 'row_qnty' => 'COUNT(*)' ])
                ->groupBy('work_name')
                ->andWhere("completed = 0")
                ->all();
            // Запрос завершенных работ за год
            $pdwork_closed = PdWork::find()
                ->select(['work_type' =>'work_name', 'forestry_qnty' => 'SUM(IF(forestry_quantity = 0 or forestry_quantity is NULL, 1, forestry_quantity))', 'row_qnty' => 'COUNT(*)' ])
                ->groupBy('work_name')
                ->andWhere("completed = 1")
                ->andWhere(['and' , [">=", "fact_datefinish", "$dataDefoldY-01-01"], ['<=','fact_datefinish', "$dateDefold-31"]])
                ->all();
        }
        $ca['completed'] = 0;
        $ca['work'] = 0;
        $ca['new'] = 0;
        $ca['expired'] = 0;

        $ttl_pd = $ttl_lp = $ttl_lhr = $ttl_pol = $ttl_other = $lhr_contracts = 0;

        // Количество документов, В РАБОТЕ в текущем году: !!$pdwork_active
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

        // Количество документов, закрытых в текущем году: !!$pdwork_closed
        $ttlc_pd =$ttlc_lp = $ttlc_lhr = $ttlc_pol = $ttlc_other = $lhrc_contracts = 0;
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

        foreach ($completedAllPd as $completedPd){

            if ($completedPd['signed_by_ca'] == 1){
                $ca['completed'] += ($completedPd['forestry_quantity']) ? $completedPd['forestry_quantity'] : 1 ;
                if ($completedPd['forestry_quantity']) {
                    if (isset($ca[$completedPd['work_name']]))
                        $ca[$completedPd['work_name']] += $completedPd['forestry_quantity'];
                    else
                        $ca[$completedPd['work_name']] = $completedPd['forestry_quantity'];
                }
                else {
                    if (isset($ca[$completedPd['work_name']]))
                        $ca[$completedPd['work_name']] += 1;
                    else
                        $ca[$completedPd['work_name']] = 1;
                }
            }

            if ($completedPd['forestry_quantity']) {

                if (isset($cubic[$completedPd['branch']]['completed']))
                    $cubic[$completedPd['branch']]['completed'] += $completedPd['forestry_quantity'];
                else
                    $cubic[$completedPd['branch']]['completed'] = $completedPd['forestry_quantity'];

                if (isset($cubic[$completedPd['branch']][$completedPd['work_name']]))
                    $cubic[$completedPd['branch']][$completedPd['work_name']] += $completedPd['forestry_quantity'];
                else
                    $cubic[$completedPd['branch']][$completedPd['work_name']] = $completedPd['forestry_quantity'];

            }
            else  {
                if (isset($cubic[$completedPd['branch']]['completed']))
                    $cubic[$completedPd['branch']]['completed'] += 1;
                else
                    $cubic[$completedPd['branch']]['completed'] = 1;

                if (isset($cubic[$completedPd['branch']][$completedPd['work_name']]))
                    $cubic[$completedPd['branch']][$completedPd['work_name']] += 1;
                else
                    $cubic[$completedPd['branch']][$completedPd['work_name']] = 1;
            }


        }
        foreach ($workAllPd as $workPd){
            if ($workPd['signed_by_ca'] == 1){
                if($workPd['basedoc_datefinish'] < $dataExpired)
                    $ca['expired'] += ($workPd['forestry_quantity']) ? $workPd['forestry_quantity'] : 1 ;
                $ca['work'] += ($workPd['forestry_quantity']) ? $workPd['forestry_quantity'] : 1 ;
                if ($workPd['forestry_quantity']) {
                    if (isset($ca[$workPd['work_name']]))
                        $ca[$workPd['work_name']] += $workPd['forestry_quantity'];
                    else
                        $ca[$workPd['work_name']] = $workPd['forestry_quantity'];
                }
                else {
                    if (isset($ca[$workPd['work_name']]))
                        $ca[$workPd['work_name']] += 1;
                    else
                        $ca[$workPd['work_name']] = 1;
                }
            }
            //Просрочка
            if ($workPd['basedoc_datefinish'] < $dataExpired){
                if ($workPd['forestry_quantity']) {
                    if (isset($cubic['expired'])) $cubic['expired'] += $workPd['forestry_quantity'];
                    else $cubic['expired'] = $workPd['forestry_quantity'];
                    if (isset($cubic[$workPd['branch']]['expired']))
                        $cubic[$workPd['branch']]['expired'] += $workPd['forestry_quantity'];
                    else
                        $cubic[$workPd['branch']]['expired'] = $workPd['forestry_quantity'];
                }
                else  {
                    if (isset($cubic['expired'])) $cubic['expired'] += 1;
                    else $cubic['expired'] = 1;
                    if (isset($cubic[$workPd['branch']]['expired']))
                        $cubic[$workPd['branch']]['expired'] += 1;
                    else
                        $cubic[$workPd['branch']]['expired'] = 1;
                }
            }

            if ($workPd['forestry_quantity']) {
                if (isset($cubic[$workPd['branch']]['work']))
                    $cubic[$workPd['branch']]['work'] += $workPd['forestry_quantity'];
                else
                    $cubic[$workPd['branch']]['work'] = $workPd['forestry_quantity'];

                if (isset($cubic[$workPd['branch']][$workPd['work_name']]))
                    $cubic[$workPd['branch']][$workPd['work_name']] += $workPd['forestry_quantity'];
                else
                    $cubic[$workPd['branch']][$workPd['work_name']] = $workPd['forestry_quantity'];

            }
            else  {
                if (isset($cubic[$workPd['branch']]['work']))
                    $cubic[$workPd['branch']]['work'] += 1;
                else
                    $cubic[$workPd['branch']]['work'] = 1;

                if (isset($cubic[$workPd['branch']][$workPd['work_name']]))
                    $cubic[$workPd['branch']][$workPd['work_name']] += 1;
                else
                    $cubic[$workPd['branch']][$workPd['work_name']] = 1;
            }
        }

        foreach ($newAllPd as $newPd){
            if ($workPd['signed_by_ca'] == 1) $ca['new'] += ($workPd['forestry_quantity']) ? $workPd['forestry_quantity'] : 1 ;

            if ($newPd['forestry_quantity']) {
                if (isset($cubic[$newPd['branch']]['new']))
                    $cubic[$newPd['branch']]['new'] += $newPd['forestry_quantity'];
                else
                    $cubic[$newPd['branch']]['new'] = $newPd['forestry_quantity'];
            }
            else{
                if (isset($cubic[$newPd['branch']]['new']))
                    $cubic[$newPd['branch']]['new'] += 1;
                else
                    $cubic[$newPd['branch']]['new'] = 1;
            }

        }


        // Если запрашиваем PDF-документ
        if (isset($_GET['format']) && $_GET['format'] == 'pdf') {

            $content = $this->renderPartial('summaryproject', compact('cubic','ca', 'branchs', 'ttl_pd', 'ttl_lp', 'ttl_lhr', 'ttl_pol', 'ttl_other', 'ttlc_pd', 'ttlc_lp', 'ttlc_lhr', 'ttlc_pol', 'ttlc_other', 'lhr_contracts', 'lhrc_contracts'));
            $curdate = date("Y-m-d");

            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8,
                'format' => Pdf::FORMAT_A3,
                'orientation' => Pdf::ORIENT_LANDSCAPE,
                'destination' => Pdf::DEST_BROWSER,
                'filename' => "Отчет_Проекты-Филиал_{$curdate}.pdf",
                'content' => $content,
                'cssInline' => '
                  
                    .form-inline{display: none;}
                    body {color: #000;}
                    .table {margin-top: 100px}
                    .table-bordered thead tr th, .table-bordered tbody tr th, .table-bordered tfoot tr th, .table-bordered thead tr td, .table-bordered tbody tr td, .table-bordered tfoot tr td {border: 1px solid #000;}
                    .table thead tr th, .table tbody tr th, .table tfoot tr th, .table thead tr td, .table tbody tr td, .table tfoot tr td {padding: 16px;}
                    th, h1 {text-align: center;}
                    h1 {font-size: 18pt; padding-top: 200px; float: left;}
                    .tabheader1 th, .tabheader2 th, .colnumbers th {font-size: 12pt;}
                    .tabheader2 th {color: rgb(255,255,255)}
                    .colnumbers td {font-size: 10pt; text-align: center; color: #333}

                    .vertical { font-size: 10pt;}

                    .message_head td, tfoot td {font-weight: bold; font-size: 14pt; background: #f0f0f0;}
                    tfoot td {background: #e0e0e0;}

                    .subpart td:nth-child(1) {padding-left: 20pt;}
                    .subpart td {color: #666;  font-size: 12pt;}
                    
                    .completedpol {background: #99ffaa;}
                    .hide_all_details, .show_all_details, .markers, .btn {display:none}
                    .rli_logo {float: left; width: 300px}
                ',
                'methods' => [
                    'SetHeader'=>['Форма Проекты-Филиал'],
                    'SetFooter'=>['Дата {DATE j-m-Y}||{PAGENO}'],
                    'SetTitle' => 'Форма Проекты-Филиал',
                ],
                'options' => [
                    'defaultheaderline' => 0, // 1 or 0 - line under the header
                    'defaultfooterline' => 0,
                    'dpi' => 300,
                    'img_dpi' => 300,
                    'options' => ['title' => 'Форма Проекты-Филиал'],
                ]
            ]);
            return $pdf->render();
        }



        return $this->render('summaryproject', [
            'branchs'=>$branchs,
            'cubic'=>$cubic,
            'ca'=>$ca,
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
        ]);
    }

    public function actionSummaryPol()
    {

        $dateNow = date_default_timezone_get();
        $dataDefoldY = date("Y", strtotime($dateNow . ""));
        $dataDefoldM = date("m", strtotime($dateNow . ""));
        if (Yii::$app->request->get('request_date')) {
            $dateDefold = Yii::$app->request->get('request_date');
//            $dateDefolded = $dateDefold.'-01';
            $dataDefoldY = date($dateDefold);
            $dataDefoldY = date("Y", strtotime($dataDefoldY . ""));
        }
        else  $dateDefold =  $dataDefoldY.'-'.$dataDefoldM;


        $polsPd = PdWork::find()
            ->where(['=','work_name','4'])
            ->andWhere(['and',['=','completed', '1'],['and' , ['>=' , 'fact_datefinish', "$dataDefoldY-01-01"] , ['<=','fact_datefinish', "$dataDefoldY-12-31"]]])
            ->orWhere(['and',['=','completed','0'],['=','work_name','4']])
            ->all();


        $branches = branch::find()->select(['branch_id', 'name'])->where('branch_id != 0')->orderBy(['name' => SORT_ASC])->all();
        $subjects = federalSubject::find()->select(['federal_subject_id', 'name'])->orderBy(['name' => SORT_ASC])->all();


        foreach ($polsPd as $polPd){
            //Итого
            if (isset($cubik['all_branch'][$polPd['forest_usage']]))  $cubik['all_branch'][$polPd['forest_usage']] += 1;
            else  $cubik['all_branch'][$polPd['forest_usage']] = 1;
            //для филиала
            if (isset($cubik[$polPd['branch']]['sum_by_branch'][$polPd['forest_usage']]))  $cubik[$polPd['branch']]['sum_by_branch'][$polPd['forest_usage']] += 1;
            else  $cubik[$polPd['branch']]['sum_by_branch'][$polPd['forest_usage']] = 1;
            //для субъекта
            if (isset($cubik[$polPd['branch']][$polPd['federal_subject']][$polPd['forest_usage']]))  $cubik[$polPd['branch']][$polPd['federal_subject']][$polPd['forest_usage']] += 1;
            else  $cubik[$polPd['branch']][$polPd['federal_subject']][$polPd['forest_usage']] = 1;


            if (!$polPd['completed']){
                //Итого
                if (isset($cubik['all_branch']['work']))  $cubik['all_branch']['work'] += 1;
                else  $cubik['all_branch']['work'] = 1;
                //для филиала
                if (isset($cubik[$polPd['branch']]['sum_by_branch']['work']))  $cubik[$polPd['branch']]['sum_by_branch']['work'] += 1;
                else  $cubik[$polPd['branch']]['sum_by_branch']['work'] = 1;
                //для субъекта
                if (isset($cubik[$polPd['branch']][$polPd['federal_subject']]['work']))  $cubik[$polPd['branch']][$polPd['federal_subject']]['work'] += 1;
                else  $cubik[$polPd['branch']][$polPd['federal_subject']]['work'] = 1;
            }

            if ($polPd['completed']){
                //для субъекта
                if (isset($cubik[$polPd['branch']][$polPd['federal_subject']]['completed']))  $cubik[$polPd['branch']][$polPd['federal_subject']]['completed'] += 1;
                else  $cubik[$polPd['branch']][$polPd['federal_subject']]['completed'] = 1;
                //для филиала
                if (isset($cubik[$polPd['branch']]['sum_by_branch']['completed'])) $cubik[$polPd['branch']]['sum_by_branch']['completed'] += 1;
                else  $cubik[$polPd['branch']]['sum_by_branch']['completed'] = 1;
                //Итого
                if (isset($cubik['all_branch']['completed'])) $cubik['all_branch']['completed'] += 1;
                else  $cubik['all_branch']['completed'] = 1;
            }

            if ($polPd['date_create'] >= $dateDefold.'-01' and $polPd['date_create'] <= $dateDefold.'-31' ){
                //для субъекта
                if (isset($cubik[$polPd['branch']][$polPd['federal_subject']]['new']))  $cubik[$polPd['branch']][$polPd['federal_subject']]['new'] += 1;
                else  $cubik[$polPd['branch']][$polPd['federal_subject']]['new'] = 1;
                //для филиала
                if (isset($cubik[$polPd['branch']]['sum_by_branch']['new'])) $cubik[$polPd['branch']]['sum_by_branch']['new'] += 1;
                else  $cubik[$polPd['branch']]['sum_by_branch']['new'] = 1;
                //Итого
                if (isset($cubik['all_branch']['new'])) $cubik['all_branch']['new'] += 1;
                else  $cubik['all_branch']['new'] = 1;
            }



        }

        // Если запрашиваем PDF-документ
        if (isset($_GET['format']) && $_GET['format'] == 'pdf') {

            $content = $this->renderPartial('summarypol', compact('cubik', 'branches', 'subjects'));
            $curdate = date("Y-m-d");

            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8,
                'format' => Pdf::FORMAT_A3,
                'orientation' => Pdf::ORIENT_LANDSCAPE,
                'destination' => Pdf::DEST_BROWSER,
                'filename' => "Отчет_форма_6-ПОЛ_{$curdate}.pdf",
                'content' => $content,
                'cssInline' => '
                    .form-inline{display:none;}
                    body {color: #000;}
                    .table {margin-top: 100px}
                    .table-bordered thead tr th, .table-bordered tbody tr th, .table-bordered tfoot tr th, .table-bordered thead tr td, .table-bordered tbody tr td, .table-bordered tfoot tr td {border: 1px solid #000;}
                    .table thead tr th, .table tbody tr th, .table tfoot tr th, .table thead tr td, .table tbody tr td, .table tfoot tr td {padding: 16px;}
                    th, h1 {text-align: center;}
                    h1 {font-size: 18pt; padding-top: 200px; float: left;}
                    .tabheader1 th, .tabheader2 th, .colnumbers th {font-size: 12pt;}
                    .tabheader2 th {color: rgb(255,255,255)}
                    .colnumbers td {font-size: 10pt; text-align: center; color: #333}

                    .vertical { font-size: 10pt;}

                    .message_head td, tfoot td {font-weight: bold; font-size: 14pt; background: #f0f0f0;}
                    tfoot td {background: #e0e0e0;}

                    .subpart td:nth-child(1) {padding-left: 20pt;}
                    .subpart td {color: #666;  font-size: 12pt;}
                    
                    .completedpol {background: #99ffaa;}
                    .hide_all_details, .show_all_details, .markers, .btn {display:none}
                    .rli_logo {float: left; width: 300px}
                ',
                'methods' => [
                    'SetHeader'=>['Форма 6-ПОЛ'],
                    'SetFooter'=>['Дата {DATE j-m-Y}||{PAGENO}'],
                    'SetTitle' => 'Форма 6-ПОЛ',
                ],
                'options' => [
                    'defaultheaderline' => 0, // 1 or 0 - line under the header
                    'defaultfooterline' => 0,
                    'dpi' => 300,
                    'img_dpi' => 300,
                    'options' => ['title' => 'Форма 6-ПОЛ'],
                ]
            ]);

            return $pdf->render();
        }



        return $this->render('summarypol', compact('cubik', 'branches', 'subjects'));
    }





}
