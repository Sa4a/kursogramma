<?php

namespace backend\assets\AvalonTheme;

use leandrogehlen\querybuilder\QueryBuilderAsset as OriginalQueryAsset;

class QueryBuilderAsset extends OriginalQueryAsset
{
    public $depends = [
        'leandrogehlen\querybuilder\BootstrapAsset',
    ];
}