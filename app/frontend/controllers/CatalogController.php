<?php
namespace frontend\controllers;


use yii\web\Controller;


class CatalogController extends BaseController
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionItem(){
        return $this->render('item');
    }

}
