<?php

namespace app\modules\pd\models;


use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pd\models\PdWork;

/**
 * SearchPdWork represents the model behind the search form of `app\modules\pd\models\PdWork`.
 */
class SearchPdWork extends PdWork
{
    /**
     * {@inheritdoc}
     */
    
    public $fullDocName;
    public $baseDocName;
    public $pdWorkName;
    public $branchName;
    public $federalSubjectName;

    public function rules()
    {
        return [
            [['id', 'branch', 'basedoc_type', 'work_cost', 'federal_subject', 'work_name', 'forest_usage', 'in_complex'], 'integer'],
            [['executor', 'customer', 'forestry', 'subforestry', 'subdivforestry', 'basedoc_name', 'basedoc_datasign', 'basedoc_datefinish', 'work_datastart', 'quarter', 'work_othername', 'comment', 'timestamp', 'baseDocName', 'fullDocName', 'pdWorkName', 'branchName', 'federalSubjectName', 'warning', 'warning_descr', 'remark', 'signed_by_ca','no_report'], 'safe'],
            [['work_area'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        // Если из метода GET получаем completed = 1 и request_date пустая
        if (Yii::$app->request->get('completed') == 1){

            //обращаемся к переменным из базы данных
            //Если дата изначально не указана, то берет год сегодняшнего дня
            $dataDefold = date_default_timezone_get();
            $dataDefold = date("Y", strtotime($dataDefold . ""));

            if (Yii::$app->request->get('request_date') > $dataDefold) {
                $dataChange = $dataDefold + 1;
            }
//            elseif (Yii::$app->request->get('request_date') < 1999){
//                $dataChange = "2000";
//            }
            elseif (Yii::$app->request->get('request_date')){
                $dataChange = Yii::$app->request->get('request_date');
            }
            else {
                $dataChange = $dataDefold;
            }
            $query = PdWork::find()->where(['=' , 'completed', '1'] )->andWhere( ['and' , ['>=' , 'fact_datefinish', "$dataChange-01-01"] , ['<=','fact_datefinish', "$dataChange-12-31"] ]);
        }
        else{
            $query = PdWork::find();
        }
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


         $dataProvider->setSort([
            'defaultOrder' => ['basedoc_datefinish'=>SORT_ASC],
            'attributes' => [
                // 'id',
                'id' => [
                    'asc' => ['id' => SORT_ASC],
                    'desc' => ['id' => SORT_DESC],
                    // 'label' => 'Документ-основание',
                    // 'default' => SORT_ASC
                ],
                'fullDocName' => [
                    'asc' => ['basedoc_type.doctype' => SORT_ASC, 'basedoc_name' => SORT_ASC],
                    'desc' => ['basedoc_type.doctype' => SORT_DESC, 'basedoc_name' => SORT_DESC],
                    // 'label' => 'Документ-основание',
                    // 'default' => SORT_ASC
                ],
                'pdWorkName' => [
                    'asc' => ['pd_worktype.work_name' => SORT_ASC],
                    'desc' => ['pd_worktype.work_name' => SORT_DESC],
                    'label' => 'Наименование работ'
                ],
                'federalSubjectName' => [
                    'asc' => ['federal_subject.name' => SORT_ASC],
                    'desc' => ['federal_subject.name' => SORT_DESC],
                    'label' => 'Субъект РФ'
                ],
                'branchName' => [
                    'asc' => ['branch.name' => SORT_ASC],
                    'desc' => ['branch.name' => SORT_DESC],
                    'label' => 'Филиал РЛИ'
                ],
                'in_complex' => [
                    'asc' => ['in_complex' => SORT_ASC],
                    'desc' => ['in_complex' => SORT_DESC],
                    'label' => 'в Комлексе'
                ],
                'fact_datefinish' => [
                    'asc' => ['fact_datefinish' => SORT_ASC],
                    'desc' => ['fact_datefinish' => SORT_DESC],
                ],
                'basedoc_datefinish' => [
                    'asc' => ['basedoc_datefinish' => SORT_ASC],
                    'desc' => ['basedoc_datefinish' => SORT_DESC],
                ],
                'warning' => [
                    'asc' => ['warning' => SORT_ASC],
                    'desc' => ['warning' => SORT_DESC],
                ],
                'work_datastart' => [
                    'asc' => ['work_datastart' => SORT_ASC],
                    'desc' => ['work_datastart' => SORT_DESC],
                ],
                'no_report' => [
                    'asc' => ['no_report' => SORT_ASC],
                    'desc' => ['no_report' => SORT_DESC],
                ],
                
            ]
        ]);


        $this->load($params);

        // if (!$this->validate()) {
        //     // uncomment the following line if you do not want to return any records when validation fails
        //     // $query->where('0=1');
        //     return $dataProvider;
        // }

        if (!($this->load($params) && $this->validate())) {
            /**
             * Жадная загрузка данных модели Страны
             * для работы сортировки.
             */
            $query
                ->joinWith(['basedocType'])
                ->joinWith(['workName'])
                ->joinWith(['federalSubject'])
                ->joinWith(['branch0']);
            return $dataProvider;
        }



        // grid filtering conditions
        $query->andFilterWhere([
            'branch' => $this->branch,
            'pd_work.id' => $this->id,
            'basedoc_type' => $this->basedoc_type,
            'basedoc_datasign' => $this->basedoc_datasign,
            // 'basedoc_datefinish' => $this->basedoc_datefinish,
            'signed_by_ca' => $this->signed_by_ca,
            'work_cost' => $this->work_cost,
            'work_datastart' => $this->work_datastart,
            'federal_subject' => $this->federal_subject,
            'forestry' => $this->forestry,
            'subforestry' => $this->subforestry,
            'subdivforestry' => $this->subdivforestry,
            'work_area' => $this->work_area,
            'work_name' => $this->work_name,
            'in_complex' => $this->in_complex,
            'forest_usage' => $this->forest_usage,
            'warning' => $this->warning,
            'timestamp' => $this->timestamp,
            'no_report' => $this->no_report,
        ]);

        $query->andFilterWhere(['like', 'executor', $this->executor])
//            ->andFilterWhere(['like', 'pd_work.id', $this->id])
            ->andFilterWhere(['like', 'customer', $this->customer])
            ->andFilterWhere(['like', 'basedoc_name', $this->basedoc_name])
             ->andFilterWhere(['like', 'basedoc_datasign', $this->basedoc_datasign])
            ->andFilterWhere(['like', 'basedoc_datefinish', $this->basedoc_datefinish])
            ->andFilterWhere(['like', 'quarter', $this->quarter])
            ->andFilterWhere(['like', 'work_othername', $this->work_othername])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->joinWith(['basedocType' => function ($q) { $q->where('basedoc_type.doctype LIKE "%' . $this->fullDocName . '%" ' . 'OR basedoc_name LIKE "%' . $this->fullDocName . '%"'); }])
            ->joinWith(['basedocType' => function ($q) { $q->where('basedoc_type.doctype LIKE "%' . $this->baseDocName . '%"'); }])
            ->joinWith(['workName' => function ($q) { $q->where('pd_worktype.work_name LIKE "%' . $this->pdWorkName . '%"'); }])
            ->joinWith(['federalSubject' => function ($q) { $q->where('federal_subject.name LIKE "%' . $this->federalSubjectName . '%"'); }])
            ->joinWith(['branch0' => function ($q) { $q->where('branch.name LIKE "%' . $this->branchName . '%"'); }])

            ;
            


        return $dataProvider;
    }
}
