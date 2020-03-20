<?php
/**
 * Created by PhpStorm.
 * User: extead
 * Date: 18.12.14
 * Time: 13:26
 */

namespace backend\assets\AvalonTheme;
use yii\web\AssetBundle;
use yii\web\View;

class Plugin_JqueryUIAsset extends AssetBundle
{
    public $sourcePath = '@backend/themes/avalon/assets/plugins/jquery-ui';

    public $jsOptions = ['position' => View::POS_HEAD];

    public $css = [
        'jquery-ui.1.11.4.css',
    ];

    public $js = [
        'jquery-ui.1.11.4.js',
    ];
}