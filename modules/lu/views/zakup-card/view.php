<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\FileHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\ZakupCard */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Zakup Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="zakup-card-view">

    <?= Html::a('<- список закупок', ['index'], ['class' => 'btn btn-primary']) ?>
    <h1>Закупка <?= Html::encode($model->zakup_num) ?></h1>
     <?php if (\Yii::$app->user->can('lu_zakup_edit')){ ?>
        <p>
            <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php /*= Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) */?>
        </p>
    <?php }?>
    <!-- <script type="text/javascript">
        function divideNumberByPieces(x, delimiter) {
          return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, delimiter || " ");
        }

        $model->price_start = divideNumberByPieces($model->price_start, "-");

    </script> -->

    <?php 
        // Большие числа (в ценах) разделяем пробелами по разрядам для лучшей читаемости
        function numFormat($obj) {
            $n = number_format($obj, 0, "", " ") . ' руб.';
            return $n;
        }

        // $model->price_start = number_format($model->price_start, 0, "", " ");
        // $model->dzz_cost = number_format($model->dzz_cost, 0, "", " ");
        // $model->price_final = number_format($model->price_final, 0, "", " ");
        // $model->price_rli = number_format($model->price_rli, 0, "", " ");

        $model->price_start = numFormat($model->price_start);
        $model->dzz_cost = numFormat($model->dzz_cost);
        $model->price_final = numFormat($model->price_final);
        $model->price_rli = numFormat($model->price_rli);
    ?>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'zakup_num',
            'zakup_link',
            // 'contest_type',
            'contestTypeName',
            'date_placement',
            'price_start',
            // 'finsource_type',
            'finsourceName',
            'customer_name',
            // 'land_cat',
            'landCatName',
            // 'fed_subject',
            'fedSubjectName',
            'region',
            'region_subdiv',
            // 'dzz_type',
            'dzzTypeName',
            'dzz_resolution',
            // 'dzz_request_sent',
            'dzzRequestSent',
            'dzz_control_date',
            'dzz_cost',
            'smp_attraction',

            // 'winner_we',
            'winner_name',
            'price_final',
            'price_rli',
            // 'contract_type',
            'contractTypeName',
            'contract_num',
            'date_contract_start',
            'date_contract_finish',

            // 'timestamp',
        ],
    ]) ?>


    Загруженные документы:<br>

    <?php
        // Выводим список файлов с запросами на КП по ДЗЗ, которые были загружены
        // по этой закупке (если существует такая папка)
        $docdir = 'docs/lu/zakupki/'.$model->zakup_num.'/';

        if (file_exists($docdir)) {
            
            $files=FileHelper::findFiles($docdir, [ 'only' => ['RequestPdDzz*'], 'recursive' => false ]); //'recursive' => true - только в этой папке, не включая вложенные

            echo '<br>Запросы КП по ДЗЗ:<br>';

            if (isset($files[0])) {
                echo '<div class="file_list">';
                    foreach ($files as $index => $file) {
                        $namedoc = substr($file, strrpos($file, '/') + 1);
                        echo '<i class="fas fa-file-pdf"></i> ' . Html::a($namedoc, '/docs/lu/zakupki/'.$model->zakup_num.'/'.$namedoc , ['target'=>'_blank']) . "<br/>";
                    }
                echo '</div>';
            } 
            else {
                // echo "Нет загруженных файлов";
            }


            $files=FileHelper::findFiles($docdir, [ 'only' => ['PdDzz*'], 'recursive' => false ]);
            
            echo '<br>Полученные КП по ДЗЗ:<br>';

            if (isset($files[0])) {
                echo '<div class="file_list">';
                    foreach ($files as $index => $file) {
                        $namedoc = substr($file, strrpos($file, '/') + 1);
                        echo '<i class="fas fa-file-pdf"></i> ' . Html::a($namedoc, '/docs/lu/zakupki/'.$model->zakup_num.'/'.$namedoc , ['target'=>'_blank']) . "<br/>";
                    }
                echo '</div>';
            } 
            else {
                // echo "Нет загруженных файлов";
            }

        } 
    ?>

</div>
