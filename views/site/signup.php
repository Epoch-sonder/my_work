<?php
 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
 
<h1>Добавление нового пользователя</h1>
<br>

<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'username') ?>
<?= $form->field($model, 'password')->passwordInput() ?>
<?= $form->field($model, 'branch_id') ?>
<?= $form->field($model, 'position') ?>
<?= $form->field($model, 'fio') ?>
<?= $form->field($model, 'phone') ?>

<div class="form-group">
    <div>
        <?= Html::submitButton('Регистрация', ['class' => 'btn btn-success']) ?>
    </div>
</div>


<?php ActiveForm::end() ?>