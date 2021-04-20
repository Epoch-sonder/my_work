<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\forest_work\models\ForestWork */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Forest Works', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->title = "Информация о выполнении работ по разработке проектов освоения лесов (внесении изменений) в ".date("Y", strtotime($model->date))." году *";

\yii\web\YiiAsset::register($this);
?>
<div class="forest-work-view">

    <p>
        <?= Html::a('Все отчеты', ['index'], ['class' => 'btn btn-primary']) ?>

        <?= Html::a('<i class="fas fa-file-pdf"></i> PDF', [Yii::$app->request->url.'&format=pdf'], [
            'class'=>'btn btn-danger', 
            'target'=>'_blank', 
            'data-toggle'=>'tooltip', 
            'title'=>'Сгенерировать текущий отчет в формате PDF'
        ]) ?>

    </p>


    <div class="rli_logo"><img src="/img/rli_logo.png"></div>
    <div class="report_header">
      <h1><?= $this->title ?></h1>

	    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'branch_id',
            'branch.name',
            //'federal_subject_id',
            [
              'label' => 'Субъект РФ',
              'attribute' => 'federalSubject.name',
            ],
            'date',
            //'reporter',
            [
              'label' => 'Должностное лицо',
              'attribute' => 'user.fio',
            ],
            // 'user.fio',
            //'timestamp',
        ],
    ]) ?>
        </div>

                <table class="table table-bordered pol">
                  <thead>                  
                    <tr>
                      <th style="width: 8px">№</th>
                      <th>Вид использования лесов**</th>
                      <th>Количество проектной документации (разрабатываемой, дорабатываемой, разработанной) в <?= date("Y", strtotime($model->date)) ?> году ***</th>
                      <th>Из них количество проектной документации, работы по которой завершены в <?= date("Y", strtotime($model->date)) ?> году и сданы Заказчику ***</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php

                    // Вид использования лесов, формулировки
                    $usingtype = array(
                      '',
                      'заготовка древесины',
                      'заготовка живицы',
                      'заготовка и сбор недревесных лесных ресурсов',
                      'заготовка пищевых лесных ресурсов и сбор лекарственных растений',
                      'осуществление видов деятельности в сфере охотничьего хозяйства',
                      'ведение сельского хозяйства',
                      'осуществление научно-исследовательской деятельности, образовательной деятельности',
                      'осуществление рекреационной деятельности',
                      'создание лесных плантаций и их эксплуатация',
                      'выращивание лесных плодовых, ягодных, декоративных растений, лекарственных растений',
                      'выращивание посадочного материала лесных растений (саженцев, сеянцев)',
                      'выполнение работ по геологическому изучению недр, разработка месторождений полезных ископаемых',
                      'строительство и эксплуатация водохранилищ и иных искусственных водных объектов, а также гидротехнических сооружений и морских портов, морских терминалов, речных портов, причалов',
                      'строительство, реконструкция, эксплуатация линейных объектов',
                      'переработка древесины и иных лесных ресурсов',
                      'осуществление религиозной деятельности',
                      'иные виды, определенные в соотвествии с частью 2 статьи 6 Лесного кодекса Российской Федерации'
                    );

                    // Переменные для итоговых значений
                    $attl = 0;
                    $bttl = 0;

                    for ($i = 1; $i <= 17; $i++) {
                      $ai = "a".$i;
                      $bi = "b".$i;

                      echo "
                    <tr>
                      <td>".$i.".</td>
                      <td>".$usingtype[$i]."</td>
                      <td>".$model->$ai."</td>
                      <td>".$model->$bi."</td>
                    </tr>";
                    
                      // Подсчет итоговых значений
                      $attl += $model->$ai;
                      $bttl += $model->$bi;
                    }

                    ?>

                  </tbody>

                  <tfoot>
                    <tr>
                      <td></td>
                      <td><strong>ИТОГО:</strong></td>
                      <td><strong><?= $attl ?></strong></td>
                      <td><strong><?= $bttl ?></strong></td>
                    </tr>
                  </tfoot>
                </table>
              </div>   

<br>
              <p>* заполняется отдельно по каждому субъекту РФ с нарастающим итогом</p>
              <p>** при использовании лесов сразу по нескольким видам - учитывать по основному виду</p>
              <p>*** указать, в том числе, ПОЛ, работы по которым организаторы в <?= date("Y", strtotime($model->date))-1 ?> году, но доработка осуществлялась в <?= date("Y", strtotime($model->date)) ?> году</p>

      <?php /*
      $da=$model->date;
      echo $da."<br>";
      $dateArray = explode('-', $da);
      echo $dateArray[0]."<br>";
      $time=strtotime($da);
      $year=date("Y",$time);
      $month=date("F",$time);
      $date=date("d",$time);
      echo $year."<br>";
      */ ?>


    <!-- /.content -->
  </div>


</div>

