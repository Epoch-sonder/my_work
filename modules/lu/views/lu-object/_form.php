<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\LuObject */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lu-object-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'zakup')->hiddenInput(['value' => Yii::$app->request->get('zakup')])->label(false) ?>

    <?= $form->field($model, 'fed_subject')->hiddenInput(['value' => $zakupka->fed_subject])->label(false) ?>

    <?php //= $form->field($model, 'fed_subject')->dropDownList(ArrayHelper::map(app\modules\lu\models\FederalSubject::find()->orderBy('name')->all(), 'federal_subject_id', 'name'), ['options' => [ $zakupka->fed_subject => ['selected' => true] ] ]) ?>

    <?= $form->field($model, 'land_cat')->hiddenInput(['value' => $zakupka->land_cat])->label(false) ?>
    <?php //= $form->field($model, 'land_cat')->dropDownList(ArrayHelper::map(app\modules\lu\models\Land::find()->all(), 'land_id', 'name'), ['options' => [ $zakupka->land_cat => ['selected' => true] ] ]) ?>
    
    <?php

        $label_region = [ 1 => 'Лесничество', 'Лесничество', 'Район', 'ООПТ'];
        $label_region_subdiv = [ 1 => 'Уч. лесничество', 'Уч. лесничество', 'Городские леса', 'Часть ООПТ'];

        $region_source [1] = "ArrayHelper::map(app\modules\lu\models\Forestry::find()->where(['=', 'subject_kod', ".$zakupka->fed_subject."])->all(), 'forestry_kod', 'forestry_name')";
        $region_source [2] = "ArrayHelper::map(app\modules\lu\models\ForestryDefense::find()->where(['=', 'subject_kod', $zakupka->fed_subject])->all(), 'forestry_kod', 'forestry_name')";
        $region_source [3] = "ArrayHelper::map(app\modules\lu\models\Cityregion::find()->where(['=', 'subject_kod', $zakupka->fed_subject])->all(), 'cityregion_kod', 'cityregion_name')";
        $region_source [4] = "ArrayHelper::map(app\models\OoptBinding::find()->where(['=', 'oopt', $zakupka->fed_subject])->all(), 'oopt_kod', 'oopt_name')";
    

        // echo $form->field($model, 'region')->textInput()->label($label_region[$zakupka->land_cat]);
        // echo $form->field($model, 'region_subdiv')->textInput()->label($label_region_subdiv[$zakupka->land_cat]);

        if($zakupka->land_cat == 1) {
            echo $form->field($model, 'region')->dropDownList(ArrayHelper::map(app\modules\lu\models\Forestry::find()->where(['=', 'subject_kod', $zakupka->fed_subject])->all(), 'forestry_kod', 'forestry_name'))->label('Лесничество');
            echo $form->field($model, 'region_subdiv')->dropDownList(ArrayHelper::map(app\modules\lu\models\Subforestry::find()->where(['=', 'subject_kod', $zakupka->fed_subject])->andWhere(['forestry_kod' => $model->region])->all(), 'subforestry_kod', 'subforestry_name'))->label('уч. лесничество');

        } 
        elseif ($zakupka->land_cat == 2) {
            echo $form->field($model, 'region')->dropDownList(ArrayHelper::map(app\modules\lu\models\ForestryDefense::find()->where(['=', 'subject_kod', $zakupka->fed_subject])->all(), 'forestry_kod', 'forestry_name'))->label('Лесничество');

            echo $form->field($model, 'region_subdiv')->dropDownList(ArrayHelper::map(app\modules\lu\models\SubforestryDefense::find()->where(['=', 'subject_kod', $zakupka->fed_subject])->andWhere(['forestry_kod' => $zakupka->region])->all(), 'subforestry_kod', 'subforestry_name'))->label('уч. лесничество');
        }
        elseif ($zakupka->land_cat == 3) {
            echo $form->field($model, 'region')->dropDownList(ArrayHelper::map(app\modules\lu\models\Cityregion::find()->where(['=', 'subject_kod', $zakupka->fed_subject])->all(), 'cityregion_kod', 'cityregion_name'))->label('Район');

            echo $form->field($model, 'region_subdiv')->textInput()->label($label_region_subdiv[$zakupka->land_cat]);
        }
        elseif ($zakupka->land_cat == 4) {
            echo $form->field($model, 'region')->dropDownList(ArrayHelper::map(app\models\OoptBinding::find()->where(['=', 'oopt', $zakupka->fed_subject])->all(), 'oopt_kod', 'oopt_name'))->label('ООПТ');
        }
        
     ?>

    <?php //= $form->field($model, 'taxation_way')->textInput() ?>
    <?php //= $form->field($model, 'taxation_way')->dropDownList(ArrayHelper::map(app\modules\lu\models\TaxationWay::find()->all(), 'id', 'name')) ?>

    <?php //= $form->field($model, 'taxwork_cat')->textInput() ?>
    <?php //= $form->field($model, 'taxwork_cat')->dropDownList(ArrayHelper::map(app\modules\lu\models\TaxworkCategory::find()->all(), 'id', 'category')) ?>

    <?php //= $form->field($model, 'taxwork_vol')->textInput() ?>

    <!-- <table id="w2" class="table table-striped table-bordered">
        <tr>
            <th><?= $model->getAttributeLabel('taxation_way') ?></th>
            <td><?= $form->field($model, 'taxation_way')->dropDownList(ArrayHelper::map(app\modules\lu\models\TaxationWay::find()->all(), 'id', 'name'))->label(false) ?></td>
        </tr>
        <tr>
            <th><?= $model->getAttributeLabel('taxwork_cat') ?></th>
            <td><?= $form->field($model, 'taxwork_cat')->dropDownList(ArrayHelper::map(app\modules\lu\models\TaxworkCategory::find()->all(), 'id', 'category'))->label(false) ?></td>
        </tr>
        <tr>
            <th><?= $model->getAttributeLabel('taxwork_vol') ?></th>
            <td><?= $form->field($model, 'taxwork_vol')->textInput()->label(false) ?></td>
        </tr>
    </table> -->

    

    <?php 
        // echo $form->field($model, 'stage_prepare_year')->dropDownList(['2020' => '2020', '2021' => '2021', '2022' => '2022']);
        // $items = array('2020' => '2020', '2021' => '2021');
        // $items += ['2022' => '2022'];

        // список годов (+/- 5 от текущего)
        $items = array();
        $curyear = date('Y');
        for($y = date('Y')-5; $y <= date('Y') + 5; $y++) {
            // echo $y."<br>";
            $items += [$y => $y];
        }
    ?>

    <?php //= $form->field($model, 'stage_prepare_vol')->textInput() ?>

    <?php //= $form->field($model, 'stage_prepare_year')->textInput() ?>
    <?php //= $form->field($model, 'stage_prepare_year')->dropDownList($items) ?>

    <?php //= $form->field($model, 'stage_field_vol')->textInput() ?>

    <?php //= $form->field($model, 'stage_field_year')->textInput() ?>
    <?php //= $form->field($model, 'stage_field_year')->dropDownList($items) ?>

    <?php //= $form->field($model, 'stage_cameral_vol')->textInput() ?>

    <?php //= $form->field($model, 'stage_cameral_year')->textInput() ?>
    <?php //= $form->field($model, 'stage_cameral_year')->dropDownList($items) ?>

    <table id="w3" class="table table-striped table-bordered detail-view">
        <tr>
            <th rowspan="2" width="15%"><?= $model->getAttributeLabel('taxationWayName') ?></th>
            <th rowspan="2" width="12%"><?= $model->getAttributeLabel('taxworkCatName') ?></th>
            <th rowspan="2" width="10"><?= $model->getAttributeLabel('taxwork_vol') ?></th>
            <th colspan="2">Подготовительные работы</th>
            <th colspan="2">Полевые работы</th>
            <th colspan="2">Камеральные работы</th>
        </tr>
        <tr>
            <th width="10%">объем, га</th><th width="11%">год</th>
            <th width="10%">объем, га</th><th width="11%">год</th>
            <th width="10%">объем, га</th><th width="11%">год</th>
        </tr>
        <tr>
            <td><?= $form->field($model, 'taxation_way')->dropDownList(ArrayHelper::map(app\modules\lu\models\TaxationWay::find()->all(), 'id', 'name'))->label(false) ?></td>
            <td><?= $form->field($model, 'taxwork_cat')->dropDownList(ArrayHelper::map(app\modules\lu\models\TaxworkCategory::find()->all(), 'id', 'category'))->label(false) ?></td>
            <td><?= $form->field($model, 'taxwork_vol')->textInput()->label(false) ?></td>

            <td><?= $form->field($model, 'stage_prepare_vol')->textInput()->label(false) ?></td>
            <td><?= $form->field($model, 'stage_prepare_year')->dropDownList($items, ['options' => [$curyear => ['selected' => true]]])->label(false) ?></td>
            <td><?= $form->field($model, 'stage_field_vol')->textInput()->label(false) ?></td>
            <td><?= $form->field($model, 'stage_field_year')->dropDownList($items, ['options' => [$curyear => ['selected' => true]]])->label(false) ?></td>
            <td><?= $form->field($model, 'stage_cameral_vol')->textInput()->label(false) ?></td>
            <td><?= $form->field($model, 'stage_cameral_year')->dropDownList($items, ['options' => [$curyear => ['selected' => true]]])->label(false) ?></td>
        </tr>
    </table>

    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <script>
        var subId = <?= $zakupka->fed_subject ?>;
        var landCatId = <?= $zakupka->land_cat ?>;
    </script>
    <?php
$js = <<<JS



$('#luobject-region').on('change', function() {
    changeLes(subId , landCatId);
}); 
function changeLes(subId , landCatId) {
    $('#luobject-region option[value=0]').remove();
    var csrfToken = $('meta[name="csrf-token"]').attr("content"); //создаем CSRF токен
    $.ajax({
        url: '/lu/lu-object/change-les',
        type: 'POST',
        data: {'lesId' : $('#luobject-region').val() , 'subId' : subId  , 'landCatId' : landCatId, _csrf :  csrfToken },
        success: function(data){ // удачное завершение запроса к серверу, в переменной data ответ сервера
           $('#luobject-region_subdiv').html(data);
          
        },
      });
}







JS;

$this->registerJs($js, yii\web\View::POS_END);
    ?>

</div>