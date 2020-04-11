<?php

namespace backend\controllers;

use Yii;
use backend\controllers\BaseController;

class WidgetsController extends BaseController
{

    /**
     * @param string $widget_name
     * @return mixed
     * @throws \Exception
     */
    public function actionGet($widget_name){
        return $this->renderPartial('get',['widget_name'=>$widget_name]);
    }
}
