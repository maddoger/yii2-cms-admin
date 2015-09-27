<?php

namespace maddoger\admin\assets;

use yii\web\AssetBundle;

class AdminAsset extends AssetBundle
{
    //public $sourcePath = '@maddoger/admin/assets/dist';
    public $sourcePath = '@maddoger/admin/assets/src/AdminLTE-2.3.0/dist';

    public $css = [
        'css/AdminLTE.min.css',
        'css/skins/_all-skins.min.css',
    ];
    public $js = [
        'js/app.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        //'yii\bootstrap\BootstrapPluginAsset',
    ];
}