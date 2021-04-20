<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
	'name' => 'ЕЦИС лесной кластер',
    'basePath' => dirname(__DIR__),
	'language' => 'ru',
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'KvfP3g96iC7n0dVk6N5ZmgDF-kSU6JdU',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'session' => [
            'class' => 'yii\web\Session',
            'cookieParams' => ['lifetime' => 60 * 60 * 10 ] // 7 * 24 *60 * 60
        ],

		'docsStorage' => [
		'class' => 'trntv\filekit\Storage',
		'baseUrl' => '@web/docs',
		'filesystem'=> function() {
        $adapter = new \League\Flysystem\Adapter\Local('docs');
        return new League\Flysystem\Filesystem($adapter);
			 }
		],
    		'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['user'],
        ],
		 'i18n' => [
            'translations' => [
                'yii2mod.rbac' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2mod/rbac/messages',
                ],
               
            ],
        ],
		/**'authManager' => [
			'class' => 'yii\rbac\PhpManager',
			'defaultRoles' => ['admin', 'superuser', 'superviser', 'user'],
			],*/
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/index',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            //'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [ 

            ],
        ],
        
    ],
    'params' => $params,

	'modules' => [

		'gridview' =>  [
        'class' => '\kartik\grid\Module',
		],
        'forest' => [
            'class' => 'app\modules\forest\forest',
        ],
		'forest_work' => [
            'class' => 'app\modules\forest_work\forest_work',
        ],

		'user' => [
            'class' => 'app\modules\user\user',
        ],
		'rbac' => [
            'class' => 'yii2mod\rbac\Module',
        ],
		'pd' => [
            'class' => 'app\modules\pd\pd',
        ],
        'lu' => [
            'class' => 'app\modules\lu\lu',
        ],
        'audit' => [
            'class' => 'app\modules\audit\audit',
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
//        'allowedIPs' => ['127.0.0.1', '::1', '192.168.9.122', '192.168.10.79', '192.168.10.69', '178.176.30.40'],
//        'visible' =>  \Yii::$app->user->can('admin'),
//        'allowedIPs' => [(\Yii::$app->user->can('admin') ? '*' : '127.0.0.1')],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
//        'allowedIPs' => ['127.0.0.1', '::1', '192.168.9.122', '192.168.10.79', '192.168.10.69', '178.176.30.40'],
//        'visible' =>  \Yii::$app->user->can('admin'),
    ];
}

return $config;
