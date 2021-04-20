<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\forest_work\models\ForestWorkReporter */

$this->title = 'Update Forest Work Reporter: ' . $model->reporter_id;
$this->params['breadcrumbs'][] = ['label' => 'Forest Work Reporters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->reporter_id, 'url' => ['view', 'id' => $model->reporter_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="forest-work-reporter-update">

<div class="forest-work-index">
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
        </div>
      </div>
    </section>

	 <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
            </div>

            <div class="card-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
            </div>
          </div>
        </div>
		</div>
      </div>
    </section>