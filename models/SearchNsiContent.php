<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\NsiContent;

/**
 * SearchNsiContent represents the model behind the search form of `app\models\NsiContent`.
 */
class SearchNsiContent extends NsiContent
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'soli_id', 'class', 'cod', 'class_01', 'cod_01', 'class_02', 'cod_02', 'class_03', 'cod_03', 'class_04', 'cod_04', 'class_05', 'cod_05', 'class_06', 'cod_06', 'class_07', 'cod_07', 'class_08', 'cod_08', 'class_09', 'cod_09', 'class_10', 'cod_10', 'class_11', 'cod_11', 'class_12', 'cod_12', 'class_13', 'cod_13', 'class_14', 'cod_14', 'class_15', 'cod_15', 'class_16', 'cod_16', 'class_17', 'cod_17', 'class_18', 'cod_18', 'class_19', 'cod_19', 'class_20', 'cod_20', 'class_21', 'cod_21', 'class_22', 'cod_22', 'class_23', 'cod_23', 'class_24', 'cod_24', 'class_25', 'cod_25', 'class_26', 'cod_26', 'class_27', 'cod_27', 'class_28', 'cod_28', 'class_29', 'cod_29', 'class_30', 'cod_30', 'class_31', 'cod_31', 'class_32', 'cod_32', 'class_33', 'cod_33', 'class_34', 'cod_34', 'class_35', 'cod_35', 'class_36', 'cod_36', 'class_37', 'cod_37'], 'integer'],
            [['attr_textval'], 'safe'],
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
        $query = NsiContent::find();

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
            'soli_id' => $this->soli_id,
            'class' => $this->class,
            'cod' => $this->cod,
            'class_01' => $this->class_01,
            'cod_01' => $this->cod_01,
            'class_02' => $this->class_02,
            'cod_02' => $this->cod_02,
            'class_03' => $this->class_03,
            'cod_03' => $this->cod_03,
            'class_04' => $this->class_04,
            'cod_04' => $this->cod_04,
            'class_05' => $this->class_05,
            'cod_05' => $this->cod_05,
            'class_06' => $this->class_06,
            'cod_06' => $this->cod_06,
            'class_07' => $this->class_07,
            'cod_07' => $this->cod_07,
            'class_08' => $this->class_08,
            'cod_08' => $this->cod_08,
            'class_09' => $this->class_09,
            'cod_09' => $this->cod_09,
            'class_10' => $this->class_10,
            'cod_10' => $this->cod_10,
            'class_11' => $this->class_11,
            'cod_11' => $this->cod_11,
            'class_12' => $this->class_12,
            'cod_12' => $this->cod_12,
            'class_13' => $this->class_13,
            'cod_13' => $this->cod_13,
            'class_14' => $this->class_14,
            'cod_14' => $this->cod_14,
            'class_15' => $this->class_15,
            'cod_15' => $this->cod_15,
            'class_16' => $this->class_16,
            'cod_16' => $this->cod_16,
            'class_17' => $this->class_17,
            'cod_17' => $this->cod_17,
            'class_18' => $this->class_18,
            'cod_18' => $this->cod_18,
            'class_19' => $this->class_19,
            'cod_19' => $this->cod_19,
            'class_20' => $this->class_20,
            'cod_20' => $this->cod_20,
            'class_21' => $this->class_21,
            'cod_21' => $this->cod_21,
            'class_22' => $this->class_22,
            'cod_22' => $this->cod_22,
            'class_23' => $this->class_23,
            'cod_23' => $this->cod_23,
            'class_24' => $this->class_24,
            'cod_24' => $this->cod_24,
            'class_25' => $this->class_25,
            'cod_25' => $this->cod_25,
            'class_26' => $this->class_26,
            'cod_26' => $this->cod_26,
            'class_27' => $this->class_27,
            'cod_27' => $this->cod_27,
            'class_28' => $this->class_28,
            'cod_28' => $this->cod_28,
            'class_29' => $this->class_29,
            'cod_29' => $this->cod_29,
            'class_30' => $this->class_30,
            'cod_30' => $this->cod_30,
            'class_31' => $this->class_31,
            'cod_31' => $this->cod_31,
            'class_32' => $this->class_32,
            'cod_32' => $this->cod_32,
            'class_33' => $this->class_33,
            'cod_33' => $this->cod_33,
            'class_34' => $this->class_34,
            'cod_34' => $this->cod_34,
            'class_35' => $this->class_35,
            'cod_35' => $this->cod_35,
            'class_36' => $this->class_36,
            'cod_36' => $this->cod_36,
            'class_37' => $this->class_37,
            'cod_37' => $this->cod_37,
        ]);

        $query->andFilterWhere(['like', 'attr_textval', $this->attr_textval]);

        return $dataProvider;
    }
}
