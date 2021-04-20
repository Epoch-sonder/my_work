<?php

namespace app\modules\pd;

use yii2mod\rbac\filters\AccessControl;

/**
 * pd module definition class
 */
class pd extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\pd\controllers';

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
            if ( \Yii::$app->controller->id == 'pd-work-process'){
                $behaviors['access']['rules'][] = ['allow' => true,'actions'=>['index','create'], 'roles' => ['pd_view']];
                $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['pd_ca']];
                $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['pd_edit']];
            }
            else{
                $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['pd_ca']];
                $behaviors['access']['rules'][] = ['allow' => false,'actions'=>['summary-pol','summary-project'],'roles' => ['pd_edit']];
                $behaviors['access']['rules'][] = ['allow' => true,'roles' => ['pd_edit']];
                $behaviors['access']['rules'][] = ['allow' => true,'actions'=>['index','view','instruction-pd','summary-pol','summary-project'], 'roles' => ['pd_view']];
            }
//            $behaviors['access']['rules'][] = ['allow' => false, 'roles' => ['@']];
            return $behaviors;

}
}
