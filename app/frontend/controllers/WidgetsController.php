<?php

namespace frontend\controllers;

use backend\controllers\BaseController;

class WidgetsController extends BaseController
{

    protected $widget_params =
        [
            'titleWidget'=>[
                'title_text'=>[
                    'page_module_param' => 'titleWidget_title',
                    'page_module_type' => 5,
                ],
                'footer_text'=>[
                    'page_module_param' => 'titleWidget_footer',
                    'page_module_type' => 5,
                ],
            ]
        ];

    /**
     * @param string $widget_name
     * @return mixed
     * @throws \Exception
     */
    public function actionGet($widget_name)
    {
        return $this->renderPartial('get', ['widget_name' => $widget_name]);
    }

    public function actionSave()
    {

    }
}
