<?php

namespace app\modules\forest_work\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\forest_work\models\ForestWorkReporter;

/**
 * SearchForestWorkReporter represents the model behind the search form of `app\modules\forest_work\models\ForestWorkReporter`.
 */
class SearchForestWorkReporter extends ForestWorkReporter
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reporter_id', 'reporter_tel', 'reporter_branch'], 'integer'],
            [['reporter_fio', 'reporter_position'], 'safe'],
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
        $query = ForestWorkReporter::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'reporter_id' => $this->reporter_id,
            'reporter_tel' => $this->reporter_tel,
            'reporter_branch' => $this->reporter_branch,
        ]);

        $query->andFilterWhere(['like', 'reporter_fio', $this->reporter_fio])
            ->andFilterWhere(['like', 'reporter_position', $this->reporter_position]);

        return $dataProvider;
    }
}
