<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

?>

<div class="user-form">

<?php $form = ActiveForm::begin(); ?>

            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Назначение пароля пользователя</h3>
              </div>
              <form role="form">
                <div class="card-body">
            <div class="form-group">
                    <?= $form->field($model, 'password')->passwordInput() ?>      
                  </div>
                </div>
                <div class="card-footer">
                  <?= Html::submitButton('Назначить новый пароль', ['class' => 'btn btn-success']) ?>
                </div>
              </form>
			  <?php ActiveForm::end(); ?>
            </div>

</div>
