<?php
/**
 * Created by PhpStorm.
 * User: extead
 * Date: 18.12.14
 * Time: 13:26
 */

namespace backend\assets\AvalonTheme;
use yii\web\AssetBundle;

class AvalonThemeIE10Asset extends AssetBundle
{
    // The files are not web directory accessible, therefore we need
    // to specify the sourcePath property. Notice the @vendor alias used.
    public $sourcePath = '@backend/themes/avalon/assets';
    public $cssOptions = ['condition' => 'lte IE10'];
    public $jsOptions = ['condition' => 'lte IE10'];

    public $css = [];

    public $js = [
        'js/media.match.min.js',
        'js/placeholder.min.js',
    ];

}