<?php
use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>

<!doctype html>
<html lang="ru">
<head>
  <meta charset="<?= Yii::$app->language ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= Html::encode($this->title) ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php $this->registerCsrfMetaTags() ?>
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <?php $this->head() ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<?php $this->beginBody() ?>
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Основная</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Нормативные документы</a>
      </li>
    </ul>
    </nav>

  <aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php
		  echo Yii::$app->user->identity->fio
		  ?>
		  </a>
        </div>
      </div>


		  <?php
    NavBar::begin([
        'options' => [
            'class' => 'mt-2',
        ],
    ]);

    echo Nav::widget([
      'items' => 
    		[
          ['label' => 'Отчеты ПОЛ', 
          'url' => ['/forest_work/forestwork'],
          'linkOptions' => ['class' => 'nav-link'],
          'options' => ['class' => 'nav-item has-treeview'],
          'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id <= '5'],

          ['label' => 'Свод по ПОЛ', 
          'url' => ['/forest_work/forestwork/summary-report-pol'],
          'linkOptions' => ['class' => 'nav-link'],
          'options' => ['class' => 'nav-item has-treeview'],
          'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id <= '3'],

          ['label' => 'О модуле', 
          'url' => ['/forest_work/forestwork/info'],
          'linkOptions' => ['class' => 'nav-link'],
          'options' => ['class' => 'nav-item has-treeview'],
          'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id <= '5'],

          ['label' => 'Инструкция', 
          'url' => ['/forest_work/forestwork/instruction-pol'],
          'linkOptions' => ['class' => 'nav-link'],
          'options' => ['class' => 'nav-item has-treeview'],
          'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id <= '5'],


          ['label' => '--------------',], 


          
      		['label' => 'Контракты', 
      			'url' => ['/forest/contract'],
      			'linkOptions' => ['class' => 'nav-link'],
      			'options' => ['class' => 'nav-item has-treeview'],
      			'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id <= '3'],
      		
      		['label' => 'Сотрудники', 
      			'url' => ['/user/user'],
      			'linkOptions' => ['class' => 'nav-link'],
      			'options' => ['class' => 'nav-item has-treeview'],
      			'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->role_id <= '3'],


          Yii::$app->user->isGuest ? (
              ['label' => 'Войти','url' => ['login']]
          ) : (
              '<li>'
              . Html::beginForm(['logout'], 'post')
              . Html::submitButton(
                  'Завершить сеанс',
                  ['class' => 'btn btn-warning']
              )
              . Html::endForm()
              . '</li>'
          )
    			
        ],
		
    ]);
    NavBar::end();
    ?>

    </div>
    <!-- /.sidebar -->
  </aside>
  <?= Alert::widget() ?>
  <div class="content-wrapper">

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
        </div>
      </div>
    </section>

  	<section class="content">

      <div class="card">
        <div class="card-header"> 
          <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
        </div>

        <div class="card-body">
          <?= $content ?>
   			</div>
      </div>
         
    </section>
  </div>

  <footer class="main-footer">
    <strong>ФГБУ Рослесинфорг &copy; <?= date('Y') ?></strong>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>