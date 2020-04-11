<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 07.04.2020
 * Time: 12:11
 */

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;

NavBar::begin([
    'brandLabel' => Html::encode(Yii::$app->domain->getParamByCode('company')),
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);

$menuElements = explode(PHP_EOL, Yii::$app->domain->getParamByCode('main_menu'));

foreach ($menuElements as $menuElement) {
    $menuElement = explode('§|§', $menuElement);
    $menuItems[] = ['label' => $menuElement[1], 'url' =>$menuElement[0] ];
}

if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
    $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
} else {
    $menuItems[] = '<li>'
        . Html::beginForm(['/site/logout'], 'post')
        . Html::submitButton(
            'Logout (' . Yii::$app->user->identity->username . ')',
            ['class' => 'btn btn-link logout']
        )
        . Html::endForm()
        . '</li>';
}
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $menuItems,
]);
NavBar::end();