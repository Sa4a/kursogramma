<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;
use yii\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список пользователей';
$this->params['breadcrumbs'][] = $this->title;
?>

    <?=$this->render('_search', ['model' => $searchModel]); ?>

    <div class="panel rmcms panel-primary">
        <div class="panel-heading"></div>
        <div class="panel-body panel-no-padding">
            <?= \backend\widgets\CmsGridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-striped users-list-table'],
                'rowOptions' => function ($model, $index, $widget, $grid){
                    return ($model->status == \common\models\user\dictionary\StatusDictionary::BLOCKED) ? ['style'=>'background-color:lightcoral;'] : [];
                },
                'columns' => [
                    ['class' => CheckboxColumn::className()],

                    'name',
                    'username',
                    'email:email',
                    [
                        'attribute' => 'department_id',
                        'header' => 'Отдел',
                        'format' => 'html',
                        'value' => function ($model, $index, $widget) {
                            return ($department = $model->getDepartment()) ? $department->name : '-';
                        },
//                        'filterInputOptions' => ['class'=>'form-control'],
//                        'filter' => []
                    ],
                    [
                        'attribute' => 'roles',
                        'header' => 'Роли',
                        'format' => 'html',
                        'value' => function ($model, $index, $widget) {
                            return implode(', ', $model->getRoles());
                        },
//                        'filterInputOptions' => ['class'=>'form-control'],
//                        'filter' => []
                    ],

                    [
                        'attribute' => 'responsible_objects_count',
                        'header' => 'Объектов под ответственностью',
                        'format' => 'html',
                        'value' => function ($model, $index, $widget) {
                            return $model->responsibleObjectsCount;
                        },
//                        'filterInputOptions' => ['class'=>'form-control'],
//                        'filter' => []
                    ],

                    [
                        'attribute' => 'created_at',
                        'format' => ['date', 'php:d.m.Y']
                    ],

                    [
                        'class' => ActionColumn::className(),
                        'headerOptions' => ['width' => '75px;'],
                        'template' => '<div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                                <i class="fa fa-bars fa-fw"></i> <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>{view}</li>
                                                <li>{update}</li>
                                                <li>{toggle-block}</li>
                                                {delete}
                                            </ul>
                                        </div> ',
                        'buttons' => [
                            'update' => function ($url, $model, $key) {
                                return Html::a('<i class="fa fa-pencil fa-fw"></i> Редактировать', $url);
                            },
                            'delete' => function ($url, $model, $key) {
                                return $model->username != 'admin' ? " <li class='divider'></li><li>".Html::a('<i class="fa fa-trash fa-fw"></i> Удалить', $url, [
                                    'title' => Yii::t('yii', 'Delete'),
                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    'data-method' => 'post',
                                    'data-pjax' => '0',
                                ])."</li>" : "";
                            },
                            'view' => function ($url, $model, $key) {
                                return Html::a('<i class="fa fa-eye fa-fw"></i> Посмотреть', $url);
                            },
                            'toggle-block' => function ($url, $model, $key) {
                                $url = \yii\helpers\Url::to(['toggle-blocked', 'id' => $model->id]);
                                if ($model->status == \common\models\user\dictionary\StatusDictionary::ACTIVE) {
                                    return Html::a('<i class="fa fa-ban fa-fw"></i> Заблокировать', $url);
                                } else {
                                    return Html::a('<i class="fa fa-smile-o fa-fw"></i> Разблокировать', $url);
                                }

                            },
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>

