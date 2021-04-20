<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CaCurator;

/**
 * SearchCaCurator represents the model behind the search form of `app\models\CaCurator`.
 */
class SearchCaCurator extends CaCurator
{
    /**
     * {@inheritdoc}
     */

    public $branchName;
    public $personName;

    public function rules()
    {
        return [
            [['id', 'branch_kod', 'person_kod', 'comment'], 'integer'],
            [['branchName', 'personName'], 'safe'],
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
        $query = CaCurator::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'branchName' => [
                    'asc' => ['branch.name' => SORT_ASC],
                    'desc' => ['branch.name' => SORT_DESC],
                ],
                'personName' => [
                    'asc' => ['user.fio' => SORT_ASC],
                    'desc' => ['user.fio' => SORT_DESC],
                ],
                'comment' => [
                    'asc' => ['comment' => SORT_ASC],
                    'desc' => ['comment' => SORT_DESC],
                ],
            ]
        ]);

        $this->load($params);

//        if (!$this->validate()) {
//            // uncomment the following line if you do not want to return any records when validation fails
//            // $query->where('0=1');
//            return $dataProvider;
//        }

        // grid filtering conditions
        if (!($this->load($params) && $this->validate())) {
            /**
             * Жадная загрузка данных модели Страны
             * для работы сортировки.
             */
            $query
                ->joinWith(['branchKod'])
                ->joinWith(['personKod'])
            ;
            return $dataProvider;
        }

        // grid filtering conditions
        $query
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->joinWith(['branchKod' => function ($q) { $q->where('branch.name LIKE "%' . $this->branchName . '%"'); }])
            ->joinWith(['personKod' => function ($q) { $q->where('user.fio LIKE "%' . $this->personName . '%"'); }]);

        return $dataProvider;
    }
}
