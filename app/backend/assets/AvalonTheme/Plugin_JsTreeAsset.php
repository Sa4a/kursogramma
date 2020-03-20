<?php

namespace backend\assets\AvalonTheme;
use yii\web\AssetBundle;
use yii\web\View;

class Plugin_JsTreeAsset extends AssetBundle
{
    // The files are not web directory accessible, therefore we need
    // to specify the sourcePath property. Notice the @vendor alias used.

    public $sourcePath = '@backend/themes/avalon/assets/plugins/jstree/dist';

    public $jsOptions = ['position' => View::POS_END];

    public $cssOptions = ['position' => View::POS_HEAD];

    public $css = [
        'themes/avalon/style.min.css'
    ];

    public $js = [
        'jstree.min.js'
    ];
}