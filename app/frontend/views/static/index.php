<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 09.04.2020
 * Time: 14:22
 */
use yii\widgets\Breadcrumbs;

?>


<?php
echo Breadcrumbs::widget([
    'itemTemplate' => "<li><i>{link}</i></li>\n",
    'homeLink' => [
        'label' => 'Главная',
        'url' => Yii::$app->homeUrl,
    ],
    'links' => Yii::$app->domain->getBreadcrumbs(),
]);
?>

<div class="row">
    <div class="col-md-3">
        <?= \frontend\widgets\StaticSubmenuWidget::widget([ 'string_menu' => Yii::$app->domain->getPageParamByCode('submenu')]) ?>
    </div>
    <div class="col-md-9">
        <h1><?=$title?></h1>
        <?=$content?>
    </div>
</div>

