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

class Plugin_FormCkeditorAsset extends AssetBundle
{
    // The files are not web directory accessible, therefore we need
    // to specify the sourcePath property. Notice the @vendor alias used.

    //public $sourcePath = '@backend/themes/avalon/assets/plugins/form-ckeditor';

    public $jsOptions = ['position' => View::POS_END];

    public $cssOptions = ['position' => View::POS_HEAD];

    public $js = [
        '//cdn.ckeditor.com/4.5.3/standard/ckeditor.js'
    ];
}