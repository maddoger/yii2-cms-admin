<?php

namespace maddoger\admin\assets;

use yii\web\AssetBundle;

class AdminAsset extends AssetBundle
{
    public $sourcePath = '@maddoger/admin/assets/dist';

    public $css = [
        'css/AdminLTE.css',
        //'css/skins/_all-skins.min.css',
    ];
    public $js = [
        'js/app.js',
        'js/demo.js',
    ];
    public $depends = [
        'maddoger\admin\assets\FontAwesomeAsset',
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}