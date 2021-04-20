<?php

namespace app\modules\audit\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\audit\models\AuditUnscheduled;

/**
 * SearchAuditUnscheduled represents the model behind the search form of `app\modules\audit\models\AuditUnscheduled`.
 */
class SearchAuditUnscheduled extends AuditUnscheduled
{
    /**
     * {@inheritdoc}
     */
    public $branchName;
    public $fedSubjectName;

    public function rules()
    {
        return [
            [['id', 'subject', 'branch'], 'integer'],
            [['fio', 'date_start','branchName', 'date_finish','fedSubjectName','comment' ,'proposal'], 'safe'],
            [['participation_cost'], 'number'],
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
        $query = AuditUnscheduled::find();

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
                'fio' => [
                    'asc' => ['fio' => SORT_ASC],
                    'desc' => ['fio' => SORT_DESC],
                ],
                'participation_cost' => [
                    'asc' => ['participation_cost' => SORT_ASC],
                    'desc' => ['participation_cost' => SORT_DESC],
                ],
                'comment' => [
                    'asc' => ['comment' => SORT_ASC],
                    'desc' => ['comment' => SORT_DESC],
                ],
                'proposal' => [
                    'asc' => ['proposal' => SORT_ASC],
                    'desc' => ['proposal' => SORT_DESC],
                ],
                'branchName' => [
                    'asc' => ['branch.name' => SORT_ASC],
                    'desc' => ['branch.name' => SORT_DESC],
                ],
                'fedSubjectName' => [
                    'asc' => ['federal_subject.name' => SORT_ASC],
                    'desc' => ['federal_subject.name' => SORT_DESC],
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
                ->joinWith(['fedSubject'])
            ;
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'subject' => $this->subject,
            'branch' => $this->branch,
            'date_start' => $this->date_start,
            'date_finish' => $this->date_finish,
            'participation_cost' => $this->participation_cost,
            'comment' => $this->comment,
            'proposal' => $this->proposal,
        ]);

        $query->andFilterWhere(['like', 'fio', $this->fio])
            ->joinWith(['fedSubject' => function ($q) { $q->where('federal_subject.name LIKE "%' . $this->fedSubjectName . '%"'); }])
            ->joinWith(['branchID' => function ($q) { $q->where('branch.name LIKE "%' . $this->branchName . '%"'); }]);

        return $dataProvider;
    }
}
