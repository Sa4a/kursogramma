<?php


namespace backend\assets\AvalonTheme;
use yii\web\AssetBundle;
use yii\web\View;

class Plugin_FlotChartsAsset extends AssetBundle
{
    // The files are not web directory accessible, therefore we need
    // to specify the sourcePath property. Notice the @vendor alias used.

    public $sourcePath = '@backend/themes/avalon/assets/plugins/charts-flot';

    public $jsOptions = ['position' => View::POS_END];

    public $css = [];

    public $js = [
        'jquery.flot.js',
        'jquery.flot.pie.min.js',
        'jquery.flot.orderBars.min.js',
        'jquery.flot.tooltip.min.js',
        'jquery.flot.time.min.js'
    ];
}