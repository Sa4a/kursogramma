<?php
namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class StaticController extends BaseController
{

    public function actionIndex()
    {
        $title = Yii::$app->domain->getPageParamByCode('name');
        $content = Yii::$app->domain->getPageParamByCode('content');
        return $this->render('index',[ 'title' => $title, 'content' => $content ]);
    }

}
