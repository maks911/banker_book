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
        '//unpkg.com/vanilla-tags-input/tags-input.css',
        'dist/css/adminlte.min.css',
        'dist/css/style.css',
    ];
    public $js = [
        'plugins/jquery/jquery.min.js',
        'plugins/jquery-ui/jquery-ui.min.js',
        '//unpkg.com/vanilla-tags-input@1.0.0/tags-input.js',
        'dist/js/pages/dashboard.js',
    ];
    public $depends = [

    ];
}
