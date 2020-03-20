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

    <?= $form->field($model, 'department_id')->dropDownList(\common\helpers\ArrayHelper::map(\common\models\user\department\UserDepartment::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'roles')->dropDownList(AuthRoleDictionary::getTypes(true), ['multiple' => true]) ?>

    <?= $form->field($model, 'is_active_contenter')->checkbox() ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'timezone')->widget(Select2::className(), [
        'options' => ['class' => 'required'],
        'data' => \common\helpers\TimeHelper::timezoneList()
    ]);?>

    <?php
        $regions = [];

        //Добавляем Москву и Санкт-Петербург
        $regions[\common\models\address_element\dictionary\AddressElementRelationDictionary::MOSCOW] = \common\models\address_element\dictionary\AddressElementRelationDictionary::getString(\common\models\address_element\dictionary\AddressElementRelationDictionary::MOSCOW);
        $regions[\common\models\address_element\dictionary\AddressElementRelationDictionary::SANKT_PETERSBURG] = \common\models\address_element\dictionary\AddressElementRelationDictionary::getString(\common\models\address_element\dictionary\AddressElementRelationDictionary::SANKT_PETERSBURG);
    ?>
    <?= $form->field($model, 'region')->widget(Select2::className(), [
        'data' => $regions
    ]);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
