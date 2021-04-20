<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\lu\models\Vaccination */

$this->title = 'Просмотр вакцины '.$branchPerson["fio"];
$this->params['breadcrumbs'][] = ['label' => 'Vaccinations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
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
        width: 125px;
        margin: 10px 0px 5px 6px;
        display: inline-block;
    }
    .Text{
        margin: 10px 0px 5px 6px;
        display: inline-block;
    }
    .leftfloat , .rightfloat{
        widows: revert;
        margin: 0px;
    }
    .floatNo{
        width: 100%;
        margin: 0px 0px 0px 20px;
    }
    .statement span,
    .taxCard span,
    .floatNo span {
        display: none;
    }
</style>

<div class="vaccination-view">
    <p>
        <?= Html::a('<- вернуться к списку вакцин', ['../lu/vaccination/' ], ['class' => 'btn btn-primary']); ?>
    </p>
    <h3><?= Html::encode($this->title) ?></h3>
<?php
    echo '<div style="width:100%" class="div"> ';

    echo '<div class="greyDiv" style="width: 100%; float: left;"><h4>Первая вакцина весной (март, апрель): </h4></div>';
    foreach ($vaccinations as $vaccination){
        if ($vaccination["first_vaccination"]){

            $dateMonth = new \DateTime($vaccination["first_vaccination"]);
            $dateMonthd = $dateMonth->format('d');
            $dateMonthm = $dateMonth->format('n');
            $dateMonthy = $dateMonth->format('Y');
            $dateMonthm = $arrayMonthR[$dateMonthm];

            $fileIcon = explode(".", $vaccination->url_docs);
            if ($fileIcon['1'] == 'pdf') $icon = '<i class="fas fa-file-pdf" style="color: #c00"> Файл по вакцине</i> ';
            if ($fileIcon['1'] == 'docx') $icon = '<i class="fas fa-file-word"  style="color: #2384e8"> Файл по вакцине</i> ';
            if ($fileIcon['1'] == 'doc') $icon = '<i class="fas fa-file-word"  style="color: #2384e8"> Файл по вакцине</i> ';


            echo '<div><h5 class="textBold">'.$dateMonthd.' '.$dateMonthm.' '.$dateMonthy.'<h5 class="Text">'.
                Html::a($icon, '/docs/lu/vaccination/'.$vaccination->url_docs , ['target'=>'_blank'])
                .'</h5></h5></div>' ;
        }
    }
    echo '<div class="greyDiv"><h4>Вторая вакцина: </h4></div>';

    foreach ($vaccinations as $vaccination){
        if ($vaccination["second_vaccination"]){

            $dateMonth = new \DateTime($vaccination["second_vaccination"]);
            $dateMonthd = $dateMonth->format('d');
            $dateMonthm = $dateMonth->format('n');
            $dateMonthy = $dateMonth->format('Y');
            $dateMonthm = $arrayMonthR[$dateMonthm];


            $fileIcon = explode(".", $vaccination->url_docs);
            if ($fileIcon['1'] == 'pdf') $icon = '<i class="fas fa-file-pdf" style="color: #c00"> Файл по вакцине</i> ';
            if ($fileIcon['1'] == 'docx') $icon = '<i class="fas fa-file-word"  style="color: #2384e8"> Файл по вакцине</i> ';
            if ($fileIcon['1'] == 'doc') $icon = '<i class="fas fa-file-word"  style="color: #2384e8"> Файл по вакцине</i> ';


            echo '<div><h5 class="textBold">'.$dateMonthd.' '.$dateMonthm.' '.$dateMonthy.'<h5 class="Text">'.
                Html::a($icon, '/docs/lu/vaccination/'.$vaccination->url_docs , ['target'=>'_blank'])
            .'</h5></h5></div>' ;
        }
    }

    echo '<div class="greyDiv"><h4>Третья вакцина: </h4></div>';
    foreach ($vaccinations as $vaccination){
        if ($vaccination["third_vaccination"]){

            $dateMonth = new \DateTime($vaccination["third_vaccination"]);
            $dateMonthd = $dateMonth->format('d');
            $dateMonthm = $dateMonth->format('n');
            $dateMonthy = $dateMonth->format('Y');
            $dateMonthm = $arrayMonthR[$dateMonthm];

            $fileIcon = explode(".", $vaccination->url_docs);
            if ($fileIcon['1'] == 'pdf') $icon = '<i class="fas fa-file-pdf" style="color: #c00"> Файл по вакцине</i> ';
            if ($fileIcon['1'] == 'docx') $icon = '<i class="fas fa-file-word"  style="color: #2384e8"> Файл по вакцине</i> ';
            if ($fileIcon['1'] == 'doc') $icon = '<i class="fas fa-file-word"  style="color: #2384e8"> Файл по вакцине</i> ';


            echo '<div><h5 class="textBold">'.$dateMonthd.' '.$dateMonthm.' '.$dateMonthy.'<h5 class="Text">'.
                Html::a($icon, '/docs/lu/vaccination/'.$vaccination->url_docs , ['target'=>'_blank'])
                .'</h5></h5></div>' ;
        }
    }
    echo '</div>';





?>


</div>
