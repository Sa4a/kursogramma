<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 09.04.2020
 * Time: 14:39
 */

namespace frontend\controllers;

use yii\web\Controller;
use Yii;

class BaseController extends Controller
{

    public function beforeAction($action)
    {
        Yii::$app->domain->getId();
        return parent::beforeAction($action);
    }



}