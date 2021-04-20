<?php

namespace app\modules\audit\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\audit\models\AuditRevision;

/**
 * SearchAuditRevision represents the model behind the search form of `app\modules\audit\models\AuditRevision`.
 */
class SearchAuditRevision extends AuditRevision
{
    /**
     * {@inheritdoc}
     */
    public $branchName;

    public function rules()
    {
        return [
            [['id', 'branch'], 'integer'],
            [['inspectorate', 'fio', 'date_start', 'date_finish','branchName','comment' ,'proposal'], 'safe'],
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
        $query = AuditRevision::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['date_start'=>SORT_ASC],
            'attributes' => [
                'date_start' => [
                    'asc' => ['date_start' => SORT_ASC],
                    'desc' => ['date_start' => SORT_DESC],
                ],
                'date_finish' => [
                    'asc' => ['date_finish' => SORT_ASC],
                    'desc' => ['date_finish' => SORT_DESC],
                ],
                'inspectorate' => [
                    'asc' => ['inspectorate' => SORT_ASC],
                    'desc' => ['inspectorate' => SORT_DESC],
                ],
                'fio' => [
                    'asc' => ['fio' => SORT_ASC],
                    'desc' => ['fio' => SORT_DESC],
                ],
                'branchName' => [
                    'asc' => ['branch.name' => SORT_ASC],
                    'desc' => ['branch.name' => SORT_DESC],
                ],
                'comment' => [
                    'asc' => ['comment' => SORT_ASC],
                    'desc' => ['comment' => SORT_DESC],
                ],
                'proposal' => [
                    'asc' => ['proposal' => SORT_ASC],
                    'desc' => ['proposal' => SORT_DESC],
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
                ->joinWith(['branchID'])
            ;
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'branch' => $this->branch,
            'date_start' => $this->date_start,
            'date_finish' => $this->date_finish,
            'comment' => $this->comment,
            'proposal' => $this->proposal,
        ]);

        $query->andFilterWhere(['like', 'inspectorate', $this->inspectorate])
            ->andFilterWhere(['like', 'fio', $this->fio])
//            ->joinWith(['fedSubject' => function ($q) { $q->where('federal_subject.name LIKE "%' . $this->fedSubjectName . '%"'); }])
            ->joinWith(['branchID' => function ($q) { $q->where('branch.name LIKE "%' . $this->branchName . '%"'); }])
        ;


        return $dataProvider;
    }
}
