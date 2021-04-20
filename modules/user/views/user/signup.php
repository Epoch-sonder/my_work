<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

?>

<div class="user-form">

<?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title" style="text-align: center;">Создание профиля сотрудника</h3>
              </div>
              <form role="form">
                <div class="card-body">
                  <div class="form-group">
                    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
                  </div>
                  <div class="form-group">
                    <?= $form->field($model, 'password')->passwordInput() ?>			
                  </div>
				   <div class="form-group">
                    <?= $form->field($model, 'role_id')->dropDownList(ArrayHelper::map(app\modules\user\models\AuthItem::find()->where(['=','type','1'])->all(), 'name', 'name'), ['options' => ['5' => ['selected' => 'selected']]],);?>
                   </div>
				   <div class="form-group">
                    <?= $form->field($model, 'branch_id')->dropDownList(ArrayHelper::map(app\modules\user\models\Branch::find()->all(), 'branch_id', 'name')) ?>
                  </div>
				   <div class="form-group">
                    <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>
                  </div>
				   <div class="form-group">
                    <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>
                  </div>
				   <div class="form-group">
                    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
                  </div>
				   <div class="form-group">
                    <?= $form->field($model, 'email')->textInput() ?>
                  </div>
           <div class="form-group">
                    <?php //= $form->field($model, 'enabled')->textInput(['value' => '1']) ?>
                    <?= $form->field($model, 'enabled')->checkbox(['checked' => 'checked']) ?>
                  </div>
                </div>
                <div class="card-footer">
                  <?= Html::submitButton('Создать профиль', ['class' => 'btn btn-success']) ?>
                </div>
              </form>
			  <?php ActiveForm::end(); ?>
            </div>

</div>
