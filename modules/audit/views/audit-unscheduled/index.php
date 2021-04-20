<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\FileHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\audit\models\SearchAuditUnscheduled */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Внеплановые проверки';
$this->params['breadcrumbs'][] = $this->title;

$auth = Yii::$app->authManager;

////роли
//$super_viewer = $auth->createRole('super_viewer');
//$super_viewer->description = 'Простотр всех модулей';
//$auth->add($super_viewer);
//
//$nca = $auth->createRole('nca');
//$nca->description = 'Не из центрального аппарата';
//$auth->add($nca);
//
//$ca = $auth->createRole('ca');
//$ca->description = 'Из центрального аппарата';
//$auth->add($ca);
//
//$pd_ca = $auth->createRole('pd_ca');
//$pd_ca->description = 'Доступ ко всему для модулей pd';
//$auth->add($pd_ca);
//
//$pd_reporter = $auth->createRole('pd_reporter');
//$pd_reporter->description = 'Доступ к заполнению pd';
//$auth->add($pd_reporter);
//
//$pd_viewer = $auth->createRole('pd_viewer');
//$pd_viewer->description = 'Доступ к просмотру pd';
//$auth->add($pd_viewer);

////права для доступа audit
//$audit_view = $auth->createPermission('audit_view');
//$audit_view->description = 'Просмотор модуля audit';
//$auth->add($audit_view);
//
//$audit_edit = $auth->createPermission('audit_edit');
//$audit_edit->description = 'Редактирование модуля audit';
//$auth->add($audit_edit);
//
//$audit_expertise_view = $auth->createPermission('audit_expertise_view');
//$audit_expertise_view->description = 'Просмотор модуля audit_expertise';
//$auth->add($audit_expertise_view);
//
//$audit_expertise_edit = $auth->createPermission('audit_expertise_edit');
//$audit_expertise_edit->description = 'Редактирование модуля audit_expertise';
//$auth->add($audit_expertise_edit);
//
//$audit_person_view = $auth->createPermission('audit_person_view');
//$audit_person_view->description = 'Просмотор модуля audit_person';
//$auth->add($audit_person_view);
//
//$audit_person_edit = $auth->createPermission('audit_person_edit');
//$audit_person_edit->description = 'Редактирование модуля audit_person';
//$auth->add($audit_person_edit);
//
//$audit_process_view = $auth->createPermission('audit_process_view');
//$audit_process_view->description = 'Просмотор модуля audit_process';
//$auth->add($audit_process_view);
//
//$audit_process_edit = $auth->createPermission('audit_process_edit');
//$audit_process_edit->description = 'Редактирование модуля audit_process';
//$auth->add($audit_process_edit);
//
//$audit_revision_view = $auth->createPermission('audit_revision_view');
//$audit_revision_view->description = 'Просмотор модуля audit_revision';
//$auth->add($audit_revision_view);
//
//$audit_revision_edit = $auth->createPermission('audit_revision_edit');
//$audit_revision_edit->description = 'Редактирование модуля audit_revision';
//$auth->add($audit_revision_edit);
//
//$audit_unscheduled_view = $auth->createPermission('audit_unscheduled_view');
//$audit_unscheduled_view->description = 'Просмотор модуля audit_unscheduled';
//$auth->add($audit_unscheduled_view);
//
//$audit_unscheduled_edit = $auth->createPermission('audit_unscheduled_edit');
//$audit_unscheduled_edit->description = 'Редактирование модуля audit_unscheduled';
//$auth->add($audit_unscheduled_edit);
//


//Тренировки
//$audit_oiv_view = $auth->createPermission('oiv_view');
//$audit_oiv_view->description = 'Просмотор модуля oiv_view';
//$auth->add($audit_oiv_view);
//
//$audit_munic_view = $auth->createPermission('munic_view');
//$audit_munic_view->description = 'Просмотор модуля munic_view';
//$auth->add($audit_munic_view);
//
//$audit_brigade_edit = $auth->createPermission('brigade_edit');
//$audit_brigade_edit->description = 'Редактирование модуля brigade_edit';
//$auth->add($audit_brigade_edit);
//
//$audit_brigade_view = $auth->createPermission('brigade_view');
//$audit_brigade_view->description = 'Просмотор модуля brigade_view';
//$auth->add($audit_brigade_view);
//
//$brigade_online_edit = $auth->createPermission('brigade_online_edit');
//$brigade_online_edit->description = 'Редактирование модуля brigade_online_edit';
//$auth->add($brigade_online_edit);
//
//$brigade_online_view = $auth->createPermission('brigade_online_view');
//$brigade_online_view->description = 'Просмотор модуля brigade_online_view';
//$auth->add($brigade_online_view);
//
//Лесоустройство


