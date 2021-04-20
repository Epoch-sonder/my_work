<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\lu\models\SearchLuObjectProcess */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Процесс объекта';
$this->params['breadcrumbs'][] = $this->title;
$date = new DateTime();
$date = $date->format('Y');
$arrayNUM = count($arrayNumObject);



?>
<div class="lu-object-process-index">
    <?= Html::a('<- вернуться к план-графику', ['../lu/lu-process/' , 'zakup' => Yii::$app->request->get('zakup')], ['class' => 'btn btn-primary']) ?>
   <br>
   <br>

    <p>
    <?php
    $zakupka = app\modules\lu\models\ZakupCard::find()->where(['=', 'id', Yii::$app->request->get('zakup') ])->one();
    $step = app\modules\lu\models\LuProcessStep::find()->where(['=', 'id', Yii::$app->request->get('step') ])->one();

    echo 'Закупка: ' . $zakupka->zakup_num;
    echo '<br>';


    // echo $model->fed_subject;
    echo 'Субъект РФ: ' . app\modules\lu\models\FederalSubject::find()->where(['=', 'federal_subject_id', $zakupka->fed_subject])->one()->name;
    echo '<br>';
    // echo $model->land_cat;
    echo app\modules\lu\models\Land::find()->where(['=', 'land_id', $zakupka->land_cat ])->one()->name;
    echo '<br> </p>';
    echo '<h3>' . $step->step_name;
    echo '<br> <br></h3>';
    ?>

    <?php
    //Проверка существует ли объекты
    if(empty($object_name)){

        if (\Yii::$app->user->can('lu_object_process_edit')){
            echo '<h4>Вы не добавили ни 1 объекта, вернитесь к закупке и добавьте объект</h4>';
            echo Html::a('Заполнить объект', ['../lu/lu-object/create',
                'zakup' => Yii::$app->request->get('zakup')], ['class' => 'btn btn-primary']);
        }
        else
            echo '<h4>Ещё не добавили ни 1 объекта, вернитесь к план-графику </h4>';




    }
    else{
        for($i = 0;$i < $arrayNUM ; $i++){



            foreach ($object_name as $object_names){
                //Выбираем способ таксации
                if ($object_names['id'] == $arrayNumObject[$i]){
                    foreach ($taxationWay as $taxationWays){
                        if($taxationWays['id'] == $object_names['taxation_way']){
                            $taxation_way = $taxationWays->name;
                        }
                    }
                    
                    foreach ($object_names_arr as $objects_names){
                        // Выводим название с разных таблиц
                        if ($object_names['land_cat'] == 1
                            and $object_names['fed_subject'] == $objects_names['subject_kod']
                            and $object_names['region'] == $objects_names['forestry_kod']){

                            echo '<h4> План-факт по ' ;
                            echo $objects_names['forestry_name'];
                            echo ' лесничеству ' ;
                            break;
                        }
                        elseif($object_names['land_cat'] == 2
                            and $object_names['fed_subject'] == $objects_names['subject_kod']
                            and $object_names['region'] == $objects_names['forestry_kod']){

                            echo '<h4> План-факт по ' ;
                            echo $objects_names['forestry_name'];
                            break;
                        }
                        elseif($object_names['land_cat'] == 3
                            and $object_names['fed_subject'] == $objects_names['subject_kod']
                            and $object_names['region'] == $objects_names['cityregion_kod']){

                            echo '<h4> План-факт по ' ;
                            echo $objects_names['cityregion_name'];
                            break;
                        }
                        elseif($object_names['land_cat'] == 4
                            and $object_names['fed_subject'] == $objects_names['subject_kod']
                            and $object_names['region'] == $objects_names['oopt_kod']){

                            echo '<h4> План-факт по ' ;
                            echo $objects_names['oopt_name'];
                            break;
                        }
//                    elseif($object_names['land_cat'] == 5
//                        and $object_names['fed_subject'] == $objects_names['subject_kod']
//                        and $object_names['region'] == $objects_names['forestry_kod']){
//
//                        echo '<h4> План-факт по ' ;
//                        echo $objects_names['forestry_name'];
//                        break;
//                    }
                    }

                    echo ' способу таксации - <i><b>"' . $taxation_way .'", '. $object_names['taxwork_cat'] . ' разряда</i></b></h4>';
                }
            }

            //Выводим таблицу для просмотра или добавление план-факта
            echo '<table class="table table-striped table-bordered detail-view"> 
                        <tr>
                         <th> Месяц </th>
                         <th> Плановый объем, га</th>
                         <th> Фактический объем, га</th>
                         <th> </th>
                        </tr>';

            foreach ($object_process as $objects_process){
                //Выводим данные из бд для план-факта
                if($objects_process['lu_object'] == $arrayNumObject[$i]){
                    echo '<tr><th>';
                    foreach ($month_all as $month_alls){
                        if ($objects_process->month == $month_alls['id']){
                            echo $month_alls->name;
                        }
                    }
                    echo '</th><th>';
                    echo $objects_process->plan;
                    echo '</th><th>';
                    echo $objects_process->fact;
                    echo '</th><th></th> </tr>';
                }

            }
            if (\Yii::$app->user->can('lu_object_process_edit')){
                //Выводим таблицу для план-факта
                $form = ActiveForm::begin();
                echo $form->field($model, 'lu_object')->hiddenInput(['value' => $arrayNumObject[$i]])->label(false);
                echo $form->field($model, 'lu_process_step')->hiddenInput(['value' => Yii::$app->request->get('step')])->label(false);
                echo $form->field($model, 'year')->hiddenInput(['value' => $date])->label(false);
                echo '<th>';
                echo $form->field($model, 'month')->dropDownList(ArrayHelper::map(app\modules\lu\models\Month::find()->all(), 'id', 'name'))->label(false);
                echo '</th><th>';
                echo $form->field($model, 'plan')->textInput()->label(false);
                echo '</th><th>';
                echo $form->field($model, 'fact')->textInput()->label(false);
                echo '</th><th>';
                echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']);

                ActiveForm::end();

            }
            echo '</th> </tr> </table>';
            echo '<br><br>';
        }
    }



    ?>




</div>
