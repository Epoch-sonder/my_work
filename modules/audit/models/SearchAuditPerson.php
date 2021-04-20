<?php

namespace app\modules\audit\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\audit\models\AuditPerson;

/**
 * SearchAuditPerson represents the model behind the search form of `app\modules\audit\models\AuditPerson`.
 */
class SearchAuditPerson extends AuditPerson
{
    /**
     * {@inheritdoc}
     */
    public $branchName;

    public function rules()
    {
        return [
            [['id', 'branch'], 'integer'],
            [['fio', 'position', 'branchName','phone','email'], 'safe'],
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
        $query = AuditPerson::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // if (!($this->load($params) && $this->validate())) {
        //     *
        //      * Жадная загрузка данных модели Страны
        //      * для работы сортировки.
             
        //     $query
        //         ->joinWith(['branch'])
        //         ;
        //     return $dataProvider;
        // }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'branch' => $this->branch,
        ]);

        $query->andFilterWhere(['like', 'fio', $this->fio])
            ->andFilterWhere(['like', 'position', $this->position])
            ->joinWith(['branch0' => function ($q) { $q->where('branch.name LIKE "%' . $this->branchName . '%"'); }])
            ;

        return $dataProvider;
    }
}
