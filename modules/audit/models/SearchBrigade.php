<?php

namespace app\modules\audit\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\audit\models\Brigade;

/**
 * SearchBrigade represents the model behind the search form of `app\modules\audit\models\Brigade`.
 */
class SearchBrigade extends Brigade
{
    /**
     * {@inheritdoc}
     */
    public $branchName;
    public $subjectName;
    public $forestgrowRegionName;



    public function rules()
    {
        return [
            [['id', 'branch', 'subject', 'object_work', 'brigade_number'], 'integer'],
            [['contract', 'date_begin', 'person', 'remark','branchName','subjectName','forestgrowRegionName'], 'safe'],
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
        $query = Brigade::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['date_begin'=>SORT_ASC],
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
                'object_work' => [
                    'asc' => ['object_work' => SORT_ASC],
                    'desc' => ['contract' => SORT_DESC],
                ],
                'contract' => [
                    'asc' => ['contract' => SORT_ASC],
                    'desc' => ['date_begin' => SORT_DESC],
                ],
                'date_begin' => [
                    'asc' => ['date_begin' => SORT_ASC],
                    'desc' => ['brigade_number' => SORT_DESC],
                ],
                'brigade_number' => [
                    'asc' => ['brigade_number' => SORT_ASC],
                    'desc' => ['person' => SORT_DESC],
                ],
                'person' => [
                    'asc' => ['person' => SORT_ASC],
                    'desc' => ['remark.type' => SORT_DESC],
                ],
                'remark' => [
                    'asc' => ['remark' => SORT_ASC],
                    'desc' => ['' => SORT_DESC],
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
                ->joinWith(['forestgrowRegion'])
                ->joinWith(['subject0'])
            ;
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'branch' => $this->branch,
            'subject' => $this->subject,
            'object_work' => $this->object_work,
            'date_begin' => $this->date_begin,
            'brigade_number' => $this->brigade_number,
        ]);

        $query->andFilterWhere(['like', 'contract', $this->contract])
            ->andFilterWhere(['like', 'person', $this->person])
            ->andFilterWhere(['like', 'remark', $this->remark]);

        $query
            ->joinWith(['branch0' => function ($q) { $q->where('branch.name LIKE "%' . $this->branchName . '%"'); }])
            ->joinWith(['forestgrowRegion' => function ($q) { $q->where('forestgrow_region.name LIKE "%' . $this->forestgrowRegionName . '%"'); }])
            ->joinWith(['subject0' => function ($q) { $q->where('federal_subject.name LIKE "%' . $this->subjectName . '%"'); }])
        ;
        return $dataProvider;
    }
}
