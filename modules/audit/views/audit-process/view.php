<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\AuditProcess */

$this->title = 'Просмотр информации по разделам';
$this->params['breadcrumbs'][] = ['label' => 'Ход проверки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="audit-process-view">



    <?php
        if(Yii::$app->request->get('from_date') != null and Yii::$app->request->get('to_date') != null){
            $return_data = '?from_date='.Yii::$app->request->get('from_date').'&to_date='.Yii::$app->request->get('to_date');
        }
        elseif (Yii::$app->request->get('from_date') == null and Yii::$app->request->get('to_date') != null){
            $return_data = '?to_date='.Yii::$app->request->get('to_date');
        }
        elseif (Yii::$app->request->get('from_date') != null and Yii::$app->request->get('to_date') == null){
            $return_data = '?from_date='.Yii::$app->request->get('from_date');
        }
        else{
            $return_data = '';
        }

        ?>



    <?php
    if(Yii::$app->request->get('process') == 1){

      echo Html::a('<- вернуться в ход проверок', ['../audit/audit-process/'], ['class' => 'btn btn-primary']);
        echo  '<br>';
        echo  '<br>';
    }
    else{
      echo Html::a('<- вернуться к своду', ['../audit/audit/summary'.$return_data], ['class' => 'btn btn-primary']);
        echo  '<br>';
        echo  '<br>';
    }



    ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            [
                'attribute' => 'federalSubjectName',
                'label' => 'Проверка&nbsp;по&nbsp;субьекту',
            ],
            [
                'attribute' => 'auditfio',
                'label' => 'Проверяющий&nbsp;специалист',
            ],
            [
                'attribute' => 'auditPosition',
                'label' => 'Должность&nbsp;специалиста',
            ],
            [
                'attribute' => 'branchName',
                'label' => 'Филиал&nbsp;специалиста',
            ],
            'audit_chapter',
            [
                'attribute' => 'comment',
                'label' => 'Замечания',
                'format' => 'raw',
                'value' => function($data){
                    $chapter_a = $data->comment;
                    return nl2br($chapter_a);
                    // return "<strong style='color:red'>123</strong>";
                    // return Html::a('X', ['create'], ['class' => 'btn btn-success']) ;
                },
            ],

            [
                'attribute' => 'proposal',
                'label' => 'Предложения',
                'format' => 'raw',
                'value' => function($data){
                    $chapter_a = $data->proposal;
                    return nl2br($chapter_a);
                    // return "<strong style='color:red'>123</strong>";
                    // return Html::a('X', ['create'], ['class' => 'btn btn-success']) ;
                },
            ],
            [
                'label' => 'Дни',
                'value' => function($data) {
                    $dateF = new \DateTime($data->date_finish);
                    $dateS = new \DateTime($data->date_start);
                    $dateST = date_format($dateS,"d.m.yy");
                    $dateFT = date_format($dateF,"d.m.yy");
                    if ($dateS != null and $dateF != null) {

                        $DateAll = date_diff($dateS, $dateF);
                        $sumDate = $DateAll->d + 1;
                        $sumDateAll = "C " . $dateST . ' по ' . $dateFT . '. Количество дней: ' . $sumDate;
                        return $sumDateAll;

                    }
                    elseif($dateS != null and $dateF == null) {
                        $sumDateAll = "". 'По ' . $dateST . '. Количество дней: дата начала работы не указана';
                        return $sumDateAll;
                    }
                    elseif($dateS == null and $dateF != null) {
                        $sumDateAll = "С ". $dateFT . '. Количество дней: дата конца работы не указана';
                        return $sumDateAll;
                    }
                    elseif($dateS == null and $dateF == null) {
                        return  'Дата начало работы и ее конец не указан';
                    }


                },
            ],
            [
                'attribute' => 'money_daily',
                'value' => function($data) { return number_format($data->money_daily, 2, ',', ' '); }
            ],
            [
                'attribute' => 'money_accomod',
                'value' => function($data) { return number_format($data->money_accomod, 2, ',', ' '); }
            ],
            [
                'attribute' => 'money_transport',
                'value' => function($data) { return number_format($data->money_transport, 2, ',', ' '); }
            ],
            [
                'attribute' => 'money_other',
                'value' => function($data) { return number_format($data->money_other, 2, ',', ' '); }
            ],

            [
                'label' => 'Итого, руб.',
                'value' => function($data) {
                    $sum = $data->money_daily + $data->money_accomod + $data->money_transport + $data->money_other;
                    return number_format($sum, 2, ',', ' '); 
                }
            ],

        ],
    ]) ?>

</div>
