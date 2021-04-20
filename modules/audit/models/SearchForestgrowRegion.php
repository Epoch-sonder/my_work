<?php

namespace app\modules\audit\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\audit\models\ForestgrowRegion;

/**
 * SearchForestgrowRegion represents the model behind the search form of `app\modules\audit\models\ForestgrowRegion`.
 */
class SearchForestgrowRegion extends ForestgrowRegion
{
    /**
     * {@inheritdoc}
     */
    public $forestgrowZoneName;

    public function rules()
    {
        return [
            [['id', 'forestgrow_zone'], 'integer'],
            [['name','forestgrowZoneName'], 'safe'],
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
        $query = ForestgrowRegion::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
           'attributes' => [
                'forestgrowZoneName' => [
                    'asc' => ['forestgrow_zone.name' => SORT_ASC],
                    'desc' => ['forestgrow_zone.name' => SORT_DESC],
                ],
                'name' => [
                    'asc' => ['name' => SORT_ASC],
                    'desc' => ['name' => SORT_DESC],
                ],
            ]
        ]);

        $this->load($params);
//

//        if (!$this->validate()) {
//            // uncomment the following line if you do not want to return any records when validation fails
//            // $query->where('0=1');
//            return $dataProvider;
//        }

        if (!($this->load($params) && $this->validate())) {
            /**
             * Жадная загрузка данных модели Страны
             * для работы сортировки.
             */
            $query->joinWith(['forestgrowZone']);
            return $dataProvider;
        }


        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'forestgrow_region.name', $this->name])
              ->joinWith(['forestgrowZone' => function ($q) { $q->where('forestgrow_zone.name LIKE "%' . $this->forestgrowZoneName . '%"'); }])
        ;

        return $dataProvider;
    }
}
