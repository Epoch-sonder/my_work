<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pd\models\SearchPdWork */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Количество разрабатываемой документации по субъектам РФ';
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">

table.cutetable {
  font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
  font-size: 14px;
  background: white;
  max-width: 70%;
  width: 70%;
  width: auto !important;
  border-collapse: collapse;
  text-align: left;
}
table.cutetable th {
  font-weight: normal;
  color: #039;
  color: #363;
  border-bottom: 2px solid #66b178;
  padding: 10px 8px;
}
table.cutetable td {
  color: #669;
  color: #333;
  padding: 9px 8px;
  transition: .3s linear;
  border-bottom: 1px solid #ccc;
}

table.cutetable td.green {font-weight: bold; color: green}
table.cutetable td.red {font-weight: bold; color: #a00}

table.cutetable tr:hover td {color: #6699ff; background: #f0fff0;}

</style>



<div class="pd-work-index">

    <h1><?= Html::encode($this->title) ?></h1>

<?php

// echo "<pre>";
// var_dump($amountdocs);
// echo "</pre>";

echo "Количество субъектов, по которым разрабатывается ПД: <b>" . count($amountdocs) . "</b><br>";
echo "Количество субъектов, по которым ПД не разрабатывается: <b>" . (85 - count($amountdocs)) . "</b><br><br>";

// echo "<br><pre>";
// var_dump($fs);
// echo "</pre>";

// foreach ($amountdocs as $subject => $value) {
// 	echo $subject . ' - ' . $value;
// 	echo "<br>";
// }

?>

<table class="cutetable">
	<tr>
		<th>ID</th>
		<th>Субъект РФ</th>
		<th>Кол-во ПД</th>
	</tr>

<?php

foreach ($fs as $subject) {

	$empty = 0;
	if (!isset($amountdocs[$subject->federal_subject_id])) $empty = 1;
	
	echo "<tr";
	if ($empty) echo ' style="background: #fee"';
	echo "><td>" . $subject->federal_subject_id . '</td><td>' . $subject->name. '</td>';
	if ($empty) echo "<td class='red'>0</td>";
	else echo "<td class='green'>" . $amountdocs[$subject->federal_subject_id] . "</td>";
	echo "</tr>";
}

?>

</table>




    <br><br>

</div>
