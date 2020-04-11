<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Lesson */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lesson-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea() ?>

    <?= Html::img($model->getUploadUrl('image'), ['class' => 'img-thumbnail','width'=>100]) ?>
    <?= $form->field($model, 'image')->fileInput() ?>

    <?= $form->field($model, 'module_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\Module::find()->all(), 'id', 'name')) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


    <?php if (!$model->isNewRecord): ?>

        <div class="form-group ">
            <label class="control-label">Добавить виджет </label>
            <?=Html::dropDownList('wid','',[''=>'-']+\common\services\LessonWidgetsFactory::$widgets,['class'=>'form-control', 'id'=>'select_widget'])?>
        </div>


            <div id="widgets-lesson">
            </div>
    <?php endif; ?>

</div>

<?php
$this->registerJsFile('/js/slider/slider.js', ['position' => yii\web\View::POS_HEAD, 'depends' => ['backend\assets\AppAsset']]);//регестрирует ссылку на js файл
$this->registerCssFile('/css/slider/slider.css');//регестрирует ссылку на js файл
$this->registerJsFile('/js/editor_fields.js', ['position' => yii\web\View::POS_HEAD, 'depends' => ['backend\assets\AppAsset']]);//регестрирует ссылку на js файл
$this->registerCssFile('/css/editor_fields.css');//регестрирует ссылку на js файл
$this->registerJsFile( 'https://code.jquery.com/ui/1.12.1/jquery-ui.js',['position' => yii\web\View::POS_HEAD, 'depends' => ['backend\assets\AppAsset']] );
$this->registerJsFile( 'https://cdn.tiny.cloud/1/z1otzveeb3gobewt4f6srtlkbayge9vw8hrsifec5u31tfzs/tinymce/5/tinymce.min.js',['position' => yii\web\View::POS_HEAD, 'depends' => ['backend\assets\AppAsset']] );
$this->registerJs( "
$('#widgets-lesson').sortable({placeholder: \"sortable\",helper:'clone'});
$('#select_widget').change(function(){
    $.ajax({
        url: '/widgets/get',
        type: 'get',
        data: {'widget_name':$(this).val()}
    }).done(function(data) {
        $('#widgets-lesson').append(data);
    });
})
");//регестрирует код на странице
?>