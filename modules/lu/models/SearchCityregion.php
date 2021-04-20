<?php

namespace app\modules\lu\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\lu\models\Cityregion;

/**
 * SearchCityregion represents the model behind the search form of `app\modules\lu\models\Cityregion`.
 */
class SearchCityregion extends Cityregion
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'subject_kod', 'cityregion_kod'], 'integer'],
            [['cityregion_name'], 'safe'],
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
        $query = Cityregion::find();

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
            'subject_kod' => $this->subject_kod,
            'cityregion_kod' => $this->cityregion_kod,
        ]);

        $query->andFilterWhere(['like', 'cityregion_name', $this->cityregion_name]);

        return $dataProvider;
    }
}
