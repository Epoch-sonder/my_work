<?php

namespace app\modules\audit\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\audit\models\MunicRegion;

/**
 * SearchMunicRegion represents the model behind the search form of `app\modules\audit\models\MunicRegion`.
 */
class SearchMunicRegion extends MunicRegion
{
    /**
     * {@inheritdoc}
     */
    public $forestgrowRegionName;
    public $federalSubjectName;

    public function rules()
    {
        return [
            [['id', 'federal_subject', 'forestgrow_region'], 'integer'],
            [['name','federalSubjectName','forestgrowRegionName','full_name'], 'safe'],
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
        $query = MunicRegion::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            // 'defaultOrder' => ['basedoc_datefinish'=>SORT_ASC],
            'attributes' => [
                // 'id',
                // 'federalSubjectName' => [
                //     'asc' => ['federal_subject.name' => SORT_ASC],
                //     'desc' => ['federal_subject.name' => SORT_DESC],
                // ],

                'federalSubjectName' => [
                    'asc' => ['federal_subject.name' => SORT_ASC],
                    'desc' => ['federal_subject.name' => SORT_DESC],
                    // 'label' => ''
                ],
                'forestgrowRegionName' => [
                    'asc' => ['forestgrow_region.name' => SORT_ASC],
                    'desc' => ['forestgrow_region.name' => SORT_DESC],
                ],
                'name' => [
                    'asc' => ['name' => SORT_ASC],
                    'desc' => ['name' => SORT_DESC],
                ],
                'full_name' => [
                    'asc' => ['full_name' => SORT_ASC],
                    'desc' => ['full_name' => SORT_DESC],
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
            /*** Жадная загрузка данных модели Страны для работы сортировки.  */
            $query
                // ->joinWith(['federalSubject'])
                ->joinWith(['federalSubject'])
                ->joinWith(['forestgrowRegion'])
            ;
            return $dataProvider;
        }


        // grid filtering conditions
//        $query
//            ->andFilterWhere([
//            'name' => $this->name,
//
//        ]);

        $query->andFilterWhere(['like', 'munic_region.name', $this->name])
            ->andFilterWhere(['like', 'munic_region.full_name', $this->full_name])
            ->joinWith(['federalSubject' => function ($q) { $q->where('federal_subject.name LIKE "%' . $this->federalSubjectName . '%"'); }])
            ->joinWith(['forestgrowRegion' => function ($q) { $q->where('forestgrow_region.name LIKE "%' . $this->forestgrowRegionName . '%"'); }]);

        return $dataProvider;
    }
}
