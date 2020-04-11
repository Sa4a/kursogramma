<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Module */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="module-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea() ?>

    <?= Html::img($model->getUploadUrl('image'), ['class' => 'img-thumbnail','width'=>100]) ?>
    <?= $form->field($model, 'image')->fileInput() ?>

    <?= $form->field($model, 'course_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\Course::find()->all(),'id','name')) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
