<?php

use app\models\CaCurator;
use app\modules\pd\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

$work_completed = $model->completed;
if ($model->fact_datefinish == null){
    $datecompleted = date('Y-m-d');
}
else{
    $datecompleted = $model->fact_datefinish ;
}

?>

<div class="pd-work-form">


<?php




$userID = Yii::$app->user->identity->id;
$condUser = 'id = '.$userID;
$branchID = Yii::$app->user->identity->branch_id;

if($branchID != 0) $condBranch = 'branch_id = '.$branchID;
else $condBranch = '';


//$curators_branch = CaCurator::find()->select(['person_kod', 'branch_kod'])->all();
//var_dump($curators_branch);
//$id_curators = array_column($curators_branch, 'person_kod');
//$id_curators = array_unique($id_curators);
//$users_name = User::find()->where(['in', 'id', $id_curators])->all();

//foreach ($curators_branch as $curators_branch){
//    if ($curators_branch['branch_kod'] == 17){
//        foreach ($users_name as $user_name){
//            if ($user_name['id'] == $curators_branch['person_kod']){
//                var_dump($user_name->fio);
//            }
//        }
//    }
//}




?>

    <?php $form = ActiveForm::begin(); ?>

    <?php //= $form->field($model, 'id')->textInput() ?>

<div <?= $model->warning == 0 ? "class='hide'" : "" ?>>
    <?= $form->field($model, 'warning')->checkbox() ?>
    <?php //= $form->field($model, 'warning_descr')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'warning_descr')->textarea(['rows' => 6, 'cols' => 20]) ?>
</div>

    <?= $form->field($model, 'branch')->dropDownList(ArrayHelper::map(app\modules\pd\models\Branch::find()->where($condBranch)->orderBy(['name' => SORT_ASC])->all(), 'branch_id', 'name')) ?>

    <?= $form->field($model, 'executor')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'branch')->textInput() ?>
    
    <?= $form->field($model, 'customer')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'basedoc_type')->textInput() ?>
    <?= $form->field($model, 'basedoc_type')->dropDownList(ArrayHelper::map(app\modules\pd\models\BasedocType::find()->all(), 'id', 'doctype')) ?>

    <?= $form->field($model, 'basedoc_name')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'basedoc_datasign')->widget(DatePicker::classname(),
	[
	'language' => 'ru-RU',
    'removeButton' => false,
	'pluginOptions' => [
		'autoclose' => true,
		'format' => 'yyyy-mm-dd',
        // 'format' => 'dd-mm-yyyy',
		'todayHighlight' => true,
        'orientation' => 'top right',
		]
		]);
	?>


    <?php //= $form->field($model, 'basedoc_datefinish')->textInput() ?>
    <?= $form->field($model, 'basedoc_datefinish')->widget(DatePicker::classname(),
    [
    'language' => 'ru-RU',
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        'orientation' => 'top right',
        ]
        ]);
    ?>

    <?php
    $nameCurator = Null;


        if (Yii::$app->user->identity->branch_id == 0) {

            echo '<hr class="greenline"> <div style="width: 100%; float: left">' . $form->field($model, 'signed_by_ca')->checkbox() ;
            echo '<div class ="field-pdwork-name_Branch"><h5 style="margin: 0; " class="nameBranch"> </h5></div></div>';
            echo '<div style="width: 100%; float: left">' . $form->field($model, 'rli_order_num')->label('Приказ номер')->textInput();

            echo $form->field($model, 'data_order')->widget(DatePicker::classname(),
                [
                    'language' => 'ru-RU',
                    'removeButton' => false,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,
                        'orientation' => 'top right',
                    ]
                ])->label('дата') . '</div>  <hr class="greenline">';
        }
    ?>

    <?= $form->field($model, 'work_cost')->textInput() ?>

    <?php //= $form->field($model, 'work_datastart')->textInput() ?>
    <?= $form->field($model, 'work_datastart')->widget(DatePicker::classname(),
    [
    'language' => 'ru-RU',
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        'orientation' => 'top right',
        ]
        ]);
    ?>

    <?= $form->field($model, 'work_name')->dropDownList(ArrayHelper::map(app\modules\pd\models\PdworkType::find()->all(), 'id', 'work_name')) ?>
    <?= $form->field($model, 'work_othername')->textInput(['value' => ':']) ?>
    <?= $form->field($model, 'in_complex')->checkbox(['id' => 'in_complex']) ?>

    <?php //= $form->field($model, 'federal_subject')->textInput() ?>
    <?= $form->field($model, 'federal_subject')->dropDownList(ArrayHelper::map(app\modules\pd\models\ResponsibilityArea::find()->joinWith('federalSubject')->where($condBranch)->orderBy(['federal_subject.name' => SORT_ASC])->all(), 'federal_subject_id', 'federalSubject.name')) ?>

    <div id="pd_forestry" style="clear: both; display: none">
            <?php // $form->field($model, 'forestry')->textInput() ?>
            <!-- Отмечены --> 
            <?= $form->field($model, 'forestry')->hiddenInput()->label(false); ?>
            <?= $form->field($model, 'forestry_quantity')->hiddenInput()->label(false); ?>
        <p id="total_forestry" style="color: #000;">
            <strong>Лесничества</strong> (всего отмечено: <span>0</span>)<br>
            &nbsp;&nbsp;&nbsp;
            <label style="color: #88C86F"><input type="checkbox" id="check_all"> Отметить/cнять все</label>
        </p>

        <div id="pd_forestry_list"></div>
        
    </div>

    <?php //= $form->field($model, 'subforestry')->textInput() ?>
    <?php //= $form->field($model, 'subdivforestry')->textInput() ?>
    <?php //= $form->field($model, 'quarter')->textInput() ?>
    <?php //= $form->field($model, 'forest_usage')->textInput() ?>

    <?= $form->field($model, 'work_area')->textInput() ?>
    
    <?= $form->field($model, 'forest_usage')->dropDownList(ArrayHelper::map(app\modules\pd\models\ForestUsage::find()->all(), 'id', 'usage_name')) ?>

    <?= $form->field($model, 'work_reason')->dropDownList(ArrayHelper::map(app\modules\pd\models\PdWorkReason::find()->all(), 'id', 'reason')) ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 3, 'cols' => 5]) ?>

    <?php //= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>
    <?php //= $form->field($model, 'timestamp')->textInput() ?>

    <?= $form->field($model, 'remark')->textInput()->label('Примечания (необязательное поле, для собственных пометок)') ?>
    <?php if (Yii::$app->request->get('id')){?>


    <?= $form->field($model, 'completed')->checkbox() ?>

    <?= $form->field($model, 'fact_datefinish')->widget(DatePicker::classname(),
        [
            'language' => 'ru-RU',
            'removeButton' => false,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true,
                'orientation' => 'top right',
            ]
        ]);
    ?>
    <?php }?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success btn-completed']) ?>
    </div>

    <?php ActiveForm::end();?>



    <?php // передаем в переменные JS значения массива PHP ?>
    <script type='text/javascript'>
      var userName = <?= json_encode($id_userCur) ?> ;
      var curBranch = <?= json_encode($id_branch_curators) ?>;
      var WorkCheckId = <?= $work_completed ?>;
      var CompletedDate = '<?= $datecompleted  ?>';
    </script>

    <?php
