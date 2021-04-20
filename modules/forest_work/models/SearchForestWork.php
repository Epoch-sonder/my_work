<?php

namespace app\modules\forest_work\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\forest_work\models\ForestWork;

/**
 * SearchForestWork represents the model behind the search form of `app\modules\forest_work\models\ForestWork`.
 */
class SearchForestWork extends ForestWork
{
    
    public $fedSubjectName;
    public $branchName;
    public $reporterName;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'branch_id', 'federal_subject_id', 'reporter', 'a1', 'a2', 'a3', 'a4', 'a5', 'a6', 'a7', 'a8', 'a9', 'a10', 'a11', 'a12', 'a13', 'a14', 'a15', 'a16', 'a17', 'b1', 'b2', 'b3', 'b4', 'b5', 'b6', 'b7', 'b8', 'b9', 'b10', 'b11', 'b12', 'b13', 'b14', 'b15', 'b16', 'b17'], 'integer'],
            [['date', 'timestamp', 'fedSubjectName', 'branchName', 'reporterName'], 'safe'],
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
        $query = ForestWork::find();

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $dataProvider->setSort([
            
            'attributes' => [
                'id' => [
                    'asc' => ['id' => SORT_ASC],
                    'desc' => ['id' => SORT_DESC],
                ],
                'date' => [
                    'asc' => ['date' => SORT_ASC],
                    'desc' => ['date' => SORT_DESC],
                ],
                'fedSubjectName' => [
                    'asc' => ['federal_subject.name' => SORT_ASC],
                    'desc' => ['federal_subject.name' => SORT_DESC],
                ],
                'branchName' => [
                    'asc' => ['branch.name' => SORT_ASC],
                    'desc' => ['branch.name' => SORT_DESC],
                ],
                'reporterName' => [
                    'asc' => ['user.fio' => SORT_ASC],
                    'desc' => ['user.fio' => SORT_DESC],
                ],
            ],


            'defaultOrder' => [
                    'date' => SORT_DESC,
                    'id' => SORT_DESC,
            ],
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
                ->joinWith(['federalSubject'])
                ->joinWith(['branch'])
                ->joinWith(['user'])
                ;
            return $dataProvider;
        }

        // grid filtering conditions
        // $query->andFilterWhere([
            // 'id' => $this->id,
            // 'branch_id' => $this->branch_id,
            // 'federal_subject_id' => $this->federal_subject_id,
            // 'date' => $this->date,
            // 'reporter' => $this->reporter,
            // 'a1' => $this->a1,
            // 'a2' => $this->a2,
            // 'a3' => $this->a3,
            // 'a4' => $this->a4,
            // 'a5' => $this->a5,
            // 'a6' => $this->a6,
            // 'a7' => $this->a7,
            // 'a8' => $this->a8,
            // 'a9' => $this->a9,
            // 'a10' => $this->a10,
            // 'a11' => $this->a11,
            // 'a12' => $this->a12,
            // 'a13' => $this->a13,
            // 'a14' => $this->a14,
            // 'a15' => $this->a15,
            // 'a16' => $this->a16,
            // 'a17' => $this->a17,
            // 'b1' => $this->b1,
            // 'b2' => $this->b2,
            // 'b3' => $this->b3,
            // 'b4' => $this->b4,
            // 'b5' => $this->b5,
            // 'b6' => $this->b6,
            // 'b7' => $this->b7,
            // 'b8' => $this->b8,
            // 'b9' => $this->b9,
            // 'b10' => $this->b10,
            // 'b11' => $this->b11,
            // 'b12' => $this->b12,
            // 'b13' => $this->b13,
            // 'b14' => $this->b14,
            // 'b15' => $this->b15,
            // 'b16' => $this->b16,
            // 'b17' => $this->b17,
            // 'timestamp' => $this->timestamp,
        // ]);

        $query
            ->andFilterWhere(['like', 'forest_work.id', $this->id])
            ->andFilterWhere(['like', 'date', $this->date])
            ->joinWith(['federalSubject' => function ($q) { $q->where('federal_subject.name LIKE "%' . $this->fedSubjectName . '%"'); }])
            ->joinWith(['branch' => function ($q) { $q->where('branch.name LIKE "%' . $this->branchName . '%"'); }])
            ->joinWith(['user' => function ($q) { $q->where('user.fio LIKE "%' . $this->reporterName . '%"'); }])
            ;

        return $dataProvider;
    }
}
