<?php

namespace maddoger\admin\assets;

use yii\web\AssetBundle;

class AdminAsset extends AssetBundle
{
    public $sourcePath = '@maddoger/admin/assets/dist';

    public $css = [
        'css/app.css',
        //'css/skins/_all-skins.min.css',
    ];
    public $js = [
        'js/adminlte.js',
        'js/app.js',
    ];
    public $depends = [
        'maddoger\admin\assets\FontAwesomeAsset',
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}