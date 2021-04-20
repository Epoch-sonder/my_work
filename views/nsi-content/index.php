<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchNsiContent */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Содержание НСИ справочников';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nsi-content-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p> 
        <?= Html::a('Добавить новую запись', ['create'], ['class' => 'btn btn-success']) ?>

        <?= Html::a('Информация о справочниках', ['nsi-info/index'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
    //     $str = '        00003   00110000    ВОДООХРАННЫЕ ЛЕСА';
    //     $cod = substr($str, 8, 5);
    //     $class = substr($str, 16, 8);
    //     $name = substr($str, 28);
    //     echo $str;
    //     echo '<br>';
    //     echo $cod;
    //     echo '<br>';
    //     echo $class;
    //     echo '<br>';
    //     echo $name;
    //     $str1 = ' 0000300001101НАСАЖД.ЕСТЕСТВ.ПРОИСХ.
    // 0000500001103НАС.РАС.УСЛ-СПЛ РУБ.
    // 0000700001105НАС.В СТАДИИ РЕКОН.
    // 0000900001107НАС.С Л\К ПОД ПОЛОГ.
    // 0001000001108КУЛЬТУРЫ ЛЕСНЫЕ';
    //     echo '<br>';
    //     echo $str1;
    //     $lines = explode("\n", $str1); 

    //     foreach ($lines as $line) {
    //         $notspace = trim($line);
    //         $cod1 = substr($notspace, 0, 5);
    //         $class1 = substr($notspace, 5, 8);
    //         $name1 = substr($notspace, 13);
    //         echo '<br>';
    //         echo $cod1;
    //         echo '<br>';
    //         echo $class1;
    //         echo '<br>';
    //         echo $name1;

    //     }

    // $file = file_get_contents('10200090.000');

    // echo $file;

   /* $file = 'С   0145800100100СОСНА
Е   0049100100200ЕЛЬ
П   0115200100300ПИХТА
Л   0092900100400ЛИСТВЕННИЦА
К   0071800100500КЕДР
Д   0046800202000ДУБ
Я   0175800202300ЯСЕНЬ
КЛ  0076900202400КЛЕН
В   0032000202500ВЯЗ
ИЛ  0033000202550ИЛЬМ
Б   0013200302600БЕРЕЗА
ОС  0111400304000ОСИНА
ОЛС 0108900304105ОЛЬХА СЕРАЯ
ОЛЧ 0109800304110ОЛЬХА ЧЕРНАЯ
ЛП  0090800304200ЛИПА
Т   0154000304300ТОПОЛЬ
ТБ  0154200304305ТОПОЛЬ БЕЛЫЙ
ТЧ  0155700304345ТОПОЛЬ ЧЕРНЫЙ
ИВ  0058200304400ИВА ДРЕВОВИД.
ЧЗ  0168100304500ЧОЗЕНИЯ
Р   0129100511800РЯБИНА
ЧР  0166000512800ЧЕРЕМУХА
ЯБ  0174100513400ЯБЛОНЯ
ВШН 0028500508700ВИШНЯ
ИР  0063300820700ИРГА
ИВК 0059200804330ИВА КУСТАРНИК.
ШЛ  0059600804335ШЕЛЮГА
ЕРН 0015400802694ЕРНИК
ОЛХ 0109200504025ОЛЬХОВНИК
БЯР 0021500818400БОЯРЫШНИК
БЗ  0024500818600БУЗИНА
ДР  0042100819700ДЕРЕН
Ж   0054000820400ЖИМОЛОСТЬ
КЛН 0064200820800КАЛИНА
ОБЛ 0108200823100ОБЛЕПИХА
КСТ 0072200700510КЕДРОВЫЙ СТЛАН.
М   0098600822600МАЛИНА
МЖ  0103700700600МОЖЖЕВЕЛЬНИК
РД  0124500824100РОДОДЕНДРОН
СМ  0141400825100СМОРОДИНА
СПР 0149500825500СПИРЕЯ
ШП  0126000824200ШИПОВНИК
СМК 0142300825123СМОРОДИНА КРАС.
СМЧ 0143500825143СМОРОДИНА ЧЕРН.
СМЗ 0142100825118СМОРОДИНА ЗОЛОТ.
КРЛ 0082300821510КРУШИНА ЛОМКАЯ
РК  0122900824000РАКИТНИК
СИР 0138300824800СИРЕНЬ
АЖ  0066900821010АКАЦИЯ ЖЕЛТАЯ ';*/


        // $lines = explode("\n", $file);

        // echo '<pre>';
        // var_dump($lines);
        // echo '</pre>';

        // foreach ($lines as $line) {
        //     $notspace = trim($line);
        //     $sokr = substr($notspace, 0, 4);
        //     $cod1 = substr($notspace, 5, 5);
        //     $class1 = substr($notspace, 10, 8);
        //     $name1 = substr($notspace, 18);
        //     echo '<br>';
        //     echo $sokr;
        //     echo '<br>';
        //     echo $cod1;
        //     echo '<br>';
        //     echo $class1;
        //     echo '<br>';
        //     echo $name1;

        // }


 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'soli_id',
            'class',
            'cod',
            'attr_textval',
            // 'class_01',
            // 'cod_01',
            // 'class_02',
            // 'cod_02',
            // 'class_03',
            // 'cod_03',
            // 'class_04',
            // 'cod_04',
            // 'class_05',
            // 'cod_05',
            // 'class_06',
            // 'cod_06',
            // 'class_07',
            // 'cod_07',
            // 'class_08',
            // 'cod_08',
            // 'class_09',
            // 'cod_09',
            // 'class_10',
            // 'cod_10',
            // 'class_11',
            // 'cod_11',
            // 'class_12',
            // 'cod_12',
            // 'class_13',
            // 'cod_13',
            // 'class_14',
            // 'cod_14',
            // 'class_15',
            // 'cod_15',
            // 'class_16',
            // 'cod_16',
            // 'class_17',
            // 'cod_17',
            // 'class_18',
            // 'cod_18',
            // 'class_19',
            // 'cod_19',
            // 'class_20',
            // 'cod_20',
            // 'class_21',
            // 'cod_21',
            // 'class_22',
            // 'cod_22',
            // 'class_23',
            // 'cod_23',
            // 'class_24',
            // 'cod_24',
            // 'class_25',
            // 'cod_25',
            // 'class_26',
            // 'cod_26',
            // 'class_27',
            // 'cod_27',
            // 'class_28',
            // 'cod_28',
            // 'class_29',
            // 'cod_29',
            // 'class_30',
            // 'cod_30',
            // 'class_31',
            // 'cod_31',
            // 'class_32',
            // 'cod_32',
            // 'class_33',
            // 'cod_33',
            // 'class_34',
            // 'cod_34',
            // 'class_35',
            // 'cod_35',
            // 'class_36',
            // 'cod_36',
            // 'class_37',
            // 'cod_37',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
