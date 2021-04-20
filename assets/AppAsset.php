<?php

namespace app\assets;
use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
		'css/sidebar.css',
		'css/site.css',
		'css/style.css',
		'css/all.min.css',
    ];

    public $js = [
		'js/script.js',
        'js/bootstrap.js',
		'js/fontawesome.min.js',
        'js/snowfall.js',
	];

    // public $jsOptions = ['position' => \yii\web\View::POS_HEAD];

    public $depends = [
    	'yii\web\YiiAsset',
    	'yii\bootstrap\BootstrapAsset',
    ];

    // public $dependsOptions = ['position' => \yii\web\View::POS_HEAD];



}
