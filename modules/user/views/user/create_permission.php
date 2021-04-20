<?php

use app\modules\user\models\AuthItem;
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

    echo $form->field($model, 'username')->dropDownList(ArrayHelper::map(app\models\User::find()->orderBy('fio')->all(), 'id', 'fio'), ['options' => ['5' => ['selected' => 'selected']]],);

    echo $form->field($model, 'permission')->hiddenInput()->label(false);


    $permissions = AuthItem::find()->where(['=','type','2'])->orderBy('name')->all();
    $count = 0;



    echo '<div class="checkboxs"></div><div class="row">';
    echo '<div class="col-sm-4"> <h2>Лесное планирование</h2>'.$pd.'</div>';
    echo '<div class="col-sm-4"> <h2>Лесоустройство</h2>'.$lu.'</div>';
    echo '<div class="col-sm-4"> <h2>Бригада</h2>'.$brigade.'</div>';
    echo '</div><div class="row">';
    echo '<div class="col-sm-4"> <h2>Тренировочный процесс</h2>'.$tr.'</div>';
    echo '<div class="col-sm-4"> <h2>Аудит</h2>'.$audit.'</div>';
    echo '<div class="col-sm-4"> <h2>Остальное</h2>'.$other.'</div><br><br><br>';
    echo '</div></div>';
    echo Html::submitButton('Добавить разрешение для сотрудника', ['class' => 'btn btn-success']);

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
    $('#createrole-permission').val(text_cheak);
})

$('#createrole-username').on('change',function (){
    viewPermission();
})

function viewPermission(){
    var csrfToken = $('meta[name="csrf-token"]').attr("content"); //создаем CSRF токен
    $.ajax({
        url: '/user/user/view-permission-for-people',
        type: 'POST',
        data: {'id_user' : $('#createrole-username').val() , _csrf :  csrfToken },
        success: function(data){ // удачное завершение запроса к серверу, в переменной data ответ сервера
                $('.checkbox_check').prop('checked',false);
                $('#createrole-permission').val('')
                var permission = data.split(',');
                var permission_all = 'Null';
                for (var i = 0;i < permission.length; i++){
                    $("input[value = '"+permission[i]+"']").prop('checked',true);
                    if (permission_all == 'Null')
                        permission_all = permission[i];
                    else 
                        permission_all += ',' + permission[i];
                    $('#createrole-permission').val(permission_all);
                }
        },
        error: function(){
          console.log('функция сломалась');
        }
      });
}


JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($js, yii\web\View::POS_END);
?>
