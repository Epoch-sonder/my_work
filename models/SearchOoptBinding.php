<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OoptBinding;

/**
 * SearchOoptBinding represents the model behind the search form of `app\models\OoptBinding`.
 */
class SearchOoptBinding extends OoptBinding
{
    /**
     * {@inheritdoc}
     */
    public $subjectName;
    public $ooptName;
    public $municName;


    public function rules()
    {
        return [
            [['id', 'oopt', 'subject', 'munic'], 'integer'],
            [['subjectName', 'ooptName', 'municName'], 'save'],
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
        $query = OoptBinding::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
//            'defaultOrder' => ['oopt.oopt_name'=>SORT_ASC],
            'attributes' => [
                'ooptName' => [
                    'asc' => ['oopt.oopt_name' => SORT_ASC],
                    'desc' => ['oopt.oopt_name' => SORT_DESC],
                ],
                'subjectName' => [
                    'asc' => ['federal_subject.name' => SORT_ASC],
                    'desc' => ['federal_subject.name' => SORT_DESC],
                ],
                'municName' => [
                    'asc' => ['munic_region.name' => SORT_ASC],
                    'desc' => ['munic_region.name' => SORT_DESC],
                ],
            ],
        ]);

        $this->load($params);

//        if (!$this->validate()) {
//            // uncomment the following line if you do not want to return any records when validation fails
//            // $query->where('0=1');
//            return $dataProvider;
//        }
//        if (!($this->load($params) && $this->validate())) {
//            /**
//             * Жадная загрузка данных модели Страны
//             * для работы сортировки.
//             */
//            $query
////                ->joinWith(['oopt0'])
////                ->joinWith(['subject0'])
////                ->joinWith(['munic0'])
//            ;
//            return $dataProvider;
//        }

        // grid filtering conditions
//        $query->andFilterWhere([
//            'id' => $this->id,
//            'oopt' => $this->oopt,
//            'subject' => $this->subject,
//            'munic' => $this->munic,
//        ]);
        $query->andFilterWhere(['like', 'id', $this->id])
            ->joinWith(['oopt0' => function ($q) { $q->where('oopt.oopt_name LIKE "%' . $this->ooptName . '%"'); }])
            ->joinWith(['subject0' => function ($q) { $q->where('federal_subject.name LIKE "%' . $this->subjectName . '%"'); }])
            ->joinWith(['munic0' => function ($q) { $q->where('munic_region.name LIKE "%' . $this->municName . '%"'); }])
            ;

        return $dataProvider;
    }
}
