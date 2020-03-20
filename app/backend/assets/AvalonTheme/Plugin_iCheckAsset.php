<?php
/**
 * Created by PhpStorm.
 * User: extead
 * Date: 19.12.14
 * Time: 9:44
 */

namespace backend\assets\AvalonTheme;
use yii\web\AssetBundle;
use yii\web\View;

class Plugin_iCheckAsset extends AssetBundle
{
    // The files are not web directory accessible, therefore we need
    // to specify the sourcePath property. Notice the @vendor alias used.

    public $sourcePath = '@backend/themes/avalon/assets/plugins/iCheck';

    public $jsOptions = ['position' => View::POS_END];

    public $css = [
        'skins/minimal/blue.css',
    ];

    public $js = [
        'icheck.min.js',
    ];
}