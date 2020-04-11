<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 09.04.2020
 * Time: 14:21
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
    'links' => Yii::$app->domain->getBreadcrumbs('catalog'),
]);
?>

<div class="row">
    <div class="col-md-3">
        <?= \frontend\widgets\CatalogStructureWidget::widget() ?>
    </div>
    <div class="col-md-9">
        Catalog
    </div>
</div>
