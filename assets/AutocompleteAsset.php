<?php

namespace maddoger\admin\assets;

use yii\web\AssetBundle;

class AutocompleteAsset extends AssetBundle
{
    public $sourcePath = '@bower/devbridge-autocomplete/dist';

    public $js = [
        'jquery.autocomplete.min.js',
    ];
}