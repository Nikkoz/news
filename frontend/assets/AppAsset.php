<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://fonts.googleapis.com/css?family=PT+Serif:400,400i,700,700i|Roboto:100,100i,300,300i,400,400i,500,500i,700,700i&amp;subset=cyrillic',
        'css/styles.css',
        'css/site.css',
    ];
    public $js = [
        'js/jquery-ui.min.js',
        'js/owl.carousel.min.js',
        'js/main.js',
        'js/script.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'frontend\assets\AppIeAssets'
    ];
}
