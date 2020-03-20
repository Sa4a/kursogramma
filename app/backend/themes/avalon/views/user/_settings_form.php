<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\user\dictionary\AuthRoleDictionary;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\UserForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => 255, 'disabled' => !$model->isNewRecord]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'password')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'password_confirm')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'timezone')->widget(Select2::className(), [
        'options' => ['class' => 'required'],
        'data' => \common\helpers\TimeHelper::timezoneList()
    ]);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
