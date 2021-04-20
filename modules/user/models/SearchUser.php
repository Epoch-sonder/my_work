<?php

namespace app\modules\user\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\user\models\User;

/**
 * SearchUser represents the model behind the search form of `app\modules\user\models\User`.
 */
class SearchUser extends User
{
    
    public $branchName;
    public $roleName;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'role_id', 'branch_id', 'enabled'], 'integer'],
            [['email'], 'email'],
            [['username', 'password', 'position', 'fio', 'phone', 'branchName', 'roleName'], 'safe'],
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
        $query = User::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $dataProvider->setSort([
            'defaultOrder' => ['id'=>SORT_DESC],
            'attributes' => [
                'id' => [
                    'asc' => ['id' => SORT_ASC],
                    'desc' => ['id' => SORT_DESC],
                ],
                'fio' => [
                    'asc' => ['fio' => SORT_ASC],
                    'desc' => ['fio' => SORT_DESC],
                ],
                'branchName' => [
                    'asc' => ['branch.name' => SORT_ASC],
                    'desc' => ['branch.name' => SORT_DESC],
                ],
                'username' => [
                    'asc' => ['username' => SORT_ASC],
                    'desc' => ['username' => SORT_DESC],
                ],
                'roleName' => [
                    'asc' => ['roles.name' => SORT_ASC],
                    'desc' => ['roles.name' => SORT_DESC],
                ],
            ]
        ]);

        $this->load($params);

        // if (!$this->validate()) {
        //     // uncomment the following line if you do not want to return any records when validation fails
        //     // $query->where('0=1');
        //     return $dataProvider;
        // }

        if (!($this->load($params) && $this->validate())) {
            /*** Жадная загрузка данных модели Страны для работы сортировки. */
            $query
                ->joinWith(['branch'])
                ->joinWith(['role'])
                ;
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'role_id' => $this->role_id,
            'branch_id' => $this->branch_id,
            'enabled' => $this->enabled,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'fio', $this->fio])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->joinWith(['branch' => function ($q) { $q->where('branch.name LIKE "%' . $this->branchName . '%"'); }])
            ->joinWith(['role' => function ($q) { $q->where('roles.name LIKE "%' . $this->roleName . '%"'); }])
            ;

        return $dataProvider;
    }
}
