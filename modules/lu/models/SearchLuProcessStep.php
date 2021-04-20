<?php

namespace app\modules\lu\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\lu\models\LuProcessStep;

/**
 * SearchLuProcessStep represents the model behind the search form of `app\modules\lu\models\LuProcessStep`.
 */
class SearchLuProcessStep extends LuProcessStep
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'step_phase', 'max_duration', 'sort_order'], 'integer'],
            [['step_name', 'step_number'], 'safe'],
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
        $query = LuProcessStep::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['sort_order' => SORT_ASC],

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
            'step_phase' => $this->step_phase,
            'max_duration' => $this->max_duration,
            'sort_order' => $this->sort_order,
        ]);

        $query->andFilterWhere(['like', 'step_name', $this->step_name])
            ->andFilterWhere(['like', 'step_number', $this->step_number]);

        return $dataProvider;
    }
}
