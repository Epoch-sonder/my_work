<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\NsiInfo;

/**
 * SearchNsiInfo represents the model behind the search form of `app\models\NsiInfo`.
 */
class SearchNsiInfo extends NsiInfo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['soli_id', 'maket_numb', 'pole_numb', 'pl'], 'integer'],
            [['attr_name', 'winplp', 'topol'], 'safe'],
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
        $query = NsiInfo::find();

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
            'soli_id' => $this->soli_id,
            'maket_numb' => $this->maket_numb,
            'pole_numb' => $this->pole_numb,
            'pl' => $this->pl,
        ]);

        $query->andFilterWhere(['like', 'attr_name', $this->attr_name])
            ->andFilterWhere(['like', 'winplp', $this->winplp])
            ->andFilterWhere(['like', 'topol', $this->topol]);

        return $dataProvider;
    }
}
