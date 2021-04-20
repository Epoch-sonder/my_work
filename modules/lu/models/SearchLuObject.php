<?php

namespace app\modules\lu\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\lu\models\LuObject;

/**
 * SearchLuObject represents the model behind the search form of `app\modules\lu\models\LuObject`.
 */
class SearchLuObject extends LuObject
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'zakup', 'land_cat', 'fed_subject', 'region', 'region_subdiv', 'taxation_way', 'taxwork_cat', 'taxwork_vol', 'stage_prepare_vol', 'stage_prepare_year', 'stage_field_vol', 'stage_field_year', 'stage_cameral_vol', 'stage_cameral_year'], 'integer'],
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
        $query = LuObject::find()
            ->with(['taxationWay'])
            ->with(['taxworkCat'])
            ->with(['oopt'])
            ->with(['cityregion'])
            ->with(['forestry'])
            ->with(['forestryDefense'])
            ;

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
            'zakup' => $this->zakup,
            'land_cat' => $this->land_cat,
            'fed_subject' => $this->fed_subject,
            'region' => $this->region,
            'region_subdiv' => $this->region_subdiv,
            'taxation_way' => $this->taxation_way,
            'taxwork_cat' => $this->taxwork_cat,
            'taxwork_vol' => $this->taxwork_vol,
            'stage_prepare_vol' => $this->stage_prepare_vol,
            'stage_prepare_year' => $this->stage_prepare_year,
            'stage_field_vol' => $this->stage_field_vol,
            'stage_field_year' => $this->stage_field_year,
            'stage_cameral_vol' => $this->stage_cameral_vol,
            'stage_cameral_year' => $this->stage_cameral_year,
        ]);

        return $dataProvider;
    }
}
