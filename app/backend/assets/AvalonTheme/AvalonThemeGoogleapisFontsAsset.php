<?php

namespace backend\assets\AvalonTheme;
use yii\web\AssetBundle;

class AvalonThemeGoogleapisFontsAsset extends AssetBundle
{
    // The files are not web directory accessible, therefore we need
    // to specify the sourcePath property. Notice the @vendor alias used.
    public $css = [
        'http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,700',
    ];
}