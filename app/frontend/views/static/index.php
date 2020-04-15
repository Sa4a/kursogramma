<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 09.04.2020
 * Time: 14:22
 */
use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Html;
?>



<?php
$this->registerJsFile('/js/editor_fields.js', ['position' => yii\web\View::POS_HEAD, 'depends' => ['frontend\assets\AppAsset']]);//регестрирует ссылку на js файл
$this->registerCssFile('/css/editor_fields.css');//регестрирует ссылку на js файл
$this->registerJs( "
");//регестрирует код на странице
?>

<?php
echo Breadcrumbs::widget([
    'itemTemplate' => "\n\t<li class=\"breadcrumb-item\"><i>{link}</i></li>\n", // template for all links
    'activeItemTemplate' => "\t<li class=\"breadcrumb-item active\">{link}</li>\n", // template for the active link
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
        <?/*=$content*/?>

        <div class="container">
            <div class="row ">
                <div class="col-sm-12 text-center add-widgets">
                    <i class="fa fa-plus-square " style="font-size: 35px;"></i>
                </div>
            </div>
            <div class="row add-widgets-block d-none">
               <?php foreach(\common\services\LessonWidgetsFactory::$widgetsIcon as $code=>$icon):?>
                <div class="col-sm text-center">
                   <i class="btn-add-widget <?=$icon?>" style="font-size: 35px;" data-code="<?=$code?>"></i>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div id="widgets-lesson">
        </div>


    </div>
</div>


<!-- Modal -->
<div class="modal fade modal-right right" id="widget-editor-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body widget-modal-content">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-primary btn-save">Сохранить</button>
            </div>
        </div>
    </div>
</div>

