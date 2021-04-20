<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\ForestgrowRegionSubject */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="forestgrow-region-subject-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'region_id')->dropDownList(ArrayHelper::map(app\modules\audit\models\ForestgrowRegion::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'))->label("Лесорастительный район") ?>

    <?= $form->field($model, 'subject_id')->dropDownList(ArrayHelper::map(app\modules\audit\models\FederalSubject::find()->orderBy(['name' => SORT_ASC])->all(), 'federal_subject_id', 'name'))->label("Субъект РФ")  ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
