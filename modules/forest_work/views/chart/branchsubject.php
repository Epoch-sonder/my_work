<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\ArrayHelper;


$this->title = 'Филиалы и субъекты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forest-work-index">

    <!-- <p>
        <?= Html::a('Добавить отчет', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

 <h1>Филиалы и субъекты:</h1>

<hr>

<?php 

$f = '';
foreach ($subr as $b) {
  if($f != $b->branch->name) echo "<br><b>".$b->branch->branch_id.". ".$b->branch->name."</b><br>";
  $f = $b->branch->name;
    echo " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ".$b->federalSubject->federal_subject_id." ".$b->federalSubject->name."<br>";
}

?>

</div>