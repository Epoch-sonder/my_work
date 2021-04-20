<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\lu\models\SearchVaccination */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Вакцинации';
$this->params['breadcrumbs'][] = $this->title;

$vaccination1 = \app\modules\lu\models\Vaccination::find()->orderBy(['first_vaccination' => SORT_DESC])->all();
$vaccination2 = \app\modules\lu\models\Vaccination::find()->orderBy(['second_vaccination' => SORT_DESC])->all();
$vaccination3 = \app\modules\lu\models\Vaccination::find()->orderBy(['third_vaccination' => SORT_DESC])->all();


?>
<div class="vaccination-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (\Yii::$app->user->can('vaccination_edit')){ ?>
        <p>
            <?= Html::a('Добавление вакцинации', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php }?>
    <?= GridView::widget([
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'branchName',
            'fio',
            'position',
            'division',
//            'firstDate',
//            'secondDate',
//            'thirdDate',
            [
                'attribute' => 'date_one_vaccin',
                'label' => 'Первая вакцина',
                'format' => 'raw',
                'value' => function($data) use ($vaccination1){
                    $vaccin = '';
                    foreach ($vaccination1 as $vaccination){
                        if ($vaccination->person_id == $data->id){
                            if ($vaccination->first_vaccination) {
                                $fileIcon = explode(".", $vaccination->url_docs);
                                if ($fileIcon['1'] == 'pdf') $icon = '<i class="fas fa-file-pdf" style="color: #c00"></i> ';
                                if ($fileIcon['1'] == 'docx') $icon = '<i class="fas fa-file-word"  style="color: #2384e8"></i> ';
                                if ($fileIcon['1'] == 'doc') $icon = '<i class="fas fa-file-word"  style="color: #2384e8"></i> ';

                                $vaccin =  $vaccination->first_vaccination .
                                    ' '. Html::a($icon, '/docs/lu/vaccination/'.$vaccination->url_docs , ['target'=>'_blank']);
                            }
                            break;

                        }
                    }
                    return $vaccin;
                },
            ],
            [
                'attribute' => 'date_two_vaccin',
                'label' => 'Вторая вакцина',
                'format' => 'raw',
                'value' => function($data) use ($vaccination2,$vaccination1){
                    $vaccin = ' ';
                    foreach ($vaccination1 as $vac){
                        if ($vac->person_id == $data->id){
                            if ($vac->first_vaccination ) $vaccinat = $vac->first_vaccination;
                            break;
                        }
                    }
                    foreach ($vaccination2 as $vaccination){
                        if ($vaccination->person_id == $data->id){
                            if ($vaccination->second_vaccination >= $vaccinat) {
                                $fileIcon = explode(".", $vaccination->url_docs);
                                if ($fileIcon['1'] == 'pdf') $icon = '<i class="fas fa-file-pdf" style="color: #c00"></i> ';
                                if ($fileIcon['1'] == 'docx') $icon = '<i class="fas fa-file-word"  style="color: #2384e8"></i> ';
                                if ($fileIcon['1'] == 'doc') $icon = '<i class="fas fa-file-word"  style="color: #2384e8"></i> ';

                                $vaccin =  $vaccination->second_vaccination .
                                    ' '. Html::a($icon, '/docs/lu/vaccination/'.$vaccination->url_docs , ['target'=>'_blank']);
                            }
                            break;
                        }
                    }
                    return $vaccin;
                },
            ],
            [
                'attribute' => 'date_three_vaccin',
                'label' => 'Третья вакцина',
                'format' => 'raw',
                'value' => function($data) use ($vaccination3,$vaccination2,$vaccination1){
                    $vaccin = '';
                    foreach ($vaccination2 as $vac2){
                        if ($vac2->person_id == $data->id){
                            if ($vac2->second_vaccination ) $vaccinat2 = $vac2->second_vaccination;
                            break;
                        }
                    }
                    foreach ($vaccination1 as $vac){
                        if ($vac->person_id == $data->id){
                            if ($vac->first_vaccination ) $vaccinat = $vac->first_vaccination;
                            break;
                        }
                    }
                    foreach ($vaccination3 as $vaccination){
                        if ($vaccination->person_id == $data->id){
                            if (!isset($vaccinat2)) $vaccinat2 = 0;
                            if (!isset($vaccinat)) $vaccinat = 0;
                            if ($vaccination->third_vaccination >= $vaccinat2 and $vaccination->third_vaccination >= $vaccinat) {
                                $fileIcon = explode(".", $vaccination->url_docs);
                                if ($fileIcon['1'] == 'pdf') $icon = '<i class="fas fa-file-pdf" style="color: #c00"></i> ';
                                if ($fileIcon['1'] == 'docx') $icon = '<i class="fas fa-file-word"  style="color: #2384e8"></i> ';
                                if ($fileIcon['1'] == 'doc') $icon = '<i class="fas fa-file-word"  style="color: #2384e8"></i> ';

                                $vaccin =  $vaccination->third_vaccination .
                                    ' '. Html::a($icon, '/docs/lu/vaccination/'.$vaccination->url_docs , ['target'=>'_blank']);
                            }

                            break;
                        }
                    }
                    return $vaccin;
                },
            ],
            [
                'attribute' => 'future_vaccin',
                'label' => 'Будущая вакцина',
                'format' => 'raw',
                'value' => function($data){
//                    $vaccin = '';
                    $futuredate = '';
                    if (isset($data->thirdDate)) {
                        $futuredate = new \DateTime($data->thirdDate);
                        $futuredate = $futuredate->modify('+3 year')->format('Y-m-d');

                        $dateDefold = new \DateTime(date_default_timezone_get());
                        $dataDefold = $dateDefold->format('Y-m-d');

                        if ($dataDefold <= $futuredate ) $span = '<span style="color:green;">';
                        elseif ($dataDefold > $futuredate and $futuredate <= $data->firstDate or
                                $dataDefold > $futuredate and $futuredate <= $data->secondDate)
                             $span = '<span style="color:orange;">';
                        else $span = '<span style="color:red;">';
                        $futuredate = $span . $futuredate . '</span>';
                    }
                    return $futuredate;
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}' ,
                'visible' => !Yii::$app->user->isGuest ,
//                    && Yii::$app->user->identity->role_id > '3',
            ],
        ],
    ]); ?>


</div>
