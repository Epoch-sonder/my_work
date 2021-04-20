<?php

namespace app\models;

use app\models\BranchPerson;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SearchBranchPerson represents the model behind the search form of `app\models\BranchPerson`.
 */
class SearchBranchPerson extends BranchPerson
{
    /**
     * {@inheritdoc}
     */
    public $branchName;

    public function rules()
    {
        return [
            [['id', 'branch', 'lu_dzz', 'lu_tax_eye', 'lu_tax_aero', 'lu_tax_actual', 'lu_cameral1', 'lu_cameral2', 'lu_plot_allocation', 'lu_park_inventory', 'gil_field', 'gil_cameral', 'gil_ozvl_quality', 'gil_remote_monitoring', 'experience_specialty', 'experience_work', 'remark', 'num_brigade', 'training_process_1', 'training_process_2', 'training_process_3'], 'integer'],
            [['branchName','fio', 'position', 'division', 'subdivision', 'education', 'specialization', 'academic_degree', 'date_admission', 'date_dismissial'], 'safe'],
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
        $branchID = Yii::$app->user->identity->branch_id;
        if ($branchID == 0){
            $query = BranchPerson::find();
        }
        else $query = BranchPerson::find()->where(['=','branch',$branchID]);


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'fio' => [
                    'asc' => ['fio' => SORT_ASC],
                    'desc' => ['fio' => SORT_DESC],
                ],
                'position' => [
                    'asc' => ['position' => SORT_ASC],
                    'desc' => ['position' => SORT_DESC],
                ],
                'education' => [
                    'asc' => ['education' => SORT_ASC],
                    'desc' => ['education' => SORT_DESC],
                ],
                'experience_specialty' => [
                    'asc' => ['experience_specialty' => SORT_ASC],
                    'desc' => ['experience_specialty' => SORT_DESC],
                ],
                'date_admission' => [
                    'asc' => ['date_admission' => SORT_ASC],
                    'desc' => ['date_admission' => SORT_DESC],
                ],
                'date_dismissial' => [
                    'asc' => ['date_dismissial' => SORT_ASC],
                    'desc' => ['date_dismissial' => SORT_DESC],
                ],
                'branchName' => [
                    'asc' => ['branch.name' => SORT_ASC],
                    'desc' => ['branch.name' => SORT_DESC],
                ],
                'lu_dzz' => [
                    'asc' => ['lu_dzz' => SORT_ASC],
                    'desc' => ['lu_dzz' => SORT_DESC],
                ],
                'lu_tax_eye' => [
                    'asc' => ['lu_tax_eye' => SORT_ASC],
                    'desc' => ['lu_tax_eye' => SORT_DESC],
                ],
                'lu_tax_aero' => [
                    'asc' => ['lu_tax_aero' => SORT_ASC],
                    'desc' => ['lu_tax_aero' => SORT_DESC],
                ],
                'lu_tax_actual' => [
                    'asc' => ['lu_tax_actual' => SORT_ASC],
                    'desc' => ['lu_tax_actual' => SORT_DESC],
                ],
                'lu_cameral1' => [
                    'asc' => ['lu_cameral1' => SORT_ASC],
                    'desc' => ['lu_cameral1' => SORT_DESC],
                ],
                'lu_cameral2' => [
                    'asc' => ['lu_cameral2' => SORT_ASC],
                    'desc' => ['lu_cameral2' => SORT_DESC],
                ],
                'lu_plot_allocation' => [
                    'asc' => ['lu_plot_allocation' => SORT_ASC],
                    'desc' => ['lu_plot_allocation' => SORT_DESC],
                ],
                'lu_park_inventory' => [
                    'asc' => ['lu_park_inventory' => SORT_ASC],
                    'desc' => ['lu_park_inventory' => SORT_DESC],
                ],
                'gil_field' => [
                    'asc' => ['gil_field' => SORT_ASC],
                    'desc' => ['gil_field' => SORT_DESC],
                ],
                'gil_cameral' => [
                    'asc' => ['gil_cameral' => SORT_ASC],
                    'desc' => ['gil_cameral' => SORT_DESC],
                ],
                'gil_ozvl_quality' => [
                    'asc' => ['gil_ozvl_quality' => SORT_ASC],
                    'desc' => ['gil_ozvl_quality' => SORT_DESC],
                ],
                'gil_remote_monitoring' => [
                    'asc' => ['gil_remote_monitoring' => SORT_ASC],
                    'desc' => ['gil_remote_monitoring' => SORT_DESC],
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
        // grid filtering conditions
        if (!($this->load($params) && $this->validate())) {
            /**
             * Жадная загрузка данных модели Страны
             * для работы сортировки.
             */
            $query
                ->joinWith(['branchKod']);
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'branch' => $this->branch,
            'lu_dzz' => $this->lu_dzz,
            'lu_tax_eye' => $this->lu_tax_eye,
            'lu_tax_aero' => $this->lu_tax_aero,
            'lu_tax_actual' => $this->lu_tax_actual,
            'lu_cameral1' => $this->lu_cameral1,
            'lu_cameral2' => $this->lu_cameral2,
            'lu_plot_allocation' => $this->lu_plot_allocation,
            'lu_park_inventory' => $this->lu_park_inventory,
            'gil_field' => $this->gil_field,
            'gil_cameral' => $this->gil_cameral,
            'gil_ozvl_quality' => $this->gil_ozvl_quality,
            'gil_remote_monitoring' => $this->gil_remote_monitoring,
            'experience_specialty' => $this->experience_specialty,
            'experience_work' => $this->experience_work,
            'date_admission' => $this->date_admission,
//            'date_dismissial' => $this->date_dismissial,
            'remark' => $this->remark,
            'num_brigade' => $this->num_brigade,
            'training_process_1' => $this->training_process_1,
            'training_process_2' => $this->training_process_2,
            'training_process_3' => $this->training_process_3,
        ]);

        $query->andFilterWhere(['like', 'fio', $this->fio])
            ->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['>=' , 'date_dismissial', $this->date_dismissial])
            ->andFilterWhere(['like', 'division', $this->division])
            ->andFilterWhere(['like', 'subdivision', $this->subdivision])
            ->andFilterWhere(['like', 'education', $this->education])
            ->andFilterWhere(['like', 'specialization', $this->specialization])
            ->andFilterWhere(['like', 'academic_degree', $this->academic_degree])
            ->joinWith(['branchKod' => function ($q) { $q->where('branch.name LIKE "%' . $this->branchName . '%"'); }]);

        return $dataProvider;
    }
}
