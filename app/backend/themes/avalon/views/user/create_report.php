<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\user\report\form\ReportForm */

$this->title = 'Создание отчета';
$this->params['breadcrumbs'][] = ['label' => 'Отчеты'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_report_form', [
        'model' => $model,
    ]) ?>

</div>
