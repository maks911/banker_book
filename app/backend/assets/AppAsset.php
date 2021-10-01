<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{

    public $sourcePath = '@app/themes/admin';
    public $baseUrl    = '@web';

    public $css = [
        '//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback',
        'plugins/fontawesome-free/css/all.min.css',
        'dist/css/adminlte.min.css',
        'dist/css/style.css',
    ];
    public $js = [
        'plugins/jquery/jquery.min.js',
        'plugins/jquery-ui/jquery-ui.min.js',
        //'plugins/bootstrap/js/bootstrap.bundle.min.js',
        'dist/js/adminlte.js',
        'dist/js/pages/dashboard.js',
    ];
    public $depends = [

    ];
}
