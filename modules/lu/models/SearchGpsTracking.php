<?php

namespace app\modules\lu\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\lu\models\GpsTracking;

/**
 * SearchGpsTracking represents the model behind the search form of `app\modules\lu\models\GpsTracking`.
 */
class SearchGpsTracking extends GpsTracking
{
    /**
     * {@inheritdoc}
     *
     */
    public $branchName;
    public $contractName;
    public $specialistName;
    public $partyLeaderName;

    public function rules()
    {
        return [
            [['id', 'branch', 'contract', 'specialist', 'april_check', 'may_check', 'june_check', 'july_check', 'august_check', 'september_check', 'october_check', 'november_check', 'party_leader', 'fio_responsible'], 'integer'],
            [['branchName','contractName','specialistName','partyLeaderName', 'april_recd', 'may_recd', 'june_recd', 'july_recd', 'august_recd', 'september_recd', 'october_recd', 'november_recd', 'date_create'], 'safe'],
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
        $query = GpsTracking::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
//            'defaultOrder' => ['training_date_start'=>SORT_ASC ,'branchName'=>SORT_ASC ,'subjectName'=>SORT_ASC ],
            'attributes' => [
                'branchName' => [
                    'asc' => ['branch.name' => SORT_ASC],
                    'desc' => ['branch.name' => SORT_DESC],
                ],
                'contractName' => [
                    'asc' => ['lu_zakup_card.zakup_num' => SORT_ASC],
                    'desc' => ['lu_zakup_card.zakup_num' => SORT_DESC],
                ],
                'specialistName' => [
                    'asc' => ['branch_person.fio' => SORT_ASC],
                    'desc' => ['branch_person.fio' => SORT_DESC],
                ],
                'partyLeaderName' => [
                    'asc' => ['branch_person.fio' => SORT_ASC],
                    'desc' => ['branch_person.fio' => SORT_DESC],
                ],
                'april_recd' => [
                    'asc' => ['april_recd' => SORT_ASC],
                    'desc' => ['april_recd' => SORT_DESC],
                ],
                'may_recd' => [
                    'asc' => ['may_recd' => SORT_ASC],
                    'desc' => ['may_recd' => SORT_DESC],
                ],
                'june_recd' => [
                    'asc' => ['june_recd' => SORT_ASC],
                    'desc' => ['june_recd' => SORT_DESC],
                ],
                'july_recd' => [
                    'asc' => ['july_recd' => SORT_ASC],
                    'desc' => ['july_recd' => SORT_DESC],
                ],
                'august_recd' => [
                    'asc' => ['august_recd' => SORT_ASC],
                    'desc' => ['august_recd' => SORT_DESC],
                ],
                'september_recd' => [
                    'asc' => ['september_recd' => SORT_ASC],
                    'desc' => ['september_recd' => SORT_DESC],
                ],
                'october_recd' => [
                    'asc' => ['october_recd' => SORT_ASC],
                    'desc' => ['october_recd' => SORT_DESC],
                ],
                'november_recd' => [
                    'asc' => ['november_recd' => SORT_ASC],
                    'desc' => ['november_recd' => SORT_DESC],
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
                ->joinWith(['branch0'])
                ->joinWith(['contract0'])
                ->joinWith(['specialist0'])
                ->joinWith(['partyLeader0'])
            ;
            return $dataProvider;
        }
//
//        // grid filtering conditions
//        $query->andFilterWhere([
//            'id' => $this->id,
//            'branch' => $this->branch,
//            'contract' => $this->contract,
//            'specialist' => $this->specialist,
////            'april_recd' => $this->april_recd,
//            'april_check' => $this->april_check,
//            'may_check' => $this->may_check,
//            'june_check' => $this->june_check,
//            'july_check' => $this->july_check,
//            'august_check' => $this->august_check,
//            'september_check' => $this->september_check,
//            'october_check' => $this->october_check,
//            'november_check' => $this->november_check,
//            'party_leader' => $this->party_leader,
//            'fio_responsible' => $this->fio_responsible,
//            'date_create' => $this->date_create,
//        ]);

        $query->andFilterWhere(['like', 'munic_region', $this->april_recd])
            ->andFilterWhere(['like', 'munic_region', $this->may_recd])
            ->andFilterWhere(['like', 'munic_region', $this->june_recd])
            ->andFilterWhere(['like', 'munic_region', $this->july_recd])
            ->andFilterWhere(['like', 'munic_region', $this->august_recd])
            ->andFilterWhere(['like', 'munic_region', $this->september_recd])
            ->andFilterWhere(['like', 'munic_region', $this->october_recd])
            ->andFilterWhere(['like', 'munic_region', $this->november_recd])
            ->joinWith(['branch0' => function ($q) { $q->where('branch.name LIKE "%' . $this->branchName . '%"'); }])
            ->joinWith(['contract0' => function ($q) { $q->where('lu_zakup_card.zakup_num LIKE "%' . $this->contractName . '%"'); }])
            ->joinWith(['specialist0' => function ($q) { $q->where('branch_person.fio LIKE "%' . $this->specialistName . '%"'); }])
            ->joinWith(['partyLeader0' => function ($q) { $q->where('branch_person.fio LIKE "%' . $this->partyLeaderName . '%"'); }])
        ;

        return $dataProvider;
    }
}
