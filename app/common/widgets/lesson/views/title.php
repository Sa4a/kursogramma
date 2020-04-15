<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 23.03.2020
 * Time: 10:05
 */


/*$js = <<< JS
alert("okey!");
JS;

$css = <<< CSS
alert("okey!");
CSS;*/

#$this->registerJs( $js, $position = self::POS_READY, $key = null );//регестрирует код на странице
$this->registerJsFile('/js/editor_fields.js', ['position' => yii\web\View::POS_HEAD, 'depends' => ['backend\assets\AppAsset']]);//регестрирует ссылку на js файл
$this->registerCssFile('/css/editor_fields.css');//регестрирует ссылку на js файл
#$this->registerJsVar( $name, $value, $position = self::POS_HEAD );//регестрирует отдельную переменную

$rand=rand(0,1000);
?>

<!--<div class="editor_fields">
</div>
-->
<div class="col-md-12 sortable titles<?=$rand?>" data-container_name ="titles<?=$rand?>"  style="padding-top: 50px;"
     data-type="input,input"
     data-field_name="title_text,footer_text"
     data-fields="title,footer"
     data-titles="Заголовок, Подзаголовок"
     data-code="titleWidget"
>
    <div class="position-absolute" style="position: absolute;right: 0px;">
        <button type="button" class="btn-edite btn btn-info"  >Редактировать</button>
    </div>
        <h1 class="mb-0 title"><?= $title ?></h1>
        <small class="footer"><?= $title_footer ?></small>
</div>
