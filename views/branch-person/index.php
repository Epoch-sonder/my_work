<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchBranchPerson */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Работники филиала';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .overlay {
        width: 100%;
        min-height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px;
        position: fixed;
        top: 0;
        left: 0;
        background: rgba(0, 0, 0, 0.75);
        opacity: 0;
        pointer-events: none;
        transition: 0.35s ease-in-out;
    }

    .overlay.open {
        opacity: 1;
        pointer-events: inherit;
    }

    .overlay .modales {
        background: white;
        text-align: center;
        padding: 40px 80px;
        box-shadow: 0px 1px 10px rgba(255, 255, 255, 0.35);
        opacity: 0;
        pointer-events: none;
        transition: 0.35s ease-in-out;
        max-height: 100%;
        overflow-y: auto;
    }
    .overlay .modales.open {
        opacity: 1;
        pointer-events: inherit;
    }
    .overlay .modales.open .content {
        transform: translate(0, 0px);
        opacity: 1;
    }
    .overlay .modales .content {
      transform: translate(0, -10px);
      opacity: 0;
      transition: 0.35s ease-in-out;
    }

</style>





<?php if (Yii::$app->user->identity->role_id <= '3'){ ?>
<div class='modales' id='modal1'>

    <div class='content'>
         <span class="btn close-modal" data-modal="#modal1"  style="position: relative;top: -45px;float: right;left: 70px;">X</span>
        <h1 class='title' style="margin-bottom: 30px">Очищение от тренировкок у специалиста</h1>

        <div class="row">
            <div class="col-12">
                <input type="checkbox" id="allDelete"> <label for="allDelete">Очистить у всех</label>
            </div>

            <div class="col-12">
                <select id="Branch" class="form-control" >
                    <?php
                    echo '<option value="" selected disabled>-- Выберите филиал --</option>';
                    foreach ($branchList as $branchListOne){
                        echo '<option value="' . $branchListOne['branch_id'] . '">' . $branchListOne['name'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="col-12">
                <select id="ViewPeople" size ='7' class="form-control" multiple="multiple">
                    <option value="NO" selected disabled>-- Не выбрано --</option>
                </select>
            </div>
            <div class="row" style="margin-top: 15px;">
                <div class="col-xs-4">
                     <input type="checkbox" id="training1"> <label for="training1">1-я тренировка</label>
                </div>
                <div class="col-xs-4">
                    <input type="checkbox" id="training2" > <label for="training2">2-я тренировка</label>
                </div>
                <div class="col-xs-4">
                    <input type="checkbox" id="training3"> <label for="training3">3-я тренировка</label>
                </div>
            </div>
            <input type="hidden" id="brigade-person">
            <div class="col-12">
                <a class='btn btn-primary delete-persone' data-modal="#modal1" href="#" style="margin-top:10px ">Удалить</a>
            </div>
        </div>
    </div>
</div>


<?php } ?>


<div class="branch-person-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить работника филиала', ['create'], ['class' => 'btn btn-success']); ?>
        
        <?php if (Yii::$app->user->identity->role_id <= '3') echo '<a href="#" class="open-modal btn btn-primary" data-modal="#modal1">Очищение от тренировок</a>'?>


    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="form-group who_works">
        <label class="control-label" for="who_works">Профессия</label>
        <select class="who_work form-control">
            <option value="0"  >--Не выбрано--</option>;
            <option value="1">Лесоустройство</option>
            <option value="2" >Гил</option>
        </select>
    </div>

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'fio',
        'position',
        'branchName',
//            'education',
//            'experience_specialty',
        'date_admission',
//            'date_dismissial',

        [
            'attribute' => 'date_dismissial',
            'format' => 'raw',
            'filter' => [ "2000-01-01" =>'Уволен'],
            'value' => function($data){
                if ($data->date_dismissial){
                    return 'Уволен';
                }
                else{
                    return '';
                }
            },
        ],

        [
            'attribute' => 'num_brigade',
            'label'=>'В бригаде',
            'format' => 'raw',
            'value' => function($data)  use ($brigageName){
                if ($data->num_brigade){
                    return '<span class="markerGreen">✔ (№'.$brigageName["$data->num_brigade"].')</span>';
                }
                else{
                    return '';
                }
            },

        ],
        [
            'attribute' => 'experience_specialty',
            'label'=>'Стаж работы',
            'value' => function($data){
                if ($data->experience_specialty){
                    return $data->experience_specialty;
                }
                else{
                    return '';
                }
            },
        ],

//        [
//            'attribute' => 'training_process',
//            'label'=>'Тренировка',
//            'format' => 'raw',
//            'value' => function($data) use ($forestgrowName) {
//                if ($data->training_process_1 or $data->training_process_2 or $data->training_process_3){
//                    $tran_process = '';
//                    if ($data->training_process_1){
//                        $tran_process .= $forestgrowName["$data->training_process_1"];
//                    }
//                    if ($data->training_process_2){
//                        $tran_process .= $forestgrowName["$data->training_process_2"].' <br> ' ;
//                    }
//                    if ($data->training_process_3){
//                        $tran_process .=$forestgrowName["$data->training_process_3"];
//                    }
//                    return $tran_process;
//                }
//                else{
//                    return '<span class="markerRed"> • </span>';
//                }
//            },
//
//        ],
        [
            'attribute' => 'experience_work',
            'label'=>'Кол-во сезонов',
            'value' => function($data){
                if ($data->experience_work){
                    return $data->experience_work;
                }
                else{
                    return '';
                }
            },

        ],
        [
            'label'=> 'D',
            'attribute' => 'lu_dzz',
            'filterOptions' => ['class' => 'lu_dzz'],
            'contentOptions'   =>   ['class' => 'lu_dzz', 'style' => 'border-bottom: '],
            'headerOptions'    =>   ['class' => 'lu_dzz' ],
            'format' => 'raw',
             'filter' => [ 1 =>'✔'],
            'value' => function($data){
                if ($data->lu_dzz){
                    return '<span class="markerGreen">✔</span>';
                }
                else{
                    return '';
                }
            },
        ],
        [
            'label'=> 'E',
            'attribute' => 'lu_tax_eye',
            'filterOptions' => ['class' => 'lu_tax_eye'],
            'contentOptions'   =>   ['class' => 'lu_tax_eye', 'style' => 'border-bottom: '],
            'headerOptions'    =>   ['class' => 'lu_tax_eye'],
            'format' => 'raw',
             'filter' => [ 1 =>'✔'],
            'value' => function($data){
                if ($data->lu_tax_eye){
                    return '<span class="markerGreen">✔</span>';
                }
                else{
                    return '';
                }
            },
        ],
        [
            'label'=> 'A',
            'attribute' => 'lu_tax_aero',
            'filterOptions' => ['class' => 'lu_tax_aero'],
            'contentOptions'   =>   ['class' => 'lu_tax_aero', 'style' => 'border-bottom: '],
            'headerOptions'    =>   ['class' => 'lu_tax_aero'],
            'format' => 'raw',
             'filter' => [ 1 =>'✔'],
            'value' => function($data){
                if ($data->lu_tax_aero){
                    return '<span class="markerGreen">✔</span>';
                }
                else{
                    return '';
                }
            },
        ],
        [
            'label'=> 'Ac',
            'attribute' => 'lu_tax_actual',
            'filterOptions' => ['class' => 'lu_tax_actual'],
            'contentOptions'   =>   ['class' => 'lu_tax_actual', 'style' => 'border-bottom: '],
            'headerOptions'    =>   ['class' => 'lu_tax_actual'],
            'format' => 'raw',
             'filter' => [ 1 =>'✔'],
            'value' => function($data){
                if ($data->lu_tax_actual){
                    return '<span class="markerGreen">✔</span>';
                }
                else{
                    return '';
                }
            },
        ],
        [
            'label'=> 'Ca',
            'attribute' => 'lu_cameral1',
            'filterOptions' => ['class' => 'lu_cameral1'],
            'contentOptions'   =>   ['class' => 'lu_cameral1', 'style' => 'border-bottom: '],
            'headerOptions'    =>   ['class' => 'lu_cameral1'],
            'format' => 'raw',
             'filter' => [ 1 =>'✔'],
            'value' => function($data){
                if ($data->lu_cameral1){
                    return '<span class="markerGreen">✔</span>';
                }
                else{
                    return '';
                }
            },
        ],
        [
            'label'=> 'Ca2',
            'attribute' => 'lu_cameral2',
            'filterOptions' => ['class' => 'lu_cameral2'],
            'contentOptions'   =>   ['class' => 'lu_cameral2', 'style' => 'border-bottom: '],
            'headerOptions'    =>   ['class' => 'lu_cameral2'],
            'format' => 'raw',
             'filter' => [ 1 =>'✔'],
            'value' => function($data){
                if ($data->lu_cameral2){
                    return '<span class="markerGreen">✔</span>';
                }
                else{
                    return '';
                }
            },
        ],
        [
            'label'=> 'Pl',
            'attribute' => 'lu_plot_allocation',
            'filterOptions' => ['class' => 'lu_plot_allocation'],
            'contentOptions'   =>   ['class' => 'lu_plot_allocation', 'style' => 'border-bottom: '],
            'headerOptions'    =>   ['class' => 'lu_plot_allocation'],
            'format' => 'raw',
             'filter' => [ 1 =>'✔'],
            'value' => function($data){
                if ($data->lu_plot_allocation){
                    return '<span class="markerGreen">✔</span>';
                }
                else{
                    return '';
                }
            },
        ],
        [
            'label'=> 'In',
            'attribute' => 'lu_park_inventory',
            'filterOptions' => ['class' => 'lu_park_inventory'],
            'contentOptions'   =>   ['class' => 'lu_park_inventory', 'style' => 'border-bottom: '],
            'headerOptions'    =>   ['class' => 'lu_park_inventory'],
            'format' => 'raw',
             'filter' => [ 1 =>'✔'],
            'value' => function($data){
                if ($data->lu_park_inventory){
                    return '<span class="markerGreen">✔</span>';
                }
                else{
                    return '';
                }
            },
        ],
        [
            'label'=> 'Fi',
            'attribute' => 'gil_field',
            'filterOptions' => ['class' => 'gil_field'],
            'contentOptions'   =>   ['class' => 'gil_field', 'style' => 'border-bottom: '],
            'headerOptions'    =>   ['class' => 'gil_field'],
            'format' => 'raw',
             'filter' => [ 1 =>'✔'],
            'value' => function($data){
                if ($data->gil_field){
                    return '<span class="markerGreen">✔</span>';
                }
                else{
                    return '';
                }
            },
        ],
        [
            'label'=> 'Cam',
            'attribute' => 'gil_cameral',
            'filterOptions' => ['class' => 'gil_cameral'],
            'contentOptions'   =>   ['class' => 'gil_cameral', 'style' => 'border-bottom: '],
            'headerOptions'    =>   ['class' => 'gil_cameral'],
            'format' => 'raw',
             'filter' => [ 1 =>'✔'],
            'value' => function($data){
                if ($data->gil_cameral){
                    return '<span class="markerGreen">✔</span>';
                }
                else{
                    return '';
                }
            },
        ],
        [
            'label'=> 'Qu',
            'attribute' => 'gil_ozvl_quality',
            'filterOptions' => ['class' => 'gil_ozvl_quality'],
            'contentOptions'   =>   ['class' => 'gil_ozvl_quality', 'style' => 'border-bottom: '],
            'headerOptions'    =>   ['class' => 'gil_ozvl_quality'],
            'format' => 'raw',
             'filter' => [ 1 =>'✔'],
            'value' => function($data){
                if ($data->gil_ozvl_quality){
                    return '<span class="markerGreen">✔</span>';
                }
                else{
                    return '';
                }
            },
        ],
        [
            'label'=> 'Mo',
            'attribute' => 'gil_remote_monitoring',
            'filterOptions' => ['class' => 'gil_remote_monitoring'],
            'contentOptions'   =>   ['class' => 'gil_remote_monitoring', 'style' => 'border-bottom: '],
            'headerOptions'    =>   ['class' => 'gil_remote_monitoring'],
            'format' => 'raw',
             'filter' => [ 1 =>'✔'],
            'value' => function($data){
                if ($data->gil_remote_monitoring){
                    return '<span class="markerGreen">✔</span>';
                }
                else{
                    return '';
                }
            },
        ],


//            'lu_tax_eye',
//            'lu_tax_aero',
//            'lu_tax_actual',
//            'lu_cameral1',
//            'lu_cameral2',
//            'lu_plot_allocation',
//            'lu_park_inventory',
//            'gil_field',
//            'gil_cameral',
//            'gil_ozvl_quality',
//            'gil_remote_monitoring',


        [
            'class' => 'yii\grid\ActionColumn',
            'header'=>'<span class="glyphicon glyphicon-cog"></span>',
            'template' => '{view} {update} {delete}', // '{view} {update} {delete}',
            'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id < '3',
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header'=>'<span class="glyphicon glyphicon-cog"></span>',
            'template' => '{update}', // '{view} {update} {delete}',
            'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id == '3' or !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id == '4',
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view}' ,
            'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id > '4',

        ]
    ],
]); ?>
    <script>
        if ($('.who_work').val() == 0){
            $( ".gil_field").css('display', 'none');
            $( ".gil_cameral").css('display', 'none');
            $( ".gil_ozvl_quality").css('display', 'none');
            $( ".gil_remote_monitoring").css('display', 'none');
            $( ".lu_dzz").css('display', 'none');
            $( ".lu_tax_aero").css('display', 'none');
            $( ".lu_tax_eye").css('display', 'none');
            $( ".lu_tax_actual").css('display', 'none');
            $( ".lu_cameral1").css('display', 'none');
            $( ".lu_cameral2").css('display', 'none');
            $( ".lu_plot_allocation").css('display', 'none');
            $( ".lu_park_inventory").css('display', 'none');
        }
        if($('.who_work').val() == 1){
            $( ".lu_dzz").css('display', '');
            $( ".lu_tax_eye").css('display', '');
            $( ".lu_tax_actual").css('display', '');
            $( ".lu_cameral1").css('display', '');
            $( ".lu_cameral2").css('display', '');
            $( ".lu_tax_aero").css('display', '');
            $( ".lu_plot_allocation").css('display', '');
            $( ".lu_park_inventory").css('display', '');
            $( ".gil_field").css('display', 'none');
            $( ".gil_cameral").css('display', 'none');
            $( ".gil_ozvl_quality").css('display', 'none');
            $( ".gil_remote_monitoring").css('display', 'none');
        }
        if ($('.who_work').val() == 2){
            $( ".gil_field").css('display', '');
            $( ".gil_cameral").css('display', '');
            $( ".gil_ozvl_quality").css('display', '');
            $( ".gil_remote_monitoring").css('display', '');
            $( ".lu_tax_aero").css('display', 'none');
            $( ".lu_dzz").css('display', 'none');
            $( ".lu_tax_eye").css('display', 'none');
            $( ".lu_tax_actual").css('display', 'none');
            $( ".lu_cameral1").css('display', 'none');
            $( ".lu_cameral2").css('display', 'none');
            $( ".lu_plot_allocation").css('display', 'none');
            $( ".lu_park_inventory").css('display', 'none');
        }

    </script>
    <?php Pjax::end(); ?>




