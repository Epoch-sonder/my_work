<?php

namespace app\modules\lu\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\lu\models\LuObjectProcess;

/**
 * SearchLuObjectProcess represents the model behind the search form of `app\modules\lu\models\LuObjectProcess`.
 */
class SearchLuObjectProcess extends LuObjectProcess
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'lu_object', 'lu_process_step', 'month', 'year'], 'integer'],
            [['plan', 'fact'], 'number'],
            [['timestamp'], 'safe'],
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
        $query = LuObjectProcess::find()->where(['lu_object'=>Yii::$app->request->get('object') , 'lu_process_step'=>Yii::$app->request->get('step')] );
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
            'lu_object' => $this->lu_object,
            'lu_process_step' => $this->lu_process_step,
            'month' => $this->month,
            'year' => $this->year,
            'plan' => $this->plan,
            'fact' => $this->fact,
            'timestamp' => $this->timestamp,
        ]);

        return $dataProvider;
    }
}
