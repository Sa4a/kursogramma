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

class Plugin_FormValidationAsset extends AssetBundle
{
    // The files are not web directory accessible, therefore we need
    // to specify the sourcePath property. Notice the @vendor alias used.

    public $sourcePath = '@backend/themes/avalon/assets/plugins/form-validation';

    //public $jsOptions = ['position' => View::POS_HEAD];

    public $cssOptions = ['position' => View::POS_HEAD];

    public $css = [];

    public $js = [
       'jquery.validate.min.js',
        'localization/messages_ru.min.js'
    ];
}