<?php
/**
 * Created by PhpStorm.
 * User: extead
 * Date: 18.12.14
 * Time: 13:26
 */

namespace backend\assets\AvalonTheme;
use yii\web\AssetBundle;

class AvalonThemeIE9Asset extends AssetBundle
{
    public $cssOptions = ['condition' => 'lte IE9'];
    public $jsOptions = ['condition' => 'lte IE9'];

    public $css = [];

    public $js = [
        'http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js',
        'http://html5shim.googlecode.com/svn/trunk/html5.js',
    ];

}