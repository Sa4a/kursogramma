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




<div class="col-md-12 sortable text_and_image<?=$rand?>" data-container_name ="text_and_image<?=$rand?>"  style="padding-top: 50px;"

     data-fields="image<?=$rand?>,text<?=$rand?>"
     data-titles ="Картинка, текст"
     data-type="image,textarea"

>
    <div class="position-absolute" style="position: absolute;right: 0px;margin-top: -48px;">
        <button type="button" class="btn-edite btn btn-info">Редактировать</button>
    </div>

    <div class="row featurette">
        <div class="col-md-7">
            <p class="lead text<?=$rand?>"><?=$text?></p>
        </div>
        <div class="col-md-5">
            <img width="500" height="500" class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto image<?=$rand?>" src="<?=$image?>"/>
        </div>
    </div>

</div>