</div>


<?php
$js = <<< JS
$(".modales").each( function(){
	$(this).wrap('<div class="overlay"></div>')
});

$(".open-modal").on('click', function(e){
    $('.glyphicon').css('display', 'none')
	modal = $(this).data("modal");
	$(modal).parents(".overlay").addClass("open");
	$(modal).addClass("open");
});
$('.delete-persone').on('click', function(e){
    var Ydelete = confirm('Уверены что хотите удалить файл?');
       if(Ydelete == true){
           var csrfToken = $('meta[name="csrf-token"]').attr("content"); //создаем CSRF токен
            $.ajax({
                url: '/branch-person/delete-training',
                type: 'POST',
                data: {'people' : $('#brigade-person').val() ,'tran1':$('#training1').prop("checked"),'tran2':$('#training2').prop("checked"),'tran3':$('#training3').prop("checked"), _csrf :  csrfToken  },
                success: function(data){ // удачное завершение запроса к серверу, в переменной data ответ сервера
                    $('.modales').children().html(data);
                },
                error: function(){
                  console.log('функция сломалась');
                }
              });
       }
});
$(".close-modal").on('click', function(){
    $('.glyphicon').css('display', 'block')
	modal = $(".close-modal").data("modal");
	$(modal).removeClass("open");
	$(modal).parents(".overlay").removeClass("open");
});

