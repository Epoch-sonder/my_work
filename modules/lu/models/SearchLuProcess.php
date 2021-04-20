<?php

namespace app\modules\lu\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\lu\models\LuProcess;

/**
 * SearchLuProcess represents the model behind the search form of `app\modules\lu\models\LuProcess`.
 */
class SearchLuProcess extends LuProcess
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'lu_zakup_card', 'step_process', 'reporter'], 'integer'],
            [['person_responsible', 'mtr', 'date_finish', 'timestamp'], 'safe'],
            [['volume', 'staff'], 'number'],
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
        $query = LuProcess::find();

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
            'lu_zakup_card ' => $this->lu_zakup_card,
            'step_process' => $this->step_process,
            'volume' => $this->volume,
            'staff' => $this->staff,
            'date_finish' => $this->date_finish,
            'reporter' => $this->reporter,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'person_responsible', $this->person_responsible])
            ->andFilterWhere(['like', 'mtr', $this->mtr]);

        return $dataProvider;
    }
}
