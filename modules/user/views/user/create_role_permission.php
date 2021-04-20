<?php

use app\modules\user\models\AuthItem;
use app\modules\user\models\AuthItemChild;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

use yii\grid\ActionColumn;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\user\models\SearchUser */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список сотрудников';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">
    <?php $form = ActiveForm::begin(); ?>
    <form role="form">
    <?php


    echo $form->field($model, 'create')->dropDownList([1=>'Создание',0 =>'Добавление разрешений']);

    $roles = AuthItem::find()->where(['=','type','1'])->orderBy('name')->all();
    foreach ($roles as $role){
        $form_role [$role['name'] ] = $role['description'];
    }
    echo $form->field($model, 'role_id')->dropDownList($form_role);
    echo $form->field($model, 'role_create')->textInput();
    echo $form->field($model, 'description')->textInput();




    echo $form->field($model, 'permission')->hiddenInput()->label(false);


    echo '<div class="checkboxs"></div><div class="row">';
    echo '<div class="col-md-4"> <h2>Лесное планирование</h2>'.$pd.'</div>';
    echo '<div class="col-md-4"> <h2>Лесоустройство</h2>'.$lu.'</div>';
    echo '<div class="col-md-4"> <h2>Бригада</h2>'.$brigade.'</div>';
    echo '</div><div class="row">';
    echo '<div class="col-md-4"> <h2>Тренировочный процесс</h2>'.$tr.'</div>';
    echo '<div class="col-md-4"> <h2>Аудит</h2>'.$audit.'</div>';
    echo '<div class="col-md-4"> <h2>Остальное</h2>'.$other.'</div><br><br><br>';
    echo '</div></div>';
    echo Html::submitButton('Добавить разрешение для роли', ['class' => 'btn btn-success']);

    ?>
    </form>
    <?php ActiveForm::end(); ?>
</div>
 

<?php
$js = <<< JS

var allCheak = '';
var text_cheak;

$('.checkbox_check').on('click',function (){
    text_cheak = '';
    $(".row").each(function(){
        allCheak = $(".row").find(':checked');
    });
    var count = allCheak.length;
    
    for (var i=0;i<count;i++){
        if (text_cheak)
            text_cheak += ','+ allCheak[i].value;
        else 
            text_cheak = allCheak[i].value; 
    }
    $('#createrolepermission-permission').val(text_cheak);
})

$('#createrolepermission-create').on('change',function (){
    displayNone();
    if ($('#createrolepermission-create').val() == 0)
        viewPermission();
    else {
        $('.checkbox_check').prop('checked',false);
        $('#createrolepermission-permission').val('');
    }
})
$('#createrolepermission-role_id').on('change',function (){
    viewPermission();
})

$("#w0").on('submit',function (){
   if (!$('#createrolepermission-role_create').val() && $('#createrolepermission-create').val() == 1 ) {
        $('#createrolepermission-role_create').css('border','1px solid red')
        $('.field-createrolepermission-role_create').find('.help-block').css('color','red')
        $('.field-createrolepermission-role_create').find('.control-label').css('color','red')
        return false;
    }
   else {
       $("#w0").submit();
   }

})

function displayNone() {
     if ($('#createrolepermission-create').val() == 1){
        $('.field-createrolepermission-role_id').css('display','none');
        $('.field-createrolepermission-description').css('display','');
        $('.field-createrolepermission-role_create').css('display','');
    }
    if ($('#createrolepermission-create').val() == 0){
        $('.field-createrolepermission-role_create').css('display','none');
        $('.field-createrolepermission-description').css('display','none');
        $('.field-createrolepermission-role_id').css('display','');
     
    }
}

function viewPermission(){
    var csrfToken = $('meta[name="csrf-token"]').attr("content"); //создаем CSRF токен
    $.ajax({
        url: '/user/user/view-permission',
        type: 'POST',
        data: {'role_id' : $('#createrolepermission-role_id').val() , _csrf :  csrfToken },
        success: function(data){ // удачное завершение запроса к серверу, в переменной data ответ сервера
                $('.checkbox_check').prop('checked',false);
                $('#createrolepermission-permission').val('')
                var permission = data.split(',');
                var permission_all = 'Null';
                for (var i = 0;i < permission.length; i++){
                    $("input[value = '"+permission[i]+"']").prop('checked',true);
                    if (permission_all == 'Null')
                        permission_all = permission[i];
                    else 
                        permission_all += ',' + permission[i];
                    $('#createrolepermission-permission').val(permission_all);
                }
        },
        error: function(){
          console.log('функция сломалась');
        }
      });
}
setTimeout(displayNone,25);
if ($('#createrolepermission-create').val() == 0){
    setTimeout(viewPermission,50);
}



JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($js, yii\web\View::POS_END);
?>