$('#allDelete').on('click',function (){
 if ($("#allDelete").prop("checked") == true){
     $('#Branch').css('display','none');
     $('#ViewPeople').css('display','none');
     $('#brigade-person').val('666');
 }
 else {
     $('#Branch').css('display','block');
     $('#ViewPeople').css('display','block');
     $('#brigade-person').val('');
     $('#ViewPeople option').prop('selected', false);
 }
});



$('#Branch').on('change',function (){
    var csrfToken = $('meta[name="csrf-token"]').attr("content"); //создаем CSRF токен
    $.ajax({
        url: '/branch-person/view-specialist',
        type: 'POST',
        data: {'branch' : $('#Branch').val() , _csrf :  csrfToken  },
        success: function(data){ // удачное завершение запроса к серверу, в переменной data ответ сервера
         $('#ViewPeople').html(data);
        },
        error: function(){
          console.log('функция сломалась');
        }
      });
});


$('#ViewPeople').on('change',function (){
    var numPeople = $('#ViewPeople').val().join();
    $('#brigade-person').val(numPeople)
});































$( ".lu_dzz").css('display', 'none');
$( ".lu_tax_eye").css('display', 'none');
$( ".lu_tax_aero").css('display', 'none');
$( ".lu_tax_actual").css('display', 'none');
$( ".lu_cameral1").css('display', 'none');
$( ".lu_cameral2").css('display', 'none');
$( ".lu_plot_allocation").css('display', 'none');
$( ".lu_park_inventory").css('display', 'none');
$( ".gil_field").css('display', 'none');
$( ".gil_cameral").css('display', 'none');
$( ".gil_ozvl_quality").css('display', 'none');
$( ".gil_remote_monitoring").css('display', 'none');


