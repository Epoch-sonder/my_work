<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<?php $form = ActiveForm::begin([
'id' => 'login-form',
    ]); ?>

<body>
    <?php if( Yii::$app->session->hasFlash('error') ): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo Yii::$app->session->getFlash('error'); ?>
        </div>
    <?php endif;?>
    <div class="col-xs-4">
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
				<?= $form->field($model, 'password')->passwordInput() ?>
				<?= Html::submitButton('Войти в систему', ['class' => 'btn btn-default', 'name' => 'login-button']) ?>
	</div>
		</div>
			</div>

<?php ActiveForm::end(); ?>


