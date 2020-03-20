<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use common\models\log\dictionary\LogObjectDictionary;
use yii\helpers\Url;
use common\models\log\dictionary\LogActionDictionary;
use common\models\log\helpers\LogHelper;
use yii\web\JsExpression;
use common\models\user\User;
/* @var $this yii\web\View */
/* @var $model backend\models\UserSearch */
/* @var $form kartik\widgets\ActiveForm */
?>

<div class="panel panel-default rmcms search-filter">
    <div class="panel-body">

        <?php $form = ActiveForm::begin([
            'action' => ['report'],
            'method' => 'get',
        ]); ?>

        <div class="row">
            <?=Html::hiddenInput('per-page', Yii::$app->request->get('per-page', 20))?>

            <div class="form-group col-md-3">
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

            <?=$form->field($model, 'owner_id', ['options' => ['class' => 'form-group col-md-2']])->widget(Select2::className(), [
                'options' => ['placeholder' => 'Выбрать...'],
                'data' => ArrayHelper::map(User::find()->where(['status' => [\common\models\user\dictionary\StatusDictionary::ACTIVE, \common\models\user\dictionary\StatusDictionary::BLOCKED]])->all(), 'id', function($item) {return ($item->status == \common\models\user\dictionary\StatusDictionary::BLOCKED) ? $item->name." (заблокирован)" : $item->name;}),
                'pluginOptions' => [
                    'allowClear' => true,
                ]
            ]);?>

            <div class="form-group col-md-2">
                <?= Html::submitButton('Искать', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>


    </div>
</div>
