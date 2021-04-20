<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\lu\models\ZakupCard;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\LuObject */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Lu Objects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="lu-object-view">

    <h1>объект с ID <?= $model->id ?> (ID закупки <?= $model->zakup ?> )</h1>
    <p>
        <?= Html::a('<- вернуться к закупке', ['index', 'zakup' => $model->zakup], ['class' => 'btn btn-primary']) ?>

        <?= Html::a('Изменить', ['update', 'id' => $model->id, 'zakup' => $model->zakup], ['class' => 'btn btn-primary']) ?>
        

        <?php /*= Html::a('Удалить', ['delete', 'id' => $model->id, 'zakup' => $model->zakup], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) */?>
    </p>

    <?php /*= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'zakup',
            'land_cat',
            'fed_subject',
            'region',
            'region_subdiv',
            'taxation_way',
            'taxwork_cat',
            'taxwork_vol',
            'stage_prepare_vol',
            'stage_prepare_year',
            'stage_field_vol',
            'stage_field_year',
            'stage_cameral_vol',
            'stage_cameral_year',
        ],
    ]) */?>


    <table id="w1" class="table table-striped table-bordered detail-view">
        <!-- <tr><th><?= $model->getAttributeLabel('id') ?></th><td><?= $model->id ?></td></tr> -->
        <!-- <tr><th><?= $model->getAttributeLabel('zakup') ?></th><td><?= $model->zakup ?></td></tr> -->
        <tr><th><?= $model->getAttributeLabel('landCatName') ?></th><td><?= $model->landCatName ?></td></tr>
        <tr><th><?= $model->getAttributeLabel('fedSubjectName') ?></th><td><?= $model->fedSubjectName ?></td></tr>
        <tr>
            <?php
                    if($model->land_cat == 1 || $model->land_cat == 2) echo '<th>Лесничество</th><td>'.$model->forestryName.'</td>';
                    elseif($model->land_cat == 3) echo '<th>Район</th><td>Район</td>';
                    elseif($model->land_cat == 4) echo '<th>ООПТ</th><td>ООПТ</td>';
                    else echo '<th>Лесничество</th><td>какая-то территория</td>';
            ?>                    
        </tr>
        <tr>
            <?php
                    if($model->land_cat == 1 || $model->land_cat == 2) echo '<th>уч. лесничество</th><td>'.$model->subforestryName.'</td>';
                    elseif($model->land_cat == 3) echo '<th>Район</th><td>Район</td>';
                    elseif($model->land_cat == 4) echo '<th>ООПТ</th><td>ООПТ</td>';
                    else echo '<th>уч. лесничество</th><td>какая-то территория</td>';
            ?>
    </table>

    <table id="w2" class="table table-striped table-bordered detail-view">
        <tr>
            <th><?= $model->getAttributeLabel('taxationWayName') ?></th>
            <th><?= $model->getAttributeLabel('taxworkCatName') ?></th>
            <th><?= $model->getAttributeLabel('taxwork_vol') ?></th>
        </tr>    
        <tr>
            <td><?= $model->taxationWayName ?></td>
            <td><?= $model->taxworkCatName ?></td>
            <td><?= $model->taxwork_vol ?> га</td>
        </tr>
    </table>

    <table id="w3" class="table table-striped table-bordered detail-view">
        <tr>
            <th colspan="2" width="33.3%">Подготовительные работы</th>
            <th colspan="2" width="33.3%">Полевые работы</th>
            <th colspan="2" width="33.3%">Камеральные работы</th>
        </tr>
        <tr>
            <th>объем, га</th><th>год</th>
            <th>объем, га</th><th>год</th>
            <th>объем, га</th><th>год</th>
        </tr>
        <tr>
            <td><?= $model->stage_prepare_vol ?></td><td><?= $model->stage_prepare_year ?></td>
            <td><?= $model->stage_field_vol ?></td><td><?= $model->stage_field_year ?></td>
            <td><?= $model->stage_cameral_vol ?></td><td><?= $model->stage_cameral_year ?></td>
        </tr>
    </table>

<?php
// echo "<pre>";
// var_dump($model->subforestry);
// echo "</pre>";
?>
</div>


    <p>
<?php
// $zakupka = ZakupCard::find()->where(['=', 'id', $model->zakup ])->one();

// echo '<pre>';
// print_r($zakupka);
// echo '</pre>';
?>
    </p>