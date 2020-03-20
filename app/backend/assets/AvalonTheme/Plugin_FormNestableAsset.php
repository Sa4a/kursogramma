<?php

namespace backend\assets\AvalonTheme;
use yii\web\AssetBundle;
use yii\web\View;

class Plugin_FormNestableAsset extends AssetBundle
{
    // The files are not web directory accessible, therefore we need
    // to specify the sourcePath property. Notice the @vendor alias used.

    public $sourcePath = '@backend/themes/avalon/assets/plugins/form-nestable';

    //public $jsOptions = ['position' => View::POS_END];

    public $cssOptions = ['position' => View::POS_HEAD];

    public $css = [
        'jquery.nestable.css',
    ];

    public $js = [
        'ui-nestable.js',
        'jquery.nestable.min.js'
    ];
}