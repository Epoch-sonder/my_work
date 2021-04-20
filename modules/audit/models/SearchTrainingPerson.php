<?php

namespace app\modules\audit\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\audit\models\TrainingPerson;

/**
 * SearchTrainingPerson represents the model behind the search form of `app\modules\audit\models\TrainingPerson`.
 */
class SearchTrainingPerson extends TrainingPerson
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['fio', 'position', 'workplace_rli', 'workplace_other'], 'safe'],
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
        $query = TrainingPerson::find();

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
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'fio', $this->fio])
            ->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'workplace_rli', $this->workplace_rli])
            ->andFilterWhere(['like', 'workplace_other', $this->workplace_other]);

        return $dataProvider;
    }
}
