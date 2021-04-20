<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


$this->title = "Информация о выполнении работ по разработке проектов освоения лесов (внесении изменений) в ".date('Y')." году *";


?>

    <p>
        <?= Html::a('Все отчеты', ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Инструкция', ['instruction-pol'], ['class' => 'btn btn-danger']) ?>
    </p>

<div class="forest-work-form">  

    <div class="card-header">
        <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
    </div>


<?php

$userID = Yii::$app->user->identity->id;
$condUser = 'id = '.$userID;
$branchID = Yii::$app->user->identity->branch_id;

if($branchID != 0) $condBranch = 'branch_id = '.$branchID;
else $condBranch = '';

?>

  
    <?php $form = ActiveForm::begin(); ?>

      <?= $form->field($model, 'reporter')->dropDownList(ArrayHelper::map(app\modules\forest_work\models\User::find()->where($condUser)->all(), 'id', 'fio')) ?>

      <?php
        if($branchID == 0) echo $form->field($model, 'date')->textInput(['value' => date("Y-m-d")]);
        else echo $form->field($model, 'date')->textInput(['value' => date("Y-m-d"), 'readonly' => true]);
      ?>

      <?= $form->field($model, 'branch_id')->dropDownList(ArrayHelper::map(app\modules\forest_work\models\Branch::find()->where($condBranch)->orderBy(['name' => SORT_ASC])->all(), 'branch_id', 'name')) ?>

      <?= $form->field($model, 'federal_subject_id')->dropDownList(ArrayHelper::map(app\modules\forest_work\models\ResponsibilityArea::find()->joinWith('federalSubject')->where($condBranch)->orderBy(['federal_subject.name' => SORT_ASC])->all(), 'federal_subject_id', 'federalSubject.name')) ?>



      <table class="table table-bordered minheight pol_report_data">
        <thead>                  
          <tr>
            <th style="width: 8px">№</th>
            <th>Вид использования лесов**</th>
            <th>Количество проектной документации (разрабатываемой, дорабатываемой, разработанной) в <?= date('Y') ?> году ***</th>
            <th>Из них количество проектной документации, работы по которой завершены в <?= date('Y') ?> году и сданы Заказчику ***</th>
          </tr>
        </thead>
        <tbody>

          <?php

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

          for ($i = 1; $i <= 17; $i++) {
            echo "
          <tr>
            <td>".$i.".</td>
            <td>".$usingtype[$i]."</td>
            <td>".$form->field($model, 'a'.$i)->textInput()."</td>
            <td>".$form->field($model, 'b'.$i)->textInput()."</td>
          </tr>";
          }

          ?>

        </tbody>
      </table>
    </div>   


    <div class="form-group">
        <?= Html::submitButton('Отправить отчет', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
