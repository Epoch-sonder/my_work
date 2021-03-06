<?php

namespace app\modules\lu\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\lu\models\LuPhase;

/**
 * SearchLuPhase represents the model behind the search form of `app\modules\lu\models\LuPhase`.
 */
class SearchLuPhase extends LuPhase
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sort_order'], 'integer'],
            [['phase_name', 'phase_number'], 'safe'],
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
        $query = LuPhase::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['sort_order' => SORT_ASC]]
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
            'sort_order' => $this->sort_order,
        ]);

        $query->andFilterWhere(['like', 'phase_name', $this->phase_name])
            ->andFilterWhere(['like', 'phase_number', $this->phase_number]);

        return $dataProvider;
    }
}
