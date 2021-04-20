<?php

namespace app\modules\audit\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\audit\models\TrainingProcess;

/**
 * SearchTrainingProcess represents the model behind the search form of `app\modules\audit\models\TrainingProcess`.
 */
class SearchTrainingProcess extends TrainingProcess
{
    /**
     * {@inheritdoc}
     */

        public $branchName;
        public $subjectName;
        public $forestgrowRegionName;
        public $personFio;
        public $municName;




    public function rules()
    {
        return [
            [['id', 'branch', 'subject', 'forestgrow_region', 'training_site_amount', 'training_strip_amount', 'person'], 'integer'],
            [[ 'municName','branchName','subjectName','forestgrowRegionName','personFio','munic_region', 'forestry', 'subforestry',  'strip', 'traininng_forestry', 'training_contract_num', 'training_date_start', 'training_date_finish'], 'safe'],
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
        $query = TrainingProcess::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);




        $dataProvider->setSort([
            'defaultOrder' => ['training_date_start'=>SORT_ASC ,'branchName'=>SORT_ASC ,'subjectName'=>SORT_ASC ],
            'attributes' => [
                'branchName' => [
                    'asc' => ['branch.name' => SORT_ASC],
                    'desc' => ['branch.name' => SORT_DESC],
                ],
                'subjectName' => [
                    'asc' => ['federal_subject.name' => SORT_ASC],
                    'desc' => ['federal_subject.name' => SORT_DESC],
                ],
                'forestgrowRegionName' => [
                    'asc' => ['forestgrow_region.name' => SORT_ASC],
                    'desc' => ['forestgrow_region.name' => SORT_DESC],
                ],
                'personFio' => [
                    'asc' => ['training_person.fio' => SORT_ASC],
                    'desc' => ['training_person.fio' => SORT_DESC],
                ],
                'municName' => [
                    'asc' => ['munic_region.name' => SORT_ASC],
                    'desc' => ['munic_region.name' => SORT_DESC],
                ],
                'training_date_start' => [
                    'asc' => ['training_date_start' => SORT_ASC],
                    'desc' => ['training_date_start' => SORT_DESC],
                ],
                'training_date_finish' => [
                    'asc' => ['training_date_finish' => SORT_ASC],
                    'desc' => ['training_date_finish' => SORT_DESC],
                ],
                'training_contract_num' => [
                    'asc' => ['training_contract_num' => SORT_ASC],
                    'desc' => ['training_contract_num' => SORT_DESC],
                ],
            ]
        ]);

        $this->load($params);

//        if (!$this->validate()) {
//            // uncomment the following line if you do not want to return any records when validation fails
//            // $query->where('0=1');
//            return $dataProvider;
//        }

        if (!($this->load($params) && $this->validate())) {
            /**
             * Жадная загрузка данных модели Страны
             * для работы сортировки.
             */
            $query
                ->joinWith(['subject0'])
                ->joinWith(['branch0'])
                ->joinWith(['forestgrowRegion'])
                ->joinWith(['person0'])
                ->joinWith(['munic'])
            ;
            return $dataProvider;
        }


        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'branch' => $this->branch,
            'subject' => $this->subject,
            'forestgrow_region' => $this->forestgrow_region,
            'training_site_amount' => $this->training_site_amount,
            'training_strip_amount' => $this->training_strip_amount,
            'training_date_start' => $this->training_date_start,
            'training_date_finish' => $this->training_date_finish,
            'person' => $this->person,
        ]);


        $query->andFilterWhere(['like', 'munic_region', $this->munic_region])
            ->andFilterWhere(['like', 'forestry', $this->forestry])
            ->andFilterWhere(['like', 'subforestry', $this->subforestry])
            ->andFilterWhere(['like', 'training_contract_num', $this->training_contract_num])
            ->joinWith(['subject0' => function ($q) { $q->where('federal_subject.name LIKE "%' . $this->subjectName . '%"'); }])
            ->joinWith(['branch0' => function ($q) { $q->where('branch.name LIKE "%' . $this->branchName . '%"'); }])
            ->joinWith(['forestgrowRegion' => function ($q) { $q->where('forestgrow_region.name LIKE "%' . $this->forestgrowRegionName . '%"'); }])
            ->joinWith(['person0' => function ($q) { $q->where('training_person.fio LIKE "%' . $this->personFio . '%"'); }])
            ->joinWith(['munic' => function ($q) { $q->where('munic_region.name LIKE "%' . $this->municName . '%"'); }])
        ;

        return $dataProvider;
    }
}
