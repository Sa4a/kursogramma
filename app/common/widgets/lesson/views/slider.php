<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 23.03.2020
 * Time: 19:59
 */
$rand=rand(0,1000);
//для картинок
//http://xn--80akiaokt3b4b.xn--d1acnqm.xn--j1amh/posts/user/7/demo/show-image-before-upload/index.html
$this->registerJsFile('/js/editor_fields.js', ['position' => yii\web\View::POS_HEAD, 'depends' => ['backend\assets\AppAsset']]);//регестрирует ссылку на js файл
$this->registerJsFile('/js/slider/slider.js', ['position' => yii\web\View::POS_HEAD, 'depends' => ['backend\assets\AppAsset']]);//регестрирует ссылку на js файл

$this->registerCssFile('/css/slider/slider.css');//регестрирует ссылку на js файл


?>




<div class="col-md-12 sortable slider<?=$rand?>" data-container_name ="slider<?=$rand?>"  style="padding-top: 50px;"

     data-fields="slider_<?=$rand?>"
     data-titles ="Добавляйте картинки"
     data-type="slider"

>
    <div class="position-absolute" style="position: absolute;right: 0px;margin-top: -48px;">
        <button type="button" class="btn-edite btn btn-info">Редактировать</button>
    </div>

    <div  class="owl-carousel owl-theme slider_<?=$rand?>">
    </div>


</div>


