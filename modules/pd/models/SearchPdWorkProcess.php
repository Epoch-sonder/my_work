<?php

namespace app\modules\pd\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pd\models\PdWorkProcess;

/**
 * SearchPdWorkProcess represents the model behind the search form of `app\modules\pd\models\PdWorkProcess`.
 */
class SearchPdWorkProcess extends PdWorkProcess
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pd_work', 'pd_step', 'person_responsible'], 'integer'],
            [['pd_object', 'report_date', 'step_startplan', 'step_finishplan', 'progress_status', 'comment', 'resultdoc_name', 'resultdoc_num', 'resultdoc_date', 'resultdoc_file', 'timestamp'], 'safe'],
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
        $query = PdWorkProcess::find();

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
            'pd_work' => $this->pd_work,
            'report_date' => $this->report_date,
            'pd_step' => $this->pd_step,
            'step_startplan' => $this->step_startplan,
            'step_finishplan' => $this->step_finishplan,
            'resultdoc_date' => $this->resultdoc_date,
            'person_responsible' => $this->person_responsible,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'pd_object', $this->pd_object])
            ->andFilterWhere(['like', 'progress_status', $this->progress_status])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'resultdoc_name', $this->resultdoc_name])
            ->andFilterWhere(['like', 'resultdoc_num', $this->resultdoc_num])
            ->andFilterWhere(['like', 'resultdoc_file', $this->resultdoc_file]);

        return $dataProvider;
    }
}
