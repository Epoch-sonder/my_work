<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OoptBinding */

$this->title = 'Update Oopt Binding: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Oopt Bindings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="oopt-binding-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    <script> var municUpdate = '<?= $model['munic']?>'; </script>

</div>
<?php



$js = <<< JS
 changeMunic(municUpdate);
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($js, yii\web\View::POS_END);
?>
