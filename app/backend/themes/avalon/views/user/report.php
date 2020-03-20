<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\models\user\report\search\ReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;
use yii\grid\ActionColumn;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\user\User;

$this->title = 'Отчеты';
$this->params['breadcrumbs'][] = $this->title;
?>
    <?=$this->render('_report_search', ['model' => $searchModel]); ?>
    <div class="panel rmcms panel-primary">
        <div class="panel-heading">
            <h2>Отчеты</h2>
            <div class="panel-ctrls">
                <div class="btn-group">
                    <a href="<?=Url::to(['user/add-report'])?>" class="btn btn-sm btn-success btn-label"><i class="fa fa-plus"></i>Новый отчет</a>
                </div>
            </div>
        </div>
        <div class="panel-body panel-no-padding">
            <?= \backend\widgets\CmsGridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'filterSelector' => 'select[name="per-page"]',
                'layout' => "{summary}\n{items}\n{pager}",
                'tableOptions' => ['class' => 'table table-striped users-list-table'],
                'columns' => [
                    ['class' => CheckboxColumn::className()],
                    [
                        'attribute' => 'owner_id',
                        'format' => 'html',
                        'value' => function ($model, $index, $widget) {
                            return ($owner = $model->getOwner()) ? $owner->name : null;
                        }
                    ],

                    [
                        'attribute' => 'created_at',
                        'value' => function ($model, $index, $widget) {
                            return (isset($model->created_at)) ? \Yii::$app->formatter->asDatetime($model->created_at->toDateTime()->getTimestamp()) : "-";
                        },
                    ],

                    [
                        'class' => ActionColumn::className(),
                        'headerOptions' => ['width' => '75px;'],
                        'template' => '<div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                                <i class="fa fa-bars fa-fw"></i> <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>{update}</li>
                                                <li>{view}</li>
                                            </ul>
                                        </div> ',
                        'buttons' => [
                            'update' => function ($url, $model, $key) {
                                if(Yii::$app->user->id == $model->owner_id) {
                                    return Html::a('<i class="fa fa-pencil fa-fw"></i> Редактировать', Url::toRoute(['update-report', 'id' => $model->_id]));
                                } else {
                                    return '';
                                }
                            },
                            'view' => function ($url, $model, $key) {
                                return Html::a('<i class="fa fa-eye fa-fw"></i> Посмотреть', Url::toRoute(['view-report', 'id' => $model->_id]));
                            },
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>

