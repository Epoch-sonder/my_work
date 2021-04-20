<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\lu\models\GpsTracking;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\GpsTracking */

$this->title = 'Просмотр информации о gps трекинг';
$this->params['breadcrumbs'][] = ['label' => 'Gps Trackings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$arrayMonth =array( 1 => "января", "февраля","марта", "апреля","мая","июня","июля","августа","сентября","октября","ноября","декабря" );

?>
<style>
    .div{
        border: 1px solid ;
        border-color: #e7e7e7;
    }
    h4 , h5{
        margin-left: 10px;
    }
    pre{
        display: none;
    }

    .divNoborder div {
        border: 0;
    }
    .divflow div{
        border: 0;

    }
    .divflow{
        margin-bottom:  15px;
        width: 100%;

    }
    .greyDiv{
        border-top: 1px solid ;
        border-bottom: 1px solid ;
        border-color: #e7e7e7;
        background-color: #f9f9f9;

    }
    .file_list{
        margin-left: 20px;
    }
    .textBold {

        margin: 10px 0 5px 6px;
        display: inline-block;
    }
    .Text{
        font-weight: bold;
        margin: 10px 0 5px 6px;
        display: inline-block;
    }
    .leftfloat , .rightfloat{
        widows: revert;
        margin: 0;
    }
    .floatNo{
        width: 100%;
        margin: 0 0 15px 20px !important;
    }
    .statement span,
    .taxCard span,
    .floatNo span {
        display: none;
    }



    .date_view{
        white-space: nowrap;
        margin-left: 0;
        text-align: center;
    }
    .date_view_check{
        text-align: center;
        white-space: nowrap;
        padding-left: 8px;
        padding-right: 5px;
        border: 3px solid green;
    }
    .btn{
        margin-left: 11px;
    }
    .delete {
        text-align: center;
    }
</style>
    <p>
        <?= Html::a('<- вернуться к Gps-трекингу', ['../lu/gps-tracking/' ], ['class' => 'btn btn-primary']); ?>
    </p>
<div class="gps-tracking-view">


    <?php
    echo '<div style="width:100%" class="div"> ';

    echo '<div class="greyDiv" style="width: 100%; float: left;"><h4>'. Html::encode($this->title) .'</h4></div>';

    echo '<div><h5 class="textBold"> Филиал: </h5><h5 class="Text">'.$branch['name'].'</h5></div>' ;
    echo '<div><h5 class="textBold"> Контракт: </h5><h5 class="Text">'.$contract['zakup_num'].'</h5></div>' ;
    echo '<div><h5 class="textBold"> Специалист: </h5><h5 class="Text">'.$specialist['fio'].'</h5></div>' ;
    echo '<div><h5 class="textBold"> Руководитель полевой группы: </h5><h5 class="Text">  '.$party_leader['fio'].'</h5></div>' ;
    if (\Yii::$app->user->can('admin')){
        echo '<div><h5 class="textBold"> ФИО отвественного: </h5><h5 class="Text">'.$fio_responsible['fio'].'</h5></div>' ;
        echo '<div><h5 class="textBold"> Дата создание: </h5><h5 class="Text">'.$model->date_create.'</h5></div><br>';
    }


    echo '<div class="greyDiv"><h4>Gps координаты: </h4></div>';
    ?>

        <div class="row col-sm-12 col-md-6" style="padding-top: 15px">
            <div class="col-sm-3"><?php (new app\modules\lu\models\GpsTracking)->month_date('Апрель',$model->april_check,$model->april_recd,$null = 1,1,$arrayMonth) ?></div>
            <div class="col-sm-3"><?php (new app\modules\lu\models\GpsTracking)->month_date('Май',$model->may_check,$model->may_recd,$model->april_recd, 2,$arrayMonth) ?></div>
            <div class="col-sm-3"><?php (new app\modules\lu\models\GpsTracking)->month_date('Июнь',$model->june_check,$model->june_recd,$model->may_recd,3,$arrayMonth) ?></div>
            <div class="col-sm-3"><?php (new app\modules\lu\models\GpsTracking)->month_date('Июль',$model->july_check,$model->july_recd,$model->june_recd,4,$arrayMonth) ?></div>
        </div>
        <div class="row col-sm-12 col-md-6" style="padding-top: 15px">
            <div class="col-sm-3"><?php (new app\modules\lu\models\GpsTracking)->month_date('Август',$model->august_check,$model->august_recd,$model->july_recd,5,$arrayMonth) ?></div>
            <div class="col-sm-3"><?php (new app\modules\lu\models\GpsTracking)->month_date('Сентябрь',$model->september_check,$model->september_recd,$model->august_recd,6,$arrayMonth) ?></div>
            <div class="col-sm-3"><?php (new app\modules\lu\models\GpsTracking)->month_date('Октябрь',$model->october_check,$model->october_recd,$model->september_recd,7,$arrayMonth) ?></div>
            <div class="col-sm-3"><?php (new app\modules\lu\models\GpsTracking)->month_date('Ноябрь',$model->november_check,$model->november_recd,$model->october_recd,8,$arrayMonth) ?></div>
        </div>
    <?php
    echo ' <div></div>';
    echo '</div>';
    ?>

</div>
<script>
    var id_page = <?= Yii::$app->request->get('id') ?>;
</script>

<?php
$js = <<< JS

$('.confirmation').on('click',function (e){
    var new_button = $('#'+$(this).prop('id')+'')
     var next_mounth = 0;
    confirmationGps($(this).prop('id'),new_button);
})
$('.verified').on('click',function (e){
    verifiedGps($(this).prop('id'));
})

$('.delete').on('click',function (e){
    deleteTracking($(this).data('id'));
    // verifiedGps();
})

function confirmationGps(mounth,new_button) {
     var csrfToken = $('meta[name="csrf-token"]').attr("content"); //создаем CSRF токен
     $.ajax({
        url: '/lu/gps-tracking/confirmation-gps',
        type: 'POST',
        context: this,
        data: {'month' : mounth,'id_page': id_page,  _csrf :  csrfToken },
        success: function(data){ // удачное завершение запроса к серверу, в переменной data ответ сервера
            next_mounth = ++mounth;
            if (next_mounth == 9)
                $('#'+ --mounth+'').replaceWith('<p class ="confirmation" id="'+mounth+'">'+data+'</p>');
            else {
                $('#'+ --mounth+'').parent().append(data)
                $('.'+next_mounth+'').html('').append(new_button);
                $('.confirmation').prop('id',next_mounth);
            }
        },
        error: function(){
          console.log('функция сломалась');
        }
     });
}
function verifiedGps(mounth) {
     var csrfToken = $('meta[name="csrf-token"]').attr("content"); //создаем CSRF токен
     $.ajax({
        url: '/lu/gps-tracking/verified-gps',
        type: 'POST',
        context: this,
        data: {'month' : mounth,'id_page': id_page,  _csrf :  csrfToken },
        success: function(data){ // удачное завершение запроса к серверу, в переменной data ответ сервера
            $('#'+mounth+'').remove();
        },
        error: function(){
          console.log('функция сломалась');
        }
     });
}
function deleteTracking(mounth) {
     var csrfToken = $('meta[name="csrf-token"]').attr("content"); //создаем CSRF токен
     $.ajax({
        url: '/lu/gps-tracking/delete-tracking',
        type: 'POST',
        context: this,
        data: {'month' : mounth,'id_page': id_page,  _csrf :  csrfToken },
        success: function(data){ // удачное завершение запроса к серверу, в переменной data ответ сервера
            $('.delete[data-id="'+mounth+'"]').replaceWith('<p class = "btn">Успешно</p>');
           
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