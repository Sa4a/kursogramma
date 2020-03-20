<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;
use yii\grid\ActionColumn;
use yii\helpers\Url;
use common\models\user\notification\dictionary\UserNotificationTypeDictionary;
use common\models\user\notification\dictionary\UserNotificationStatusDictionary;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserNotificationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Мои уведомления';
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="panel rmcms panel-primary">
        <div class="panel-heading">
            <h2><?=$this->title?></h2>
            <div class="panel-ctrls">
                <div class="btn-group">
                    <a href="<?=Url::toRoute(['user/notifications-read'])?>" class="btn btn-sm btn-success btn-label"><i class="fa fa-check"></i>Пометить все как прочитанные</a>
                </div>
            </div>
        </div>
        <div class="panel-body panel-no-padding">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'layout' => "{items}\n{summary}\n{pager}",
                'tableOptions' => ['class' => 'table table-striped users-list-table'],
                'columns' => [
                    ['class' => CheckboxColumn::className()],
                    'id',
                    [
                        'attribute' => 'status',
                        'format' => 'html',
                        'value' => function ($model, $index, $widget) {
                            return UserNotificationStatusDictionary::getString($model->status);
                        },
                        'filterInputOptions' => ['class'=>'form-control', /*'class'=>'select-multiple'*/],
                        'filter' => UserNotificationStatusDictionary::getTypes(true)
                    ],
                    [
                        'attribute' => 'type',
                        'format' => 'html',
                        'value' => function ($model, $index, $widget) {
                            return UserNotificationTypeDictionary::getString($model->type);
                        },
                        //'filterInputOptions' => ['class'=>'form-control', /*'class'=>'select-multiple'*/],
                        'filter' =>false
                    ],
                    'body',
                    [
                        'attribute' => 'created_at',
                        'format' => ['date', 'php:d.m.Y H:i:s']
                    ],
                    [
                        'class' => ActionColumn::className(),
                        'headerOptions' => ['width' => '75px;'],
                        'template' => '{read}',
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                $url = Url::toRoute(['user/viewNotification', 'id' => $model->id]);
                                return Html::a('<i class="fa fa-eye fa-fw"></i> Посмотреть', $url);
                            },
                            'read' => function ($url, $model, $key) {
                                $url = Url::toRoute(['user/notifications-read', 'id' => $model->id]);
                                if ($model->status == UserNotificationStatusDictionary::READ) {
                                    return "";
                                }
                                return Html::a('<i class="fa fa-check fa-fw"></i> Прочитано', $url, ['class' => 'btn btn-sm btn-success']);
                            },
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>