//$lu_object_edit = $auth->createPermission('lu_object_edit');
//$lu_object_edit->description = 'Редактирование модуля lu_object_edit';
//$auth->add($lu_object_edit);
//
//$lu_object_view = $auth->createPermission('lu_object_view');
//$lu_object_view->description = 'Просмотор модуля lu_object_view';
//$auth->add($lu_object_view);
//
//$lu_object_process_edit = $auth->createPermission('lu_object_process_edit');
//$lu_object_process_edit->description = 'Редактирование модуля lu_object_process_edit';
//$auth->add($lu_object_process_edit);
//
//$lu_object_process_view = $auth->createPermission('lu_object_process_view');
//$lu_object_process_view->description = 'Просмотор модуля lu_object_process_view';
//$auth->add($lu_object_process_view);
//
//$lu_process_edit = $auth->createPermission('lu_process_edit');
//$lu_process_edit->description = 'Редактирование модуля lu_process_edit';
//$auth->add($lu_process_edit);
//
//$lu_process_view = $auth->createPermission('lu_process_view');
//$lu_process_view->description = 'Просмотор модуля lu_process_view';
//$auth->add($lu_process_view);
//
//$oopt_view = $auth->createPermission('oopt_view');
//$oopt_view->description = 'Просмотор модуля oopt_view';
//$auth->add($oopt_view);
//
//$lu_zakup_edit = $auth->createPermission('lu_zakup_edit');
//$lu_zakup_edit->description = 'Редактирование модуля lu_zakup_edit';
//$auth->add($lu_zakup_edit);
//
//$lu_zakup_view = $auth->createPermission('lu_zakup_view');
//$lu_zakup_view->description = 'Просмотор модуля lu_zakup_view';
//$auth->add($lu_zakup_view);
//
//$vaccination_edit = $auth->createPermission('vaccination_edit');
//$vaccination_edit->description = 'Редактирование модуля vaccination_edit';
//$auth->add($vaccination_edit);
//
//$vaccination_view = $auth->createPermission('vaccination_view');
//$vaccination_view->description = 'Просмотор модуля vaccination_view';
//$auth->add($vaccination_view);

//$gps_check = $auth->createPermission('gps_check');
//$gps_check->description = 'проверка модуля gps_check';
//$auth->add($gps_check);
//
//$gps_edit = $auth->createPermission('gps_edit');
//$gps_edit->description = 'Редактирование модуля gps_edit';
//$auth->add($gps_edit);
//
//$gps_view = $auth->createPermission('gps_view');
//$gps_view->description = 'Просмотор модуля gps_view';
//$auth->add($gps_view);




//var_dump(\Yii::$app->user->can('audit_edit'));
//var_dump(\Yii::$app->user->can('audit_view'));


?>
<div class="audit-unscheduled-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (\Yii::$app->user->can('audit_unscheduled_edit')){ ?>
        <p>
            <?= Html::a('Создание внеплановой проверки', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php }?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'fedSubjectName',
            'branchName',
            'fio',
            'date_start',
            'date_finish',
            [
                'label' => 'Дни',
                'value' => function($data) {
                    $dateS = $data->date_start;
                    $dateF = $data->date_finish;
                    if ($dateS != null and $dateF != null) {
                        $dateF = new \DateTime($data->date_finish);
                        $dateS = new \DateTime($data->date_start);
                        $DateAll = date_diff($dateS, $dateF);
                        $sumDate = $DateAll->d + 1;
                        $sumDateAll = $sumDate;
                        return $sumDateAll;
                    }
                    else{
                        return '';
                    }


                },
            ],
            'participation_cost',
            [
                'attribute' => 'comment',
                'label' => 'Замечания',
                'format' => 'raw',
                'value' => function($data) {
                    if($data->comment != null){
                        $chapter_a = Html::a(
                            '<span class="glyphicon glyphicon-book"></span>',
//                            ['/lu/lu-process/index','zakup' => $key],
                            ['../audit/audit-unscheduled/view?id='. $data->id],
                            ['title' => 'Подробнее']);
                        return $chapter_a;
                    }
                    else{
                        return '';
                    }
                },
            ],
            [
                'attribute' => 'proposal',
//                'label' => '',
                'format' => 'raw',
                'value' => function($data) {
                    if($data->proposal != null){
                        $chapter_a = Html::a(
                            '<span class="glyphicon glyphicon-book"></span>',
//                            ['/lu/lu-process/index','zakup' => $key],
                            ['../audit/audit-unscheduled/view?id='. $data->id],
                            ['title' => 'Подробнее']);
                        return $chapter_a;
                    }
                    else{
                        return '';
                    }
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'<span class="glyphicon glyphicon-cog"></span>',
                'template' => '{view} {update}', // '{view} {update} {delete}',
                'visible' => \Yii::$app->user->can('audit_unscheduled_edit'),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}' ,
                'visible' => \Yii::$app->user->can('audit_unscheduled_view'),

            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}' ,
                'visible' => \Yii::$app->user->can('admin'),

            ]
        ],
    ]); ?>


</div>
