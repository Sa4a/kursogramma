<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 23.03.2020
 * Time: 10:05
 */


$this->registerJsFile( '/js/editor_fields.js',['position' => yii\web\View::POS_HEAD, 'depends' => ['backend\assets\AppAsset']] );
$this->registerJsFile( 'https://cdn.tiny.cloud/1/z1otzveeb3gobewt4f6srtlkbayge9vw8hrsifec5u31tfzs/tinymce/5/tinymce.min.js',['position' => yii\web\View::POS_HEAD, 'depends' => ['backend\assets\AppAsset']] );

$this->registerCssFile( '/css/editor_fields.css');//регестрирует ссылку на js файл
$rand=rand(0,1000);
?>

<div class="col-md-12 sortable texts<?=$rand?>" data-container_name ="texts<?=$rand?>"  style="padding-top: 50px;" data-fields="text<?=$rand?>" data-titles ="Текст" data-type="textarea">
    <div class="position-absolute" style="position: absolute;right: 0px;margin-top: -48px;">
        <button type="button" class="btn-edite btn btn-info">Редактировать</button>
    </div>
    <p class="text-break text<?=$rand?>">  Текст для примера</p>
</div>
