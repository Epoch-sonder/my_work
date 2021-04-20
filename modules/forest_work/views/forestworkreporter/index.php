<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Сотрудники';
?>
<div class="forest-work-reporter-index">

    <p>
        <?= Html::a('Добавить карточку сотрудника', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?php $dataProvider->sort->defaultOrder = ['reporter_id' => SORT_DESC]; ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'reporter_id',
            'reporter_fio',
            'reporter_position',
            'reporter_tel',
            [
                'attribute' => 'reporter_branch',
                'label' => 'Филиал',
                'value' => 'reporterBranch.name',
            ],
			//'reporterBranch.name',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
