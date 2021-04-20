<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\Audit */

$this->title = 'Обновление проверки № ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Audits', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="audit-update">
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
        echo Html::a('<- вернуться к списку проверок', ['../audit/audit-process/'], ['class' => 'btn btn-primary']);
        echo  '<br>';
        echo  '<br>';
    }
    else{
        echo Html::a('<- вернуться к своду', ['../audit/audit/summary'.$return_data], ['class' => 'btn btn-primary']);
        echo  '<br>';
        echo  '<br>';
    }



    ?>


    <?= $this->render('_form', [
        'model' => $model,
        'model2' => $model2,
    ]) ?>

</div>
