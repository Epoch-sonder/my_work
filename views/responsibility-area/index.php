<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchResponsibilityArea */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Зоны ответственности филиалов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="responsibility-area-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить Субъект РФ в зону ответственности филиала', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'responsibility_area_id',
            'federal_subject_id',
            'federalSubjectName',
            'invert',
            [
                'label' => 'Invert',
                'attribute'=>'invert',
                // 'value' => function($data){
                //     return \app\models\ResponsibilityArea::getInvert();
                // },
                // 'value' => $dataProvider->url,
            ],
            'branch_id',
            'branchName',
            // 'with_order',
            [
                /*** Название поля модели */
                'attribute' => 'with_order',
                /*** Формат вывода.
                 * В этом случае мы отображает данные, как передали.
                 * По умолчанию все данные прогоняются через Html::encode() */
                'format' => 'raw',
                /*** Переопределяем отображение фильтра.
                 * Задаем выпадающий список с заданными значениями вместо поля для ввода */
                'filter' => [
                    0 => 'No',
                    1 => 'Yes',
                ],
                /*** Переопределяем отображение самих данных.
                 * Вместо 1 или 0 выводим Yes или No соответственно.
                 * Попутно оборачиваем результат в span с нужным классом */
                'value' => function ($model, $key, $index, $column) {
                    $active = $model->{$column->attribute} === 1;
                    return \yii\helpers\Html::tag(
                        'span',
                        $active ? 'Yes' : 'No',
                        [
                            'class' => 'label label-' . ($active ? 'success' : 'danger'),
                        ]
                    );
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); 

echo "<pre>";
// print_r($dataProvider);
// $mod = \app\models\ResponsibilityArea::find()->asArray()->all();
// print_r($mod);
echo "</pre>";
    ?>


</div>
