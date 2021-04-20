<?php

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<style>
    .leftmenu .dropdown-menu  {
        background: #88c86f;
    }

    .leftmenu li a {
        background: #88c86f;
    }

    .leftmenu .caret{
        display: none;
        border-right-width: 7px;
        border-top-width: 10px;
        border-left-width: 7px;
        margin-left: 80px;
        margin-bottom: 9px;
        color: #fff;
    }

    .auditmenu .caret{
        margin-left: 73px;
    }

    .lumenu .caret{
        margin-left: 28px;
    }

    .generalmenu .caret{
        margin-left: 46px;
    }




</style>
<?php $this->beginBody() ?>

   <div class="wrapper">
            <nav id="sidebar">
                <div class="sidebar-header">
                    <h3 style="margin: 0; text-align: center;"><span style="font-size: 14px;">Информационная система</span> «Лесной кластер»</h3>
                </div>

	<?php
    NavBar::begin([
        'options' => [
            'class' => 'nav-item',
        ],
    ]);

    echo Nav::widget([
      'encodeLabels' => false,
      'items' => 
    		[
          [ 'label' => 'Лесное планирование <br>(Ход работ)',
          'url' => ['/pd/pd-work/index'],
          'visible' => \Yii::$app->user->can('pd_ca') or \Yii::$app->user->can('pd_edit') or \Yii::$app->user->can('pd_view')],

          ['label' => 'Отчеты ПОЛ', 
          'url' => ['/forest_work/forestwork/index'],
          'visible' => \Yii::$app->user->can('admin')],

          ['label' => 'Свод по ПОЛ', 
          'url' => ['/forest_work/forestwork/summary-report-pol'],
          'visible' => \Yii::$app->user->can('admin')],

          // ['label' => 'Инструкция', 
          // 'url' => ['/forest_work/forestwork/instruction-pol'],
          // 'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id <= '5'],
          
          
          ['label' => 'Графики', 
          'url' => ['/forest_work/forestwork/chart'],
          'visible' => \Yii::$app->user->can('admin')],

                //		  ['label' => 'Контракты',
         //  'url' => ['/forest/contract'],
      	//  'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id <= '2'],
      		
      	  

          //['label' => 'PD Work process', 
          //'url' => ['/pd/pd-work-process'],
          //'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id <= '2'],



              ['label' => 'Контрольные мероприятия',
                  'linkOptions' => ['aria-expanded'=>"false"],
                  'url' => ['/audit/audit/index'],
                  'options' => [
                      'class' => 'leftmenu',
                  ],
                  'visible' => \Yii::$app->user->can('audit__view') or \Yii::$app->user->can('audit__edit') or
                               \Yii::$app->user->can('audit_expertise_view') or \Yii::$app->user->can('audit_expertise_edit') or
                               \Yii::$app->user->can('audit_unscheduled_view') or \Yii::$app->user->can('audit_unscheduled_edit') or
                               \Yii::$app->user->can('audit_revision_view') or \Yii::$app->user->can('audit_revision_edit'),

                  'items' => [
                      ['label' => 'Типы',
                          'url' => ['/audit/audit-type/index'],
                          'visible' => \Yii::$app->user->can('admin')],
                      ['label' => 'ОИВ',
                          'url' => ['/audit/oiv-subject/index'],
                          'visible' => \Yii::$app->user->can('admin') or \Yii::$app->user->can('oiv_view')],
                      ['label' => 'Специалисты',
                          'url' => ['/audit/audit-person/index'],
                          'visible' => \Yii::$app->user->can('admin')],
                      ['label' => 'Ход проверок',
                          'url' => ['/audit/audit-process/index'],
                          'visible' => \Yii::$app->user->can('admin')],
                      ['label' => 'Свод',
                          'url' => ['/audit/audit/summary'],
                          'visible' => \Yii::$app->user->can('admin')],
                      ['label' => '«ПИПП»',
                          'url' => ['/audit/audit/'],
                          'visible' => \Yii::$app->user->can('audit__view') or \Yii::$app->user->can('audit__edit')],
                      ['label' => '«Экспертизы»',
                          'url' => ['/audit/audit-expertise/index'],
                          'visible' =>  \Yii::$app->user->can('audit_expertise_view') or \Yii::$app->user->can('audit_expertise_edit')],
                      ['label' => '«Внеплановые проверки»',
                          'url' => ['/audit/audit-unscheduled/index'],
                          'visible' =>  \Yii::$app->user->can('audit_unscheduled_view') or \Yii::$app->user->can('audit_unscheduled_edit')],
                      ['label' => '«Ревизии»',
                          'url' => ['/audit/audit-revision/index'],
                          'visible' =>  \Yii::$app->user->can('audit_revision_view') or \Yii::$app->user->can('audit_revision_edit')],
                  ]
              ],
                ['label' => 'Коллективные тренировки',
                    'linkOptions' => ['aria-expanded'=>"false"],
                    'url' => ['/audit/training-process/index'],
                    'options' => [
                        'class' => 'leftmenu',
                    ],
                    'visible' =>  \Yii::$app->user->can('munic_view') or
                                  \Yii::$app->user->can('tr_person_edit') or \Yii::$app->user->can('tr_person_view') or
                                  \Yii::$app->user->can('tr_process_edit') or \Yii::$app->user->can('tr_process_view')or \Yii::$app->user->can('tr_process_check') or
                                  \Yii::$app->user->can('brigade_edit') or \Yii::$app->user->can('brigade_view'),

                    'items' => [
                        ['label' => 'ЛР зоны',
                            'url' => ['/audit/forestgrow-zone/index'],
                            'visible' =>  \Yii::$app->user->can('admin')],
                        ['label' => 'ЛР районы',
                            'url' => ['/audit/forestgrow-region/index'],
                            'visible' => \Yii::$app->user->can('admin')],
                        ['label' => 'ЛР субъекты-районы',
                            'url' => ['/audit/forestgrow-region-subject/index'],
                            'visible' => \Yii::$app->user->can('admin')],
                        ['label' => 'Муниципальные районы',
                            'url' => ['/audit/munic-region/index'],
                            'visible' => \Yii::$app->user->can('admin') or \Yii::$app->user->can('munic_view')],
                        ['label' => 'Участники тренировки',
                            'url' => ['/audit/training-person/index'],
                            'visible' => \Yii::$app->user->can('tr_person_edit') or \Yii::$app->user->can('tr_person_view') ],
                        ['label' => 'Тренировочный процесс',
                            'url' => ['/audit/training-process/index'],
                            'visible' => \Yii::$app->user->can('tr_process_edit') or \Yii::$app->user->can('tr_process_view')or \Yii::$app->user->can('tr_process_check') ],
                        ['label' => 'Бригада',
                            'url' => ['/audit/brigade/index'],
                            'visible' => \Yii::$app->user->can('brigade_edit') or \Yii::$app->user->can('brigade_view') ],
                    ]
                ],

                ['label' => 'Лесоустройство',
                    'linkOptions' => ['aria-expanded'=>"false"],
                    'url' => ['/lu/zakup-card/index'],
                    'options' => [
                        'class' => 'leftmenu',
                    ],
                    'visible' => \Yii::$app->user->can('lu_object_edit') or \Yii::$app->user->can('lu_object_view')
                        or \Yii::$app->user->can('lu_object_process_edit') or \Yii::$app->user->can('lu_object_process_view')
                        or \Yii::$app->user->can('lu_process_edit') or \Yii::$app->user->can('lu_process_view')
                        or \Yii::$app->user->can('lu_zakup_edit') or \Yii::$app->user->can('lu_zakup_view')
                        or \Yii::$app->user->can('vaccination_edit') or \Yii::$app->user->can('vaccination_view')
                        or \Yii::$app->user->can('oopt_view')or \Yii::$app->user->can('admin'),
                    'items' => [
                        ['label' => 'Лесоустройство',
                            'url' => ['/lu/zakup-card/index'],
                            'visible' => \Yii::$app->user->can('lu_object_edit') or \Yii::$app->user->can('lu_object_view')
                                or \Yii::$app->user->can('lu_object_process_edit') or \Yii::$app->user->can('lu_object_process_view')
                                or \Yii::$app->user->can('lu_process_edit') or \Yii::$app->user->can('lu_process_view')
                                or \Yii::$app->user->can('lu_zakup_edit') or \Yii::$app->user->can('lu_zakup_view')],

                        ['label' => 'Периоды вегетации',
                            'url' => ['/lu/veget-period/index'],
                            'visible' => \Yii::$app->user->can('admin')],

                        ['label' => 'Фазы лесоустройства',
                            'url' => ['/lu/lu-phase/index'],
                            'visible' => \Yii::$app->user->can('admin')],

                        ['label' => 'Стадия шага',
                            'url' => ['/lu/lu-process-step/index'],
                            'visible' => \Yii::$app->user->can('admin')],

                        ['label' => 'Оопт',
                            'url' => ['/lu/oopt/index'],
                            'visible' => \Yii::$app->user->can('oopt_view') or \Yii::$app->user->can('admin')],

                        ['label' => 'Gps-трекинг',
                            'url' => ['/lu/gps-tracking/index'],
                            'visible' => \Yii::$app->user->can('gps_check') or \Yii::$app->user->can('gps_edit')or \Yii::$app->user->can('gps_view')],

                        ['label' => 'Вакцинация',
                            'url' => ['/lu/vaccination/index'],
                            'visible' => \Yii::$app->user->can('vaccination_edit') or \Yii::$app->user->can('vaccination_view')],
                    ] ],


    //          ['label' => 'Проверки',
    //          'url' => ['/audit/audit/index'],
    //          'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id <= '2'],

    //          ['label' => '- проверки.Процесс',
    //          'url' => ['/audit/audit-process/index'],
    //          'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id <= '2'],

    //          ['label' => '- проверки.Люди', 'url' => ['/audit/audit-person/index'],
    //          'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id <= '2'],
//              ['label' => '- проверок.Типы',
//                  'url' => ['/audit/audit-type/index'],
//                  'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id <= '2'],

//              ['label' => 'Лесоустройство',
//                  'url' => ['/lu/zakup-card/index'],
//                  'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id <= '2'],
//
//
//              ['label' => '- периоды вегетации',
//                  'url' => ['/lu/veget-period/index'],
//                  'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id <= '2'],
//
//              ['label' => '- фазы лесоустройства',
//                  'url' => ['/lu/lu-phase/index'],
//                  'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id <= '2'],
//
//              ['label' => '- стадия шага',
//                  'url' => ['/lu/lu-process-step/index'],
//                  'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id <= '2'],

          ['label' => 'Общие блоки',
              'linkOptions' => ['aria-expanded'=>"false"],
            // 'url' => ['#'],
            'options' => [
                'class' => 'leftmenu',
            ],
            'visible' => \Yii::$app->user->can('branch_person_edit')
                or \Yii::$app->user->can('branch_person_view')
                or \Yii::$app->user->can('admin')
                or \Yii::$app->user->can('pd_ca'),
            'items' => [
                ['label' => 'Работы по проектированию',
                    'url' => ['/pd/pd-worktype/index'],
                    'visible' => \Yii::$app->user->can('pd_ca')],

                ['label' => 'Кураторы ЦА',
                    'url' => ['/ca-curator/index'],
                    'visible' => \Yii::$app->user->can('pd_ca')],

                ['label' => 'Зоны ответственности',
                    'url' => ['/responsibility-area/index'],
                    'visible' => \Yii::$app->user->can('pd_ca')],

                ['label' => 'ПД по субъектам',
                    'url' => ['/pd/pd-work/amount-docs'],
                    'visible' => \Yii::$app->user->can('pd_ca')],

                ['label' => 'Свод по ФО',
                    'url' => ['/pd/pd-work/summary-district'],
                    'visible' => \Yii::$app->user->can('pd_ca')],

                ['label' => 'Свод по Филиалам',
                    'url' => ['/pd/pd-work/summary-branch'],
                    'visible' => \Yii::$app->user->can('pd_ca')],
                ['label' => 'Связь ООПТ',
                    'url' => ['/oopt-binding/index'],
                    'visible' => \Yii::$app->user->can('admin')],
                ['label' => 'Категории фондов земель',
                    'url' => ['/nsi-kfz/index'],
                    'visible' => \Yii::$app->user->can('admin')],
                ['label' => 'Работники филиала',
                    'url' => ['/branch-person/index'],
                    'visible' => \Yii::$app->user->can('branch_person_edit') or \Yii::$app->user->can('branch_person_view')],
            ] 
          ],


          ['label' => 'Сотрудники', 
            'url' => ['/user/user/index'],
            'visible' => \Yii::$app->user->can('admin') or \Yii::$app->user->can('user_view')],

          ['label' => 'Тех. поддержка', 
            'url' => ['/site/support'],
            // 'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id <= '5'
          ],

          ['label' => 'О системе',
            'url' => ['/site/info'],
            // 'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id <= '5'
          ],
    		  ['label' => 'Форум',
              'url' => 'http://192.168.8.42:8080', 'linkOptions' => ['target' => '_blank']
          ],
        ],
		
    ]);
    NavBar::end();
    ?>

               <!-- <ul class="list-unstyled components">
                    <li class="active">
                        <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">Документация</a>
                        <ul class="collapse list-unstyled" id="homeSubmenu">
                            <li><a href="#">Home 1</a></li>
                            <li><a href="#">Home 2</a></li>
                            <li><a href="#">Home 3</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">About</a>
                        <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false">Pages</a>
                        <ul class="collapse list-unstyled" id="pageSubmenu">
                            <li><a href="#">Page 1</a></li>
                            <li><a href="#">Page 2</a></li>
                            <li><a href="#">Page 3</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Portfolio</a>
                    </li>
                    <li>
                        <a href="#">Contact</a>
                    </li>
                </ul>-->

                <!--<ul class="list-unstyled CTAs">
                    <li><a href="https://bootstrapious.com/tutorial/files/sidebar.zip" class="download">Download source</a></li>
                    <li><a href="https://bootstrapious.com/p/bootstrap-sidebar" class="article">Back to article</a></li>
                </ul>-->
            </nav>
            <!-- Page Content Holder -->
            <div id="content">
			<?php
    NavBar::begin([
        'options' => [
            'class' => 'navbar navbar-default',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Главная', 'url' => ['/site/index']],
            //['label' => 'О проекте', 'url' => ['/site/about']],
            //['label' => 'Напишите нам', 'url' => ['/site/contact']],
			Yii::$app->user->isGuest ? (
                ['label' => 'Войти в систему', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Выход (' . Yii::$app->user->identity->fio . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

                            <!--<button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                                <i class="glyphicon glyphicon-align-left"></i>
                                <span>Боковая панель</span>
                            </button>-->

                <?php
				echo $content 
				?>
            </div>
        </div>
  <!-- jQuery CDN -->
         <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
         <!-- Bootstrap Js CDN -->
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

         <script type="text/javascript">
             $(document).ready(function () {
                 $('#sidebarCollapse').on('click', function () {
                     $('#sidebar').toggleClass('active');
                 });
             });
         </script>

<footer class="footer">
    <div class="container">
        <p class="pull-left">ФГБУ "РОСЛЕСИНФОРГ" <?= date('Y') ?></p>

    </div>
    <script type="text/javascript">
      /*  $(document).ready(function(){
            $(document).snowfall({image :"../../../img/2.png", minSize: 10, maxSize:20});
        }); */
    </script>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
