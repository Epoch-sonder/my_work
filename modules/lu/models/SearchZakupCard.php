<?php

namespace app\modules\lu\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\lu\models\ZakupCard;

/**
 * SearchZakupCard represents the model behind the search form of `app\modules\lu\models\ZakupCard`.
 */
class SearchZakupCard extends ZakupCard
{
    
    public $finsourceName;
    public $fedSubjectName;
    public $contractTypeName;
    public $landCatName;
    public $contestTypeName;
    public $dzzTypeName;
    public $dzzRequestSent;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'contest_type', 'contract_type', 'finsource_type', 'land_cat', 'fed_subject', 'dzz_type', 'dzz_request_sent', 'smp_attraction'], 'integer'],
            [['zakup_num', 'zakup_link', 'date_placement', 'customer_name', 'region', 'region_subdiv', 'timestamp', 'finsourceName', 'contract_num', 'fedSubjectName', 'contractTypeName', 'landCatName', 'contestTypeName', 'dzzTypeName', 'dzzRequestSent', 'dzz_control_date'], 'safe'],
            [['price_start', 'dzz_resolution', 'dzz_cost'], 'number'],
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
        $query = ZakupCard::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $dataProvider->setSort([
            'defaultOrder' => ['date_placement'=>SORT_DESC],
            'attributes' => [
                'fedSubjectName' => [
                    'asc' => ['federal_subject.name' => SORT_ASC],
                    'desc' => ['federal_subject.name' => SORT_DESC],
                ],
                'contractTypeName' => [
                    'asc' => ['contract_type.name' => SORT_ASC],
                    'desc' => ['contract_type.name' => SORT_DESC],
                ],
                'contestTypeName' => [
                    'asc' => ['contest_type.name' => SORT_ASC],
                    'desc' => ['contest_type.name' => SORT_DESC],
                ],
                'zakup_num' => [
                    'asc' => ['zakup_num' => SORT_ASC],
                    'desc' => ['zakup_num' => SORT_DESC],
                ],
                'price_start' => [
                    'asc' => ['price_start' => SORT_ASC],
                    'desc' => ['price_start' => SORT_DESC],
                ],
                'date_placement' => [
                    'asc' => ['date_placement' => SORT_ASC],
                    'desc' => ['date_placement' => SORT_DESC],
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
            /*** Жадная загрузка данных модели Страны для работы сортировки. */
            $query
                ->joinWith(['fedSubject'])
                ->joinWith(['contractType'])
                ->joinWith(['contestType'])
                ;
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'contest_type' => $this->contest_type,
            'date_placement' => $this->date_placement,
            'price_start' => $this->price_start,
            'contract_type' => $this->contract_type,
            'contract_num' => $this->contract_num,
            'finsource_type' => $this->finsource_type,
            'land_cat' => $this->land_cat,
            'fed_subject' => $this->fed_subject,
            'dzz_type' => $this->dzz_type,
            'dzz_resolution' => $this->dzz_resolution,
            'dzz_request_sent' => $this->dzz_request_sent,
            'dzz_cost' => $this->dzz_cost,
            'smp_attraction' => $this->smp_attraction,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'zakup_num', $this->zakup_num])
            ->andFilterWhere(['like', 'zakup_link', $this->zakup_link])
            ->andFilterWhere(['like', 'customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'region', $this->region])
            ->andFilterWhere(['like', 'region_subdiv', $this->region_subdiv])
            ->andFilterWhere(['like', 'dzzTypeName', $this->dzzTypeName])
            ->joinWith(['fedSubject' => function ($q) { $q->where('federal_subject.name LIKE "%' . $this->fedSubjectName . '%"'); }])
            ->joinWith(['contractType' => function ($q) { $q->where('contract_type.name LIKE "%' . $this->contractTypeName . '%"'); }])
            ->joinWith(['contestType' => function ($q) { $q->where('contest_type.name LIKE "%' . $this->contestTypeName . '%"'); }])
            ;

        return $dataProvider;
    }
}
