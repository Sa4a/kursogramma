<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\UserForm */

$this->title = 'Редактирование отчета от '.\Yii::$app->formatter->asDatetime($model->created_at->toDateTime()->getTimestamp());
$this->params['breadcrumbs'][] = ['label' => 'Отчеты', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="кузщке-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_report_form', [
        'model' => $model,
    ]) ?>

</div>
