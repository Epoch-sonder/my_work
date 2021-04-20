<?php

namespace app\controllers;

use app\models\CaCurator;

use Yii;
use app\modules\pd\models\PdWork;
use app\modules\audit\models\FederalDistrict;
use app\modules\pd\models\Branch;
use app\modules\pd\models\SearchPdWork;
use app\modules\forest_work\models\ForestWork;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SignupForm;
use app\models\User;
use yii\base\Action;
use yii\bootstrap\ActiveForm;
use unclead\multipleinput\examples\models\ExampleModel;

/**
 * Class MultipleInputAction
 * @package unclead\multipleinput\examples\actions
 */

class SiteController extends Controller
{

	
	public function behaviors()
    {
        return [
			
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
   public function actionIndex($completed = 1)
    {

        //Yii::$app->user->logout();
        //$this->goHome();

        $searchModel = new SearchPdWork();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $branches = Branch::find()->select(['branch_id', 'name'])->orderBy(['branch_id' => SORT_ASC])->orderBy(['name' => SORT_ASC])->all(); 
        

       
        if(Yii::$app->user->isGuest) { 
            $branchID = 0;
        } else {
            $branchID = Yii::$app->user->identity->branch_id;
        }



        if($branchID != 0 ) {
        $condBranch = 'pd_work.branch = '. $branchID;
        $dataProvider->query->andWhere("pd_work.branch =  $branchID");
        }
        else $condBranch = '';


        $today = date('Y-m-d');
        $contrdate = date('Y-03-01');
        $lastyear = date ('Y-01-01', strtotime('-1 year')); //начало прошлого года
        $thisyear = date ('Y-01-01'); //начало текущего года
        $nextyear = date ('Y-01-01', strtotime('+1 year')); //начало следующего года
       

     //код для графика по видам документации 

        if ($today < $contrdate){  
            $dateComp =  ['and' , [">=", "fact_datefinish", "$lastyear"], ['<','fact_datefinish', "$thisyear"]];
            $titleName = 'Итоги 2020 года';
        } else {
            $dateComp = ['and' , ['>=', 'fact_datefinish', "$thisyear"], ['<','fact_datefinish', "$nextyear"]];
            $titleName = 'Разработанная проектная документация в текущем году';
        }

       // Запрос завершенных работ за год
        $pdwork_closed = PdWork::find()
            ->select(['work_type' =>'work_name', 'forestry_qnty' => 'SUM(IF(forestry_quantity = 0 or forestry_quantity is NULL, 1, forestry_quantity))', 'row_qnty' => 'COUNT(*)' ])
            ->groupBy('work_name')
            ->where($condBranch)
            ->andWhere("completed = 1")
            ->andWhere($dateComp)
            ->all();

            //виды работ
        $pdtypework = array (1=>'Лесной план', 'Лесохозяйственный регламент', 'Проектная документации лесного участка', 'Проект освоения лесов', 'Проект рекультивации нарушенных земель', 'Лесная декларация', 'Отчет об использовании (защите, воспроизводстве) лесов', 'Проект лесовосстановления', 'Проект по изменению целевого назначения лесов', 'Проект по проектированию ОЗУ лесов', 'Проект установления (изменения) границ лесопарковых зон (зеленых зон)', 'Установление лесопаркового зеленого зона', 'Проект планировки территории', 'Проект межевания территории', 'Перевод из состава земель лесного фонда', 'Концепция инвестиционного проекта', 'Проект противопожарного обустройства лесов', 'Проект организации охотничьего хозяйства', 'Проект организации территории ООПТ', 'Проект реконструкции усадебного парка', 'Проект оценки на окружающую среду', 'Проект организации санитарно-защитной зоны', 'Проект нормативов предельно допустимых выбросов', 'Проект нормативов образования отходов и лимитов на их размещение', 'Прочие проекты');

        // Количество завершенной документации
        $ttl_lp = $ttl_lhr = $ttl_pol = $ttl_other = $lhr_contracts = 0;
        foreach ($pdwork_closed as $pdwork) {
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

        settype($ttl_lp, 'integer'); 
        settype($ttl_lhr, 'integer');
        settype($ttl_pol, 'integer');
        settype($ttl_other, 'integer');
        settype($ttl_pd, 'integer');

        
    //подсчет документации в работе
    
       $ttlinw_pd = $ttlinw_lp = $ttlinw_lhr = $ttlinw_pol = $ttlinw_other = $lhrinw_contracts = 0;

       $ttlinw_dlu = $ttlinw_rnz = $ttlinw_ld = $ttlinw_useles = $ttlinw_plv = $ttlinw_pincl = $ttlinw_ozu = $ttlinw_puglz = $ttlinw_ulpzp = $ttlinw_ppt = $ttlinw_pmt = $ttlinw_transfer = $ttlinw_kip = $ttlinw_fireprev = $ttlinw_hunt = $ttlinw_oopt = $ttlinw_prup = $ttlinw_ovos = $ttlinw_szz = $ttlinw_pdv = $ttlinw_pnoolr = 0;

       $completed = 0;


        if(!$completed) {
                        
            // Количество документов в работе:
            $pdwork_active = PdWork::find()
                ->select(['work_type' =>'work_name', 'forestry_qnty' => 'SUM(IF(forestry_quantity = 0 or forestry_quantity is NULL, 1, forestry_quantity))', 'row_qnty' => 'COUNT(*)' ])
                ->groupBy('work_name')
                ->where($condBranch)
                ->andWhere("completed = 0")
                ->all();
            
            
            foreach ($pdwork_active as $pdwork) {
                if ($pdwork->work_type == 1) $ttlinw_lp = $pdwork->row_qnty; // лесных планов
                elseif ($pdwork->work_type == 2) {
                    $ttlinw_lhr = $pdwork->forestry_qnty; // ЛХР, учитываем кол-во лесничеств
                    $lhrinw_contracts = $pdwork->row_qnty; // ЛХР, количество контрактов
                }
                elseif ($pdwork->work_type == 4) $ttlinw_pol = $pdwork->forestry_qnty; // ПОЛ, учитываем кол-во лесничеств
                elseif ($pdwork->work_type == 3) $ttlinw_dlu += $pdwork->forestry_qnty; //проектная документация лесного участка
                elseif ($pdwork->work_type == 5) $ttlinw_rnz += $pdwork->forestry_qnty; //проект рекультивации нарушенных земель
                elseif ($pdwork->work_type == 6) $ttlinw_ld += $pdwork->forestry_qnty; //лесная декларация
                elseif ($pdwork->work_type == 7) $ttlinw_useles += $pdwork->forestry_qnty; //отчет об использовании (защите, воспроиизводстве) лесов
                elseif ($pdwork->work_type == 8) $ttlinw_plv += $pdwork->forestry_qnty; //проект лесовосстановления
                elseif ($pdwork->work_type == 9) $ttlinw_pincl += $pdwork->forestry_qnty; //проект изменения целевого назначения лесов
                elseif ($pdwork->work_type == 10) $ttlinw_ozu += $pdwork->forestry_qnty; //проект по проектированию особо защитных участков
                elseif ($pdwork->work_type == 11) $ttlinw_puglz += $pdwork->forestry_qnty; //проект установления (изменения) границ лесопарковых зон (зеленых зон)
                elseif ($pdwork->work_type == 12) $ttlinw_ulpzp += $pdwork->forestry_qnty; //установление лесопаркового зеленого пояса
                elseif ($pdwork->work_type == 13) $ttlinw_ppt += $pdwork->row_qnty; //проект планирования территории
                elseif ($pdwork->work_type == 14) $ttlinw_pmt += $pdwork->row_qnty; //проект межевания территории 
                elseif ($pdwork->work_type == 15) $ttlinw_transfer += $pdwork->forestry_qnty; //перевод из состава земель лесного фонда
                elseif ($pdwork->work_type == 16) $ttlinw_kip += $pdwork->forestry_qnty; //концепция инвестиционного рынка
                elseif ($pdwork->work_type == 17) $ttlinw_fireprev += $pdwork->forestry_qnty; //проект противопожарного обустройства лесов
                elseif ($pdwork->work_type == 18) $ttlinw_hunt += $pdwork->forestry_qnty; //проект организации охотничьего хозяйства
                elseif ($pdwork->work_type == 19) $ttlinw_oopt += $pdwork->forestry_qnty; //проект организации ООПТ
                elseif ($pdwork->work_type == 20) $ttlinw_prup += $pdwork->forestry_qnty; //проект организации усадебного парка
                elseif ($pdwork->work_type == 21) $ttlinw_ovos += $pdwork->forestry_qnty; //проект оценки на окружающую среду
                elseif ($pdwork->work_type == 22) $ttlinw_szz += $pdwork->forestry_qnty;//проект организации санитарно-защитной зоны
                elseif ($pdwork->work_type == 23) $ttlinw_pdv += $pdwork->forestry_qnty;//проект нормативов предельно допустимых выбросов
                elseif ($pdwork->work_type == 24) $ttlinw_pnoolr += $pdwork->forestry_qnty; //проект нормативов образования отходов и лимитов на их размещение
                else $ttlinw_other += $pdwork->forestry_qnty; //учитываем кол-во лесничеств
            }
            $ttlinw_pd = $ttlinw_lp + $ttlinw_lhr + $ttlinw_pol + $ttlinw_other + $ttlinw_dlu + $ttlinw_rnz + $ttlinw_ld + $ttlinw_useles + $ttlinw_plv + $ttlinw_pincl + $ttlinw_ozu + $ttlinw_puglz + $ttlinw_ulpzp + $ttlinw_ppt + $ttlinw_pmt + $ttlinw_transfer + $ttlinw_kip + $ttlinw_fireprev + $ttlinw_hunt + $ttlinw_oopt + $ttlinw_prup + $ttlinw_ovos + $ttlinw_szz + $ttlinw_pdv + $ttlinw_pnoolr;; // всего

           settype($ttlinw_lp, 'integer'); 
           settype($ttlinw_lhr, 'integer');
           settype($ttlinw_pol, 'integer');
           settype($ttlinw_other, 'integer');
           settype($ttlinw_pd, 'integer');
        

           }

// Определяем текущий год
        $ouryear =  ['and' , ['>=', 'fact_datefinish', "$thisyear"], ['<','fact_datefinish', "$nextyear"]];
        $today = date('Y-m-d');
        $newwT = 0; //количество новых сегодня в работе
        $newcT = 0; //количество новых сегодня завершенных


//код для вертикального графика
//цикл по филиалам
    foreach ($branches as $branch){
            $branchName = $branch->name; //название филиала
            $brID = $branch->branch_id;

        if ($brID != 0){

//подсчет документации в работе для каждого филиала
            $pdwork_active = PdWork::find()->select(['work_type' =>'work_name', 'forestry_qnty' => 'SUM(IF(forestry_quantity = 0 or forestry_quantity is NULL, 1, forestry_quantity))', 'row_qnty' => 'COUNT(*)', 'date_create'])->groupBy('work_name')->where("branch = $brID")->andWhere("completed = 0")->all();

            $brw_lp = $brw_lhr = $brw_pol = $brw_other = 0;
            $brwT_lp = $brwT_lhr = $brwT_pol = $brwT_other = 0; //сегодняшние

            foreach ($pdwork_active as $pdwork) {
                if ($pdwork->work_type == 1) $brw_lp = $pdwork->row_qnty; // лесных планов
                elseif ($pdwork->work_type == 2) {
                    $brw_lhr = $pdwork->forestry_qnty; // ЛХР, учитываем кол-во лесничеств
                }
                elseif ($pdwork->work_type == 4) $brw_pol = $pdwork->forestry_qnty; // ПОЛ, учитываем кол-во лесничеств
                elseif ($pdwork->work_type == 13 || $pdwork->work_type == 14) $brw_other += $pdwork->row_qnty; // учитываем кол-во договоров
                else $brw_other += $pdwork->forestry_qnty; //учитываем кол-во лесничеств*/

                //проверка, что отчет отправлен сегодня
                if ($pdwork->date_create == $today)
                    if ($pdwork->work_type == 1)  $brwT_lp = $pdwork->row_qnty; // лесных планов
                    elseif ($pdwork->work_type == 2) {
                        $brwT_lhr = $pdwork->forestry_qnty; // ЛХР, учитываем кол-во лесничеств
                    }
                    elseif ($pdwork->work_type == 4) $brwT_pol = $pdwork->forestry_qnty; // ПОЛ, учитываем кол-во лесничеств
                    elseif ($pdwork->work_type == 13 || $pdwork->work_type == 14) $brwT_other += $pdwork->row_qnty; // учитываем кол-во договоров
                    else $brwT_other += $pdwork->forestry_qnty; //учитываем кол-во лесничеств*/
            }

            $brw_pd = $brw_lp + $brw_lhr + $brw_pol + $brw_other; // всего в работе
            $brwT_pd = $brwT_lp + $brwT_lhr + $brwT_pol + $brwT_other; // всего в работе за сегодня
            $newwT += $brwT_pd;
                                                        
//подсчет завершенной документации для каждого филиала
            $pdwork_closed = PdWork::find()->select(['work_type' =>'work_name', 'forestry_qnty' => 'SUM(IF(forestry_quantity = 0 or forestry_quantity is NULL, 1, forestry_quantity))', 'row_qnty' => 'COUNT(*)', 'date_create'])->groupBy('work_name')->where("branch = $brID")->andWhere("completed = 1")->andWhere($ouryear)->all();

            $brc_lp = $brc_lhr = $brc_pol = $brc_other = $brc_contracts = 0;
            $brcT_lp = $brcT_lhr = $brcT_pol = $brcT_other = $brcT_contracts = 0;

            foreach ($pdwork_closed as $pdwork) {
               if ($pdwork->work_type == 1) $brc_lp = $pdwork->row_qnty; // лесных планов
                elseif ($pdwork->work_type == 2) {
                    $brc_lhr = $pdwork->forestry_qnty; // ЛХР, учитываем кол-во лесничеств
                       $brс_contracts = $pdwork->row_qnty; // ЛХР, количество контрактов
                }
                elseif ($pdwork->work_type == 4) $brc_pol = $pdwork->forestry_qnty; // ПОЛ, учитываем кол-во лесничеств
                elseif ($pdwork->work_type == 13 || $pdwork->work_type == 14) $brc_other += $pdwork->row_qnty; // учитываем кол-во договоров
                else $brc_other += $pdwork->forestry_qnty; //учитываем кол-во лесничеств

                //проверка, что отчет отправлен сегодня
                if ($pdwork->date_create == $today)
                    if ($pdwork->work_type == 1)  $brcT_lp = $pdwork->row_qnty; // лесных планов
                    elseif ($pdwork->work_type == 2) {
                        $brcT_lhr = $pdwork->forestry_qnty; // ЛХР, учитываем кол-во лесничеств
                    }
                    elseif ($pdwork->work_type == 4) $brcT_pol = $pdwork->forestry_qnty; // ПОЛ, учитываем кол-во лесничеств
                    elseif ($pdwork->work_type == 13 || $pdwork->work_type == 14) $brcT_other += $pdwork->row_qnty; // учитываем кол-во договоров
                    else $brcT_other += $pdwork->forestry_qnty; //учитываем кол-во лесничеств*/
            }

            $brc_pd = $brc_lp + $brc_lhr + $brc_pol + $brc_other; // всего завершено 
            $brcT_pd = $brcT_lp + $brcT_lhr + $brcT_pol + $brcT_other; // всего завершено за сегодня
            $newcT += $brcT_pd;
                                              
            $name[] = $branchName;
            $docc[] = $brc_pd;
            $docw[] = $brw_pd;

            }
        }


    //код для графика виды использования лесов
        $typeusework = array (1 =>'Заготовка древесины', 'Заготовка живицы', 'Заготовка и сбор недревесных лесных ресурсов', 'Заготовка пищевых лесных ресурсов и сбор лекарственных растений', 'Осуществление видов деятельности в сфере охотничьего хозяйства', 'Ведение сельского хозяйства', 'Научно-исследовательская и образовательная деятельность', 'Рекреационная деятельность', 'Создание лесных плантаций и их эксплуатация', 'Выращивание лесных плодовых, ягодных, декоративных, лекарственных растений',  'Выращивание посадочного материала лесных растений (саженцев, сеянцев)', 'Геологическое изучение недр, разведка и добыча полезных ископаемых', 'Строительство и эксплуатация водоёмов и водных объектов', 'Строительство, реконструкция, эксплуатация линейных объектов', 'Переработка древесины и иных лесных ресурсов', 'Религиозная деятельность', 'Иные виды');


       
        $pdworks = PdWork::find()->select(['work_name', 'forest_usage', 'date_create', 'completed'])->orderBy(['date_create' => SORT_ASC])->where($condBranch)->all();


        $usage = array_fill(1, 17, 0); //массив с к-вом по каж. виду работ, изначально нулевой
        foreach ($pdworks as $pdwork) {
            if ($pdwork->work_name != 1 && $pdwork->work_name != 2){
                for ($i = 1; $i <= 17; $i++){
                    if ($pdwork->forest_usage == $i){
                        $usage[$i] += 1;  //прибавляем
                    }
                }
            }
        }



        for ($k=1; $k<=17; $k++){
            $plotmassiv[$k]['name'] = $typeusework[$k]; //массив, к-й будет использоваться в графике
            $plotmassiv[$k]['y'] = $usage[$k];
        }
        


        //код для графика по датам
        $j = 0;
        $count = 0; //счетчик числа добавленых отчетов в сутки
        $countAll = 0; //счетчик числа добавленых отчетов всего
        foreach ($pdworks as $pdwork) {
            if ($pdwork->date_create != NULL) {
                $dataCreate[$j] = $pdwork->date_create; //массив со всеми датами
                if ($j !=0){
                    if ($dataCreate[$j] != $dataCreate[$j-1]){ 
                        $dataOne[] = $pdwork->date_create; //массив с уникальными датами
                        $quantity[] = $count; //массив с числом отчетов за каж. дату
                        $count = 0; //счетчик сбрасывается, когда дата меняется
                        $quantityAll[] = $countAll; //массив с числом отчетов всего за каж. дату
                    }
                }
                else $dataOne[] = $pdwork->date_create;
                $count++;
                $countAll++;
                if ($pdwork->completed == 1) $countAll--;
                $j++;
            }
        }
        $quantity[] = $count;   //добавляем последнее число в массив
        $quantityAll[] = $countAll; //добавляем последнее число в массив

        if (empty($dataOne)){
             $dataOneChange = 0;
             $depension = 0;
        }
       else {
            for ($i=0; $i < count($dataOne); $i++) { 
            $dataOneChange[$i] = date("d-m-Y", strtotime($dataOne[$i]));
            $depension[$i] = [strtotime($dataOne[$i])*1000, $quantityAll[$i]]; //формируем зависимость кол-ва от времени и переводим время в нужный формат
            }
       }

        




        return $this->render('index', [
            'ttl_lp' => $ttl_lp,
            'ttl_lhr' => $ttl_lhr,
            'ttl_pol' => $ttl_pol,
            'ttl_other' => $ttl_other,
            'ttl_pd' => $ttl_pd,

            'ttlinw_lp' => $ttlinw_lp,
            'ttlinw_lhr' => $ttlinw_lhr,
            'ttlinw_pol' => $ttlinw_pol,
            'ttlinw_other' => $ttlinw_other,
            'ttlinw_pd' => $ttlinw_pd,
            'ttlinw_dlu' => $ttlinw_dlu,
            'ttlinw_rnz' => $ttlinw_rnz,
            'ttlinw_ld' => $ttlinw_ld,
            'ttlinw_useles' => $ttlinw_useles,
            'ttlinw_plv' => $ttlinw_plv,
            'ttlinw_pincl' => $ttlinw_pincl,            
            'ttlinw_ozu' => $ttlinw_ozu,
            'ttlinw_puglz' => $ttlinw_puglz,
            'ttlinw_ulpzp' => $ttlinw_ulpzp,
            'ttlinw_ppt' => $ttlinw_ppt,
            'ttlinw_pmt' => $ttlinw_pmt,
            'ttlinw_transfer' => $ttlinw_transfer,
            'ttlinw_kip' => $ttlinw_kip, 
            'ttlinw_fireprev' => $ttlinw_fireprev,
            'ttlinw_hunt' => $ttlinw_hunt,
            'ttlinw_oopt' => $ttlinw_oopt,
            'ttlinw_prup' => $ttlinw_prup,
            'ttlinw_ovos' => $ttlinw_ovos,
            'ttlinw_szz' => $ttlinw_szz,
            'ttlinw_pdv' => $ttlinw_pdv,
            'ttlinw_pnoolr' => $ttlinw_pnoolr,

            'pdtypework' => $pdtypework,

           
            'titleName' => $titleName,

            'name' => $name,
            'docc' => $docc,
            'docw' => $docw,


            'plotmassiv' => $plotmassiv,

            'quantity' => $quantity,
            'dataOneChange' => $dataOneChange,
            'depension' => $depension,

            'newwT' => $newwT,
            'newcT' => $newcT
    ]);
}


    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()){
                $user = User::find()->where(['=','username',$model->username])->select('enabled')->one();
                if ($user->enabled){
                    $model->login();
                    return $this->goBack();
                }
                else{
                    Yii::$app->session->setFlash('error', "Извините, но ваш аккаунт заблокирован. Если считаете, что произошла ошибка, напишите в тех.поддержку");
                }
            }
        }
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }


    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

	public function actionSignup(){
         if (!Yii::$app->user->isGuest) {
         return $this->goHome();
         }
         $model = new SignupForm();
         if($model->load(\Yii::$app->request->post()) && $model->validate()){
         $user = new User();
         $user->username = $model->username;
         $user->password = \Yii::$app->security->generatePasswordHash($model->password);
         $user->branch_id = $model->branch_id;
         $user->position = $model->position;
         $user->fio = $model->fio;
         $user->phone = $model->phone;

         if($user->save()){
         return $this->goHome();
         }
     }

 return $this->render('signup', compact('model'));
}

//Прописываем правила доступа в контроллер
/**
public function beforeAction($action)
	{
	if (parent::beforeAction($action)) {
		if (!\Yii::$app->user->can($action->id)) {
			throw new ForbiddenHttpException('Доступ запрещен');
		}
		return true;
	}	else	{
		return false;
	}
	}*/

	   /** Информация о модуле **/
    public function actionInfo()
    {
        return $this->render('info');
    }

	    /** Тех поддержка **/
    public function actionSupport()
    {
        return $this->render('support');
    }





	    
}




