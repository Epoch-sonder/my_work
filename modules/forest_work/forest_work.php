<?php

namespace app\modules\forest_work;

/**
 * forest_work module definition class
 */
class forest_work extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\forest_work\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {

    }

	public function behaviors(){
    return [
        'access' => [
            'class' => \yii\filters\AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['admin'],
                ],
            ],
        ],
    ];
}

}
