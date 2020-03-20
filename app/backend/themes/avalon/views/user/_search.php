<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use \yii\bootstrap\ButtonDropdown;

/* @var $this yii\web\View */
/* @var $model backend\models\UserSearch */
/* @var $form kartik\widgets\ActiveForm */
?>

<div class="panel panel-default rmcms search-filter">
    <div class="panel-body">

        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
        ]); ?>

        <div class="row">
            <?=Html::hiddenInput('per-page', Yii::$app->request->get('per-page', 20))?>

            <?= $form->field($model, 'username_email', ['options' => ['class' => 'form-group col-md-2']]) ?>

            <div class="form-group col-md-2">
                <label for="" class="control-label">Проект</label>
                <select name="" id="" class="form-control">
                    <option value="">RealtyMax</option>
                </select>
            </div>

            <?=$form->field($model, 'status', ['options' => ['class' => 'form-group col-md-2']])->widget(\kartik\select2\Select2::className(), [
                'options' => ['placeholder' => 'Выбрать...'],
                'data' => \common\models\user\dictionary\StatusDictionary::getTypes(true, null, [\common\models\user\dictionary\StatusDictionary::ACTIVE, \common\models\user\dictionary\StatusDictionary::BLOCKED]),
                'pluginOptions' => [
                    'allowClear' => true,
                ]
            ]);?>

            <div class="form-group col-md-2">
                <label class="control-label">Дата создания</label>
                    <?=DatePicker::widget([
                        'model' => $model,
                        'separator' => 'до',
                        'attribute' => 'created_at_from',
                        'type' => DatePicker::TYPE_RANGE,
                        'attribute2' => 'created_at_to',
                        'pluginOptions' => [
                            'autoclose'=>false,
                            'format' => 'dd.mm.yyyy'
                        ]
                ]);?>
            </div>
        <div class="form-group col-md-2 text-left">
            <?= Html::submitButton('Искать', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Сброс', ['class' => 'btn btn-default']) ?>
        </div>
        <div class="col-md-2 text-right">
            <?=ButtonDropdown::widget([
                'label' => 'Действия',
                'options' => ['class' => 'btn btn-success dropdown-toggle'],
                'dropdown' => [
                    'items' => [
                        ['label' => 'Добавить пользователя', 'url' => ['create']],
                        ['label' => 'Добавить роль', 'url' => ['createRole']],
                    ],
                ],
            ]);
            ?>
        </div>
        <?php ActiveForm::end(); ?>


    </div>


    </div>
</div>
