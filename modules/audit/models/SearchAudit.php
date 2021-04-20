<?php

namespace app\modules\audit\models;

use app\modules\pd\models\PdWork;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\audit\models\Audit;

/**
 * SearchAudit represents the model behind the search form of `app\modules\audit\models\Audit`.
 */
class SearchAudit extends Audit
{
    /**
     * {@inheritdoc}
     */

    public $fedDistrictName;
    public $fedSubjectName;
    public $auditTypeName;
    public $oivSubjectName;



    public function rules()
    {
        return [
            [['id', 'fed_district', 'fed_subject', 'audit_type', 'audit_quantity','duration'], 'integer'],
            [['date_start', 'date_finish', 'oiv', 'organizer', 'fedDistrictName', 'fedSubjectName', 'oivSubjectName', 'auditTypeName','duration'], 'safe'],
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

        //Если дата изначально не указана, то берет год сегодняшнего дня
        $dataDefold = date_default_timezone_get();
        $dataDefold = date("Y", strtotime($dataDefold . ""));

        if (Yii::$app->request->get('request_date')) $dataChange = Yii::$app->request->get('request_date');
        else $dataChange = $dataDefold;

        $query = Audit::find()->andWhere( ['and' , ['>=' , 'date_start', "$dataChange-01-01"] , ['<=','date_finish', "$dataChange-12-31"] ]);;

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['date_start'=>SORT_ASC],
            'attributes' => [
                'fedDistrictName' => [
                    'asc' => ['federal_district.name' => SORT_ASC],
                    'desc' => ['federal_district.name' => SORT_DESC],
                ],
                'fedSubjectName' => [
                    'asc' => ['federal_subject.name' => SORT_ASC],
                    'desc' => ['federal_subject.name' => SORT_DESC],
                ],
                'oivSubjectName' => [
                    'asc' => ['oiv_subject.name' => SORT_ASC],
                    'desc' => ['oiv_subject.name' => SORT_DESC],
                ],
                'date_start' => [
                    'asc' => ['date_start' => SORT_ASC],
                    'desc' => ['date_start' => SORT_DESC],
                ],
                'date_finish' => [
                    'asc' => ['date_finish' => SORT_ASC],
                    'desc' => ['date_finish' => SORT_DESC],
                ],
                'duration' => [
                    'asc' => ['duration' => SORT_ASC],
                    'desc' => ['duration' => SORT_DESC],
                ],
                'oiv' => [
                    'asc' => ['oiv' => SORT_ASC],
                    'desc' => ['oiv' => SORT_DESC],
                ],
                'organizer' => [
                    'asc' => ['organizer' => SORT_ASC],
                    'desc' => ['organizer' => SORT_DESC],
                ],
                'auditTypeName' => [
                    'asc' => ['audit_type.type' => SORT_ASC],
                    'desc' => ['audit_type.type' => SORT_DESC],
                ],
                'audit_quantity' => [
                    'asc' => ['audit_quantity' => SORT_ASC],
                    'desc' => ['audit_quantity' => SORT_DESC],
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
            /**
             * Жадная загрузка данных модели Страны
             * для работы сортировки.
             */
            $query
                ->joinWith(['fedDistrict'])
                ->joinWith(['fedSubject'])
                ->joinWith(['oivSubject'])
                ->joinWith(['auditType'])
                ;
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'date_start' => $this->date_start,
            'date_finish' => $this->date_finish,
            'duration' => $this->duration,
            'fed_district' => $this->fed_district,
            'fed_subject' => $this->fed_subject,
            // 'audit_type' => $this->audit_type,
            // 'audit_quantity' => $this->audit_quantity,
        ]);

        $query->andFilterWhere(['like', 'oiv', $this->oiv])
            ->andFilterWhere(['like', 'organizer', $this->organizer])
            ->joinWith(['fedSubject' => function ($q) { $q->where('federal_subject.name LIKE "%' . $this->fedSubjectName . '%"'); }])
            ->joinWith(['oivSubject' => function ($q) { $q->where('oiv_subject.name LIKE "%' . $this->oivSubjectName . '%"'); }])
            ->joinWith(['fedDistrict' => function ($q) { $q->where('federal_district.name LIKE "%' . $this->fedDistrictName . '%"'); }])
            ->joinWith(['auditType' => function ($q) { $q->where('audit_type.type LIKE "%' . $this->auditTypeName . '%"'); }])
        ;

        return $dataProvider;
    }
}
