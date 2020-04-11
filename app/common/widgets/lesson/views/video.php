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

$rand = rand(0, 1000);
?>


<div class="col-md-12 sortable video<?= $rand ?>" data-container_name="video<?= $rand ?>" style="padding-top: 50px;"

     data-fields="video<?= $rand ?>"
     data-titles="Видео"
     data-type="video"

>
    <div class="position-absolute" style="position: absolute;right: 0px;margin-top: -48px;">
        <button type="button" class="btn-edite btn btn-info">Редактировать</button>
    </div>
    <div class="video_container">
        <video controls>
            <source class="video<?= $rand ?>" src="<?= $video ?>" type="video/ogg">
            Your browser does not support the audio element.
        </video>
    </div>

    <!-- <video controls>
        <source src="<? /*=$video*/ ?>" type="audio/ogg">
        Your browser does not support the audio element.
    </video>-->
</div>


