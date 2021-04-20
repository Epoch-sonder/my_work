<?php

namespace app\modules\pd\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pd\models\VegetPeriod;

/**
 * SearchVegetPeriod represents the model behind the search form of `app\modules\pd\models\VegetPeriod`.
 */
class SearchVegetPeriod extends VegetPeriod
{
    

    public $subjectName;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'subject_id'], 'integer'],
            [['veget_start', 'veget_finish', 'subjectName'], 'safe'],
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
        $query = VegetPeriod::find();

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
            'subject_id' => $this->subject_id,
            'veget_start' => $this->veget_start,
            'veget_finish' => $this->veget_finish,
        ]);

        return $dataProvider;
    }
}
