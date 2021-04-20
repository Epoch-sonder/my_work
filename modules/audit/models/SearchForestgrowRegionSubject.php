<?php

namespace app\modules\audit\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\audit\models\ForestgrowRegionSubject;

/**
 * SearchForestgrowRegionSubject represents the model behind the search form of `app\modules\audit\models\ForestgrowRegionSubject`.
 */
class SearchForestgrowRegionSubject extends ForestgrowRegionSubject
{
    /**
     * {@inheritdoc}
     */
    public $subjectName;
    public $regionName;


    public function rules()
    {
        return [
            [['id', 'region_id', 'subject_id' ], 'integer'],
            [['subjectName','regionName'], 'safe'],
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
        $query = ForestgrowRegionSubject::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'subjectName' => [
                    'asc' => ['federal_subject.name' => SORT_ASC],
                    'desc' => ['federal_subject.name' => SORT_DESC],
                ],
                'regionName' => [
                    'asc' => ['forestgrow_region.name' => SORT_ASC],
                    'desc' => ['forestgrow_region.name' => SORT_DESC],
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
                ->joinWith(['subject'])
                ->joinWith(['region'])

            ;
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'region_id' => $this->region_id,
            'subject_id' => $this->subject_id,
        ]);
        $query->joinWith(['subject' => function ($q) { $q->where('federal_subject.name LIKE "%' . $this->subjectName . '%"'); }])
            ->joinWith(['region' => function ($q) { $q->where('forestgrow_region.name LIKE "%' . $this->regionName . '%"'); }]);


        return $dataProvider;
    }
}
