<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\audit\models\BrigadeOnline */
/* @var $form yii\widgets\ActiveForm */


if (\Yii::$app->user->can('brigade_online_edit')){
?>
<div class="brigade-online-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'brigade_number')->textInput() ?>

    <?= $form->field($model, 'date_report')->textInput() ?>

    <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php }  ?>