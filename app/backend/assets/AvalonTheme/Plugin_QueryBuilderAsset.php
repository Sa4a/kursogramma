<?php

namespace backend\assets\AvalonTheme;
use leandrogehlen\querybuilder\QueryBuilderAsset;
use yii\web\AssetBundle;
use yii\web\View;

class Plugin_QueryBuilderAsset extends AssetBundle
{
    // The files are not web directory accessible, therefore we need
    // to specify the sourcePath property. Notice the @vendor alias used.

    public $sourcePath = '@backend/themes/avalon/assets/plugins/query-builder';

    public $jsOptions = ['position' => View::POS_END];

    public $css = [];

    public $js = [
        'query-builder-elasticsearch.js'
    ];

    public $depends = [
        'backend\assets\AvalonTheme\QueryBuilderAsset'
    ];
}