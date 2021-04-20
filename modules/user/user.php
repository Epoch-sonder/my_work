<?php

namespace app\modules\user;

/**
 * user module definition class
 */
class user extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\user\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
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

                [
                    'allow' => false,
                    'actions'=>['create','update', 'update-password'],
                    'roles' => ['user_view'],
                ],
                [
                    'allow' => true,
                    'roles' => ['user_view'],
                ],

            ],
        ],
    ];
}

}
