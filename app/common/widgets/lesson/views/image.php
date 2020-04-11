<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 23.03.2020
 * Time: 19:59
 */

//для картинок
//http://xn--80akiaokt3b4b.xn--d1acnqm.xn--j1amh/posts/user/7/demo/show-image-before-upload/index.html
$this->registerJsFile('/js/editor_fields.js', ['position' => yii\web\View::POS_HEAD, 'depends' => ['backend\assets\AppAsset']]);//регестрирует ссылку на js файл
$this->registerCssFile('/css/editor_fields.css');//регестрирует ссылку на js файл

$rand=rand(0,1000);
?>




<div class="col-md-12 sortable images<?=$rand?>" data-container_name ="images<?=$rand?>"  style="padding-top: 50px;"

     data-fields="image<?=$rand?>"
     data-titles ="Картинка"
     data-type="image"

>
    <div class="position-absolute" style="position: absolute;right: 0px;margin-top: -48px;">
        <button type="button" class="btn-edite btn btn-info">Редактировать</button>
    </div>
    <img src="<?=$image?>" class="img-fluid image<?=$rand?>" style="height: 200px; width: 100%" alt="Responsive image">
</div>