$js = <<< JS
curatorFio()
// $('.field-pdwork-fact_datefinish').css('display','none');
$('#pdwork-completed').on('change', function() {
    // $('.field-pdwork-fact_datefinish').toggle();
    if (this.checked) {
        $('.field-pdwork-fact_datefinish').css('display','block');
        $('#pdwork-fact_datefinish').val(CompletedDate); //если выбрано не филиал, то в списке филиалов добавляертся ещё один пункт, и он и выводится
    } 
    else {
       $('.field-pdwork-fact_datefinish').css('display','none');
        $('#pdwork-fact_datefinish').val('');
    }
});
if (WorkCheckId != 1){
    $('.field-pdwork-fact_datefinish').css('display','none');
}

$('.field-pdwork-branch').on('change', function() {
curatorFio()
});

$('.btn-completed').on('click', function() {
     if ($('#pdwork-completed').prop('checked')) {
         if ( $('#pdwork-fact_datefinish').val().trim())return true;
         else $('#pdwork-fact_datefinish').val(CompletedDate);
        //если выбрано не филиал, то в списке филиалов добавляертся ещё один пункт, и он и выводится
    } 
    else $('#pdwork-fact_datefinish').val('');
});
// С помощью значение id pdwork-branch находим номер куратора
// далее по номеру куратора ищем имя куратора и заменяем класс nameBranch полученным FIO
function curatorFio() {
    $('.nameBranch').text('(Куратор ЦА - ' + userName[ curBranch[ $('#pdwork-branch').val()] ]  + ')' );
}
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($js, yii\web\View::POS_END);
?>


</div>
