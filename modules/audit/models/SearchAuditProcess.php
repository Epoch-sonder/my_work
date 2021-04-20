<?php

namespace app\modules\audit\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\audit\models\AuditProcess;

/**
 * SearchAuditProcess represents the model behind the search form of `app\modules\audit\models\AuditProcess`.
 */
class SearchAuditProcess extends AuditProcess
{
    /**
     * {@inheritdoc}
     */
    
    public $federalSubjectName;
    public $auditFio;

    public function rules()
    {
        return [
            [['id', 'audit', 'audit_person', 'comment', 'proposal'], 'integer'],
            [['audit_chapter'], 'string'],
            [['money_daily', 'money_accomod', 'money_transport', 'money_other'], 'number'],
            [['federalSubjectName', 'auditFio','date_start', 'date_finish'], 'safe'],
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


        if (Yii::$app->user->identity->role_id == '15'){
            if (Yii::$app->user->identity->branch_id == 0) $query = AuditProcess::find();
            else {
                $branchID = Yii::$app->user->identity->branch_id;
                $branch_persons = AuditPerson::find()->where(['=','branch',$branchID])->asArray()->all();
                foreach ($branch_persons as $branch_person) {
                    $allPersons[$branch_person['id']]= ''.$branch_person['id'].'';
                }
                $query = AuditProcess::find()->where(['audit_person' => $allPersons])->andWhere( ['and' , ['>=' , 'date_start', "$dataChange-01-01"] , ['<=','date_finish', "$dataChange-12-31"] ]);
            }

        }
        else  $query = AuditProcess::find()->andWhere( ['and' , ['>=' , 'date_start', "$dataChange-01-01"] , ['<=','date_finish', "$dataChange-12-31"] ]);


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $dataProvider->setSort([
            // 'defaultOrder' => ['basedoc_datefinish'=>SORT_ASC],
            'attributes' => [
                // 'id',
                // 'federalSubjectName' => [
                //     'asc' => ['federal_subject.name' => SORT_ASC],
                //     'desc' => ['federal_subject.name' => SORT_DESC],
                // ],

                'auditFio' => [
                    'asc' => ['audit_person.fio' => SORT_ASC],
                    'desc' => ['audit_person.fio' => SORT_DESC],
                    // 'label' => ''
                ],
                'date_start' => [
                    'asc' => ['date_start' => SORT_ASC],
                    'desc' => ['date_start' => SORT_DESC],
                ],
                'date_finish' => [
                    'asc' => ['date_finish' => SORT_ASC],
                    'desc' => ['date_finish' => SORT_DESC],
                ],
                'audit_chapter',
                'money_daily',
                'money_accomod',
                'money_transport',
                'money_other',
                
            ]
        ]);


        $this->load($params);

        // if (!$this->validate()) {
        //     // uncomment the following line if you do not want to return any records when validation fails
        //     // $query->where('0=1');
        //     return $dataProvider;
        // }

        if (!($this->load($params) && $this->validate())) {
            /*** Жадная загрузка данных модели Страны для работы сортировки.  */
             $query
//                 ->joinWith(['audit0'])
                 ->joinWith(['auditPerson'])
                 ;
            return $dataProvider;
        }


        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'audit' => $this->audit,
            'audit_person' => $this->audit_person,
            'audit_chapter' => $this->audit_chapter,
            'comment' => $this->comment,
            'proposal' => $this->proposal,
            'date_start' => $this->date_start,
            'date_finish' => $this->date_finish,
            'money_daily' => $this->money_daily,
            'money_accomod' => $this->money_accomod,
            'money_transport' => $this->money_transport,
            'money_other' => $this->money_other,
        ])

//        ->joinWith(['audit0' => function ($q) { $q->where('federal_subject.federal_subject_id LIKE "%' . $this->auditFed0 . '%"'); }])
        ->joinWith(['auditPerson' => function ($q) { $q->where('audit_person.fio LIKE "%' . $this->auditFio . '%"'); }])
            ;

        return $dataProvider;
    }
}
