<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ResponsibilityArea;

/**
 * SearchResponsibilityArea represents the model behind the search form of `app\models\ResponsibilityArea`.
 */
class SearchResponsibilityArea extends ResponsibilityArea
{


    public $branchName;
    public $federalSubjectName;
    public $invert;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['responsibility_area_id', 'federal_subject_id', 'branch_id', 'with_order'], 'integer'],
            [['branchName', 'federalSubjectName', 'invert'], 'safe'],
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
        $query = ResponsibilityArea::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);



        $dataProvider->setSort([
            'defaultOrder' => ['federalSubjectName'=>SORT_ASC],
            'attributes' => [
                'federal_subject_id',
                'branch_id',
                'with_order',
                'federalSubjectName' => [
                    'asc' => ['federal_subject.name' => SORT_ASC],
                    'desc' => ['federal_subject.name' => SORT_DESC],
                ],
                'branchName' => [
                    'asc' => ['branch.name' => SORT_ASC],
                    'desc' => ['branch.name' => SORT_DESC],
                ],
            ]
        ]);


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // if (!($this->load($params) && $this->validate())) {
            /* Жадная загрузка данных модели Страны для работы сортировки. */
        //     $query
        //         ->joinWith(['branch'])
        //         ->joinWith(['federalSubject']);
        //     return $dataProvider;
        // }


        // grid filtering conditions
        $query->andFilterWhere([
            'responsibility_area_id' => $this->responsibility_area_id,
            'federal_subject_id' => $this->federal_subject_id,
            'branch_id' => $this->branch_id,
            'with_order' => $this->with_order,
            'invert' => $this->invert,
        ])
        
        ->joinWith(['branch' => function ($q) { $q->where('branch.name LIKE "%' . $this->branchName . '%"'); }])
        ->joinWith(['federalSubject' => function ($q) { $q->where('federal_subject.name LIKE "%' . $this->federalSubjectName . '%"'); }])
        ;

        return $dataProvider;
    }
}