$('.who_work').on('change',function (){
    if ($('.who_work').val() == 0){
        $( ".gil_field").css('display', 'none');
        $( ".gil_cameral").css('display', 'none');
        $( ".gil_ozvl_quality").css('display', 'none');
        $( ".gil_remote_monitoring").css('display', 'none');
        $( ".lu_dzz").css('display', 'none');
        $( ".lu_tax_eye").css('display', 'none');
        $( ".lu_tax_actual").css('display', 'none');
        $( ".lu_cameral1").css('display', 'none');
        $( ".lu_cameral2").css('display', 'none');
        $( ".lu_tax_aero").css('display', 'none');
        $( ".lu_plot_allocation").css('display', 'none');
        $( ".lu_park_inventory").css('display', 'none');
       
    }
    if ($('.who_work').val() == 1){
        $( ".lu_dzz").css('display', '');
        $( ".lu_tax_eye").css('display', '');
        $( ".lu_tax_actual").css('display', '');
        $( ".lu_cameral1").css('display', '');
        $( ".lu_cameral2").css('display', '');
        $( ".lu_plot_allocation").css('display', '');
        $( ".lu_park_inventory").css('display', '');
        $( ".gil_field").css('display', 'none');
        $( ".lu_tax_aero").css('display', '');
        $( ".gil_cameral").css('display', 'none');
        $( ".gil_ozvl_quality").css('display', 'none');
        $( ".gil_remote_monitoring").css('display', 'none');
    }
    if ($('.who_work').val() == 2){
        $( ".gil_field").css('display', '');
        $( ".gil_cameral").css('display', '');
        $( ".gil_ozvl_quality").css('display', '');
        $( ".gil_remote_monitoring").css('display', '');
        $( ".lu_dzz").css('display', 'none');
        $( ".lu_tax_aero").css('display', 'none');
        $( ".lu_tax_eye").css('display', 'none');
        $( ".lu_tax_actual").css('display', 'none');
        $( ".lu_cameral1").css('display', 'none');
        $( ".lu_cameral2").css('display', 'none');
        $( ".lu_plot_allocation").css('display', 'none');
        $( ".lu_park_inventory").css('display', 'none');
    }
})


JS;

//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($js, yii\web\View::POS_END);
?>
