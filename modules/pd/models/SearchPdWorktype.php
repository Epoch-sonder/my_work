<?php

namespace app\modules\pd\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pd\models\PdWorktype;

/**
 * SearchPdWorktype represents the model behind the search form of `app\modules\pd\models\PdWorktype`.
 */
class SearchPdWorktype extends PdWorktype
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'average_cost', 'average_humanday'], 'integer'],
            [['work_name'], 'safe'],
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
        $query = PdWorktype::find();

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
            'average_cost' => $this->average_cost,
            'average_humanday' => $this->average_humanday,
        ]);

        $query->andFilterWhere(['like', 'work_name', $this->work_name]);

        return $dataProvider;
    }
}
