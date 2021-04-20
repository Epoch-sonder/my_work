<?php

use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\modules\pd\models\PdWorkProcess */

$this->title = 'Отчеты о ходе работ';
$this->params['breadcrumbs'][] = ['label' => 'Pd Work Processes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$pd_url = Yii::$app->session->get('pd_url');
?>
<div class="pd-work-process-create">
<style>
    pre{
        display: none;
    }
</style>
    <?php //= Html::a('<- к общему списку', ['pd-work/index'], ['class' => 'btn btn-primary',        'data-method' => 'POST', 'data-params' => ['pd_work' => Yii::$app->request->post('pd_work')]])?>
    <a href="<?=$pd_url?>" class="btn btn-primary"><- к общему списку</a>
    <?php
    if (\Yii::$app->user->can('pd_ca') or \Yii::$app->user->can('pd_edit'))
        echo Html::a('Карточка проекта', ['pd-work/update', 'id' => Yii::$app->request->get('pd_work')], ['class' => 'btn btn-primary']);
    else
        echo Html::a('Карточка проекта', ['pd-work/view', 'id' => Yii::$app->request->get('pd_work')], ['class' => 'btn btn-primary']);
    ?>
    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

<br><br>
    <p>
        <?php
            // $service = Service::findOne($id); 
            if(isset($pdwork)) {
                echo '<strong>Наименование документации:</strong> ' . $pdwork->pdworktype->work_name 
                //. '<br><strong>Филиал:</strong> ' . $pdwork->branchname->name 
                . '<br><strong>Заказчик:</strong> ' . $pdwork->customer
                //. '<br>' . $pdwork->docName->doctype . ' ' . $pdwork->basedoc_name . ' от ' . $pdwork->basedoc_datasign
                ;
            }
        ?>
    </p>


    <?php
    if (\Yii::$app->user->can('pd_ca') or \Yii::$app->user->can('pd_edit'))
       echo $this->render('_form', [
            'model' => $model,
            'model2' => $model2,
            'pdwork' => $pdwork,

        ])
    ?>


    <h2><?= Html::encode($this->title) ?></h2>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [

            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'pd_work',
            // [
            //     'attribute' => 'pd_work',
            //     'label' => 'Проектная документация',
            // ],
            'report_date',
            'pd_object',
            // 'pd_step',
            [
                'attribute' => 'pdStep.step_name',
                'label' => 'Этап работ',
            ],
            'step_startplan',
            'step_finishplan',
            // 'progress_status',
            // [
            //     'attribute' => 'progress_status',
            //     'label' => 'Стадия выполнения этапа',
            // ],
            // 'comment',
            [
                'attribute' => 'comment',
                'label' => 'Описание',
            ],
            // 'resultdoc_name',
            // 'resultdoc_num',
            // 'resultdoc_date',
            // 'resultdoc_file',
            // 'person_responsible',
            [
              'attribute' => 'personFio',
              'label' => 'Отв. лицо',
              'format' => 'raw',
              'value' => function($model, $key, $index, $column){
                // Для ЦА отображаем ФИО с активной ссылкой на профиль сотрудника
                if (\Yii::$app->user->can('pd_ca'))
                    return Html::a($model->personFio,['/user/user/view', 'id' => $model->person_responsible]);
                else return $model->personFio;
              },
            ],

            // [
            //     'attribute' => 'person.fio',
            //     'label' => 'Отв. лицо',
            // ],
            // 'timestamp',

            // ['class' => 'yii\grid\ActionColumn'],
            [
                'attribute' => 'Pdf',
//            'label' => 'Период тренировки',
                'label' => '',
                'format' => 'raw',

                'value' => function($data) {
                    //Проверяем наличие папки
                    if (file_exists('docs/pd/'.Yii::$app->request->get('pd_work').'/')) {
                        $files=FileHelper::findFiles('docs/pd/'.Yii::$app->request->get('pd_work').'/', [ 'only' => ["pdProcess_$data->id*"], 'recursive' => false ]); //'recursive' => true - в этой папке, включая вложенные
                        if (isset($files[0])) {
                            // echo '<div class="file_list">';
                            sort($files);
                            $allHTML = '';
                            foreach ($files as $index => $file) {
                                $docName = substr($file, strrpos($file, '/') + 1);
                                $fileIcon = explode(".", $docName);
                                if ($fileIcon['1'] == 'pdf')
                                    $icon = '<i class="fas fa-file-pdf" style="color: #cc0000"></i> ';
                                elseif ($fileIcon['1'] == 'docx' or $fileIcon['1'] == 'doc')
                                    $icon = '<i class="fas fa-file-word"  style="color: #2384e8"></i> ';
                                elseif ($fileIcon['1'] == 'xlsx' or $fileIcon['1'] == 'xls')
                                    $icon = '<i class="fas fa-file-excel"  style="color: #41bb23"></i> ';
                                elseif ($fileIcon['1'] == 'rar' or $fileIcon['1'] == '7z' or $fileIcon['1'] == 'zip')
                                    $icon = '<i class="fas fa-file-archive"  style="color: #f8922b"></i> ';
                                else
                                    $icon = '';

                                if ($allHTML)
                                    $allHTML = $allHTML.Html::a($icon, '/docs/pd/'.Yii::$app->request->get('pd_work').'/'.$docName , ['target'=>'_blank' ,'label' => 'Home', 'class'=>'name'] ) . '<br/>';
                                else  $allHTML = Html::a($icon, '/docs/pd/'.Yii::$app->request->get('pd_work').'/'.$docName , ['target'=>'_blank' ,'label' => 'Home', 'class'=>'name'] ) . '<br/>';

                            }
                            // echo '</div>';
                            return $allHTML;
                        }
                        else {
                            // echo "Нет загруженных файлов";
                            return '';
                        }
                    }
                    else{
                        return '';
                    }
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'<span class="glyphicon glyphicon-cog"></span>', 
                'template' => '{update} {delete}', // '{view} {update} {delete}', 
                'buttons' => [
                    'view' => function ($url) {
                        return Html::a(
                        '<span class="glyphicon glyphicon-eye-open"></span>', 
                        [$url . '&pd_work=' . Yii::$app->request->get('pd_work')]);
                        
                    },
                    'update' => function ($url) {
                        return Html::a(
                        '<span class="glyphicon glyphicon-pencil"></span>', 
                        [$url . '&pd_work=' . Yii::$app->request->get('pd_work') ]);                        
                    },
                ],
                'visible' => \Yii::$app->user->can('pd_ca'),
            ],


        ],
    ]);

    ?>


</div>
