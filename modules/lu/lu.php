<?php

namespace app\modules\lu;

use yii2mod\rbac\filters\AccessControl;

/**
 * lu module definition class
 */
class lu extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\lu\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
			public function behaviors(){
                $behaviors = parent::behaviors();

                if (!isset($behaviors['access']['class'])) {
                    $behaviors['access']['class'] = AccessControl::className();
                }

                //Контрольные мероприятия
                if ( \Yii::$app->controller->id == 'lu-object'){
                    $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['lu_object_edit']];
                    $behaviors['access']['rules'][] = ['allow' => false,'actions'=> ['update'], 'roles' => ['lu_object_view']];
                    $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['lu_object_view']];
                }
                elseif( \Yii::$app->controller->id == 'lu-object-process'){
                    $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['lu_object_process_edit']];
                    $behaviors['access']['rules'][] = ['allow' => false,'actions'=> ['create','update'], 'roles' => ['lu_object_process_view']];
                    $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['lu_object_process_view']];
                }
                elseif( \Yii::$app->controller->id == 'lu-process'){
                    $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['lu_process_edit']];
                    $behaviors['access']['rules'][] = ['allow' => false,'actions'=> ['create','update'], 'roles' => ['lu_process_view']];
                    $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['lu_process_view']];
                }
                elseif( \Yii::$app->controller->id == 'oopt'){
                    $behaviors['access']['rules'][] = ['allow' => false,'actions'=> ['create','update'], 'roles' => ['oopt_view']];
                    $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['oopt_view']];
                }
                elseif( \Yii::$app->controller->id == 'zakup-card'){
                    $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['lu_zakup_edit']];
                    $behaviors['access']['rules'][] = ['allow' => false,'actions'=> ['create','update'], 'roles' => ['lu_zakup_view']];
                    $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['lu_zakup_view']];
                }
                elseif( \Yii::$app->controller->id == 'vaccination'){
                    $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['vaccination_edit']];
                    $behaviors['access']['rules'][] = ['allow' => false,'actions'=> ['create','update'], 'roles' => ['vaccination_view']];
                    $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['vaccination_view']];
                }
                elseif( \Yii::$app->controller->id == 'gps-tracking'){
                    $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['gps_edit']];
                    $behaviors['access']['rules'][] = ['allow' => false,'actions'=> ['create','update'], 'roles' => ['gps_view']];
                    $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['gps_view']];
                    $behaviors['access']['rules'][] = ['allow' => false,'actions'=> ['create','update'], 'roles' => ['gps_check']];
                    $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['gps_check']];
                }

                $behaviors['access']['rules'][] = ['allow' => true, 'roles' => ['admin']];
                $behaviors['access']['rules'][] = ['allow' => false, 'roles' => ['@']];
                return $behaviors;
}
}
