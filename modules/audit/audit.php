<?php

namespace app\modules\audit;

use yii\helpers\ArrayHelper;
use yii2mod\rbac\filters\AccessControl;


/**
 * audit module definition class
 */
class audit extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\audit\controllers';

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
        if ( \Yii::$app->controller->id == 'audit'){
            $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['audit__edit']];
            $behaviors['access']['rules'][] = ['allow' => true,'actions'=> ['index','view','summary','instruction'], 'roles' => ['audit__view']];
        }

        elseif ( \Yii::$app->controller->id == 'audit-expertise'){
            $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['audit_expertise_edit']];
            $behaviors['access']['rules'][] = ['allow' => true,'actions'=> ['index','view','summary','instruction'], 'roles' => ['audit_expertise_view']];
        }

        elseif ( \Yii::$app->controller->id == 'audit-person'){
            $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['audit_person_edit']];
            $behaviors['access']['rules'][] = ['allow' => true,'actions'=> ['index','view','summary','instruction'], 'roles' => ['audit_person_view']];
        }

        elseif ( \Yii::$app->controller->id == 'audit-process'){
            $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['audit_process_edit']];
            $behaviors['access']['rules'][] = ['allow' => true,'actions'=> ['index','view','summary','instruction'], 'roles' => ['audit_process_view']];
        }

        elseif ( \Yii::$app->controller->id == 'audit-revision'){
            $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['audit_revision_edit']];
            $behaviors['access']['rules'][] = ['allow' => true,'actions'=> ['index','view','summary','instruction'], 'roles' => ['audit_revision_view']];
        }

        elseif ( \Yii::$app->controller->id == 'audit-unscheduled'){
            $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['audit_unscheduled_edit']];
            $behaviors['access']['rules'][] = ['allow' => true,'actions'=> ['index','view','summary','instruction'], 'roles' => ['audit_unscheduled_view']];
        }

        elseif ( \Yii::$app->controller->id == 'audit-type'){
            $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['admin']];
        }

        elseif ( \Yii::$app->controller->id == 'oiv-subject'){
            $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['admin']];
            $behaviors['access']['rules'][] = ['allow' => false,'actions'=>['create','update'],'roles' => ['oiv_view']];
            $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['oiv_view']];
        }

        //Колективные тренировки
        elseif ( \Yii::$app->controller->id == 'forestgrow-zone'
              or \Yii::$app->controller->id == 'forestgrow-region'
              or \Yii::$app->controller->id == 'forestgrow-region-subject'){
            $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['admin']];
        }

        elseif ( \Yii::$app->controller->id == 'munic-region'){
            $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['admin']];
            $behaviors['access']['rules'][] = ['allow' => false,'actions'=>['create','update'],'roles' => ['munic_view']];
            $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['munic_view']];
        }

        elseif ( \Yii::$app->controller->id == 'training-person'){
            $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['tr_person_edit']];
            $behaviors['access']['rules'][] = ['allow' => false,'actions'=>['create','update'],'roles' => ['tr_person_view']];
            $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['tr_person_view']];

        }
        elseif ( \Yii::$app->controller->id == 'training-process'){
            $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['tr_process_edit']];
            $behaviors['access']['rules'][] = ['allow' => false,'actions'=>['create','update'],'roles' => ['tr_process_view']];
            $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['tr_process_view']];
            $behaviors['access']['rules'][] = ['allow' => false,'actions'=>['create','update'],'roles' => ['tr_process_check']];
            $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['tr_process_check']];
        }

        elseif ( \Yii::$app->controller->id == 'brigade'){
            $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['brigade_edit']];
            $behaviors['access']['rules'][] = ['allow' => false,'actions'=>['create','update'],'roles' => ['brigade_view']];
            $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['brigade_view']];
        }
        elseif ( \Yii::$app->controller->id == 'brigade-online'){
            $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['brigade_online_edit']];
            $behaviors['access']['rules'][] = ['allow' => false,'actions'=>['create','update'],'roles' => ['brigade_online_view']];
            $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['brigade_online_view']];
        }






        $behaviors['access']['rules'][] = ['allow' => false, 'roles' => ['@']];
        return $behaviors;
    }



}