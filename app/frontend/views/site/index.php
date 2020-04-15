<?php
/* @var $this yii\web\View */

  echo \frontend\widgets\MainBannersWidget::widget()
?>
<div class="row">
    <div class="col-md-3">
        <?= \frontend\widgets\CatalogStructureWidget::widget() ?>
    </div>
    <div class="col-md-9">
        <?= \frontend\widgets\BestSellersWidget::widget() ?>
    </div>
</div>