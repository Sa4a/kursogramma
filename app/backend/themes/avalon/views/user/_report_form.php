<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\user\User;
use \backend\assets\AvalonTheme\Plugin_FormCkeditorAsset;

/* @var $this yii\web\View */
/* @var $model backend\models\client\form\ClientForm */
/* @var $form yii\widgets\ActiveForm */

Plugin_FormCkeditorAsset::register($this);
?>

<div class="report-form">

    <?php $form = ActiveForm::begin([
        'enableAjaxValidation' => false,
        'enableClientValidation' => false,
        'validateOnChange' => false,
    ]); ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 10, 'cols' => 3]) ?>
    <?= $this->registerJs('
    jQuery(function($) {
        CKEDITOR.replace("'.Html::getInputId($model, 'text').'", {
            format_tags: "p;h1;h2;h3;pre",
            toolbar : [
                        ["Undo","Redo","-","Cut","Copy","Paste","PasteFromWord","Find","Replace", "-", "Format", "RemoveFormat", "-", "Bold", "Underline", "Italic", "-", "NumberedList","BulletedList", "-", "Source"]
                      ]
        });
    })', \yii\web\View::POS_END);?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
