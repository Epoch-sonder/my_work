<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pd\models\PdWorktype */

$this->title = 'Создание типа работ по проектированию';
$this->params['breadcrumbs'][] = ['label' => 'Наименования работ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pd-worktype-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
