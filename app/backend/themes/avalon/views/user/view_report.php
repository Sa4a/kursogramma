<?php

use backend\assets\AvalonTheme\Plugin_PrettyDiffAsset;
use common\models\log\dictionary\LogActionDictionary;
use common\models\log\helpers\LogHelper;

$this->title = 'Отчет сотрудника '.$model->getOwner()->name.' от '.\Yii::$app->formatter->asDatetime($model->created_at->toDateTime()->getTimestamp());
$this->params['breadcrumbs'][] = ['label' => 'Отчеты', 'url' => ['user/report']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="panel panel-default rmcms">
    <div class="panel-heading">
        <h2><?=$this->title?></h2>
    </div>
    <div class="panel-body">
        <?php
            echo \yii\widgets\DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'owner_id',
                        'value' => $model->getOwner()->name
                    ],
                    'text:html',
                    [
                        'attribute' => 'created_at',
                        'value' => (isset($model->created_at)) ? \Yii::$app->formatter->asDatetime($model->created_at->toDateTime()->getTimestamp()) : "-"
                    ], // creation date formatted as datetime
                ],
            ]);
        ?>
    </div>
</div>