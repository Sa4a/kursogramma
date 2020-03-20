<?php
/**
 * Created by PhpStorm.
 * User: extead
 * Date: 18.12.14
 * Time: 13:26
 */

namespace backend\assets\AvalonTheme;
use yii\web\AssetBundle;

class AvalonThemeAsset extends AssetBundle
{
    // The files are not web directory accessible, therefore we need
    // to specify the sourcePath property. Notice the @vendor alias used.
    public $sourcePath = '@backend/themes/avalon/assets';
    public $css = [
        'fonts/font-awesome/css/font-awesome.min.css',
        'less/styles.less',
    ];

    public $js = [
        'js/enquire.min.js',

        'js/application.js',

        'js/jquery.md5.js'
    ];

    public $depends = [
        'backend\assets\AvalonTheme\AvalonThemeIE9Asset',
        'backend\assets\AvalonTheme\AvalonThemeIE10Asset',

        'backend\assets\AvalonTheme\Plugin_JqueryUIAsset',
        //'backend\assets\AvalonTheme\AvalonThemeGoogleapisFontsAsset',
        'backend\assets\AvalonTheme\Plugin_iCheckAsset',
        'backend\assets\AvalonTheme\Plugin_SwitcheryAsset',
        'backend\assets\AvalonTheme\Plugin_FormCkeditorAsset',
        'backend\assets\AvalonTheme\Plugin_JsTreeAsset',
    ];
}