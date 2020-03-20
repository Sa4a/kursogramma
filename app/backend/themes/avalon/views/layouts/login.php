<?php
use yii\helpers\Html;
use backend\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no']);
$this->registerMetaTag(['name' => 'apple-mobile-web-app-capable', 'content' => 'yes']);
$this->registerMetaTag(['name' => 'apple-touch-fullscreen', 'content' => 'yes']);
$this->registerMetaTag(['name' => 'description', 'content' => 'Login']);
$this->registerMetaTag(['name' => 'author', 'content' => 'The Red Team']);
$this->registerMetaTag(['http-equiv' => 'X-UA-Compatible', 'content' => 'IE=edge,chrome=1']);

?>
<?php $this->beginPage() ?>

    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>

    <?php $this->beginBody() ?>
    <body class="focused-form">


    <div class="container">
        <?=$content?>
    </div>

    <!-- End loading page level scripts-->

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>