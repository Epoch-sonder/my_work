<?php

namespace app\modules\lu\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\lu\models\Vaccination;

/**
 * SearchVaccination represents the model behind the search form of `app\modules\lu\models\Vaccination`.
 */
class SearchVaccination extends Vaccination
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'person_id', 'url_docs', 'verified'], 'integer'],
            [['first_vaccination', 'second_vaccination', 'third_vaccination'], 'safe'],
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
        $query = Vaccination::find();

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
            'person_id' => $this->person_id,
            'first_vaccination' => $this->first_vaccination,
            'second_vaccination' => $this->second_vaccination,
            'third_vaccination' => $this->third_vaccination,
            'url_docs' => $this->url_docs,
            'verified' => $this->verified,
        ]);

        return $dataProvider;
    }
}
