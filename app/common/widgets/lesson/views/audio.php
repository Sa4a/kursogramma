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


<div class="col-md-12 sortable audio<?= $rand ?>" data-container_name="audio<?= $rand ?>" style="padding-top: 50px;"

     data-fields="audio<?= $rand ?>"
     data-titles="Видео"
     data-type="audio"

>
    <div class="position-absolute" style="position: absolute;right: 0px;margin-top: -48px;">
        <button type="button" class="btn-edite btn btn-info">Редактировать</button>
    </div>
    <div class="audio_container">
        <audio controls>
            <source class="audio<?= $rand ?>" src="<?= $audio ?>" type="audio/ogg">
            Your browser does not support the audio element.
        </audio>
    </div>
</div>


