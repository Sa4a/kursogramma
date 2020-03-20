<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Список пользователей', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-profile panel-midnightblue">
    <div class="panel-body">

        <div class="rmcms personal-user-data">
            <div class="col-md-6">
                <img src="/uploads/demo/avatar/avatar_06.png" alt="" class="avatar pull-left" style="margin: 0 20px 20px 0">
                <div class="table-responsive table-userinfo">
                    <h3 class="mt0"><?=$model->name?> <?=Html::a('<i class="fa fa-pencil"></i>', ['user/update', 'id' => $model->id], ['class' => 'btn btn-info btn-xs']);?></h3>
                    <table class="table table-condensed">
                        <tbody>
                        <tr>
                            <td>Email</td>
                            <td><a href=""><?=$model->email?></a></td>
                        </tr>
                        <tr>
                            <td>Роль</td>
                            <td><?=implode(', ', $model->getRoles())?></td>
                        </tr>
                        <tr>
                            <td>Часовой пояс</td>
                            <td><?=\common\helpers\TimeHelper::timezoneList()[$model->timezone]?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <hr class="outsider">
        <div class="row">
            <div class="col-md-12">
                <div class="tab-container tab-default mb0">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#home1" data-toggle="tab">Лента событий</a></li>
                        <li class=""><a href="#profile1" data-toggle="tab">Ваши проекты</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="home1">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="timeline-month"><span class="month">July</span> <span class="year">2014</span></h3>
                                    <ul class="timeline mb0">
                                        <li class="timeline-orange">
                                            <div class="timeline-icon"><i class="fa fa-camera"></i></div>
                                            <div class="timeline-body">
                                                <div class="timeline-header">
                                                    <span class="author">Posted by <a href="#">David Tennant</a></span>
                                                    <span class="date">Monday, November 11, 2014</span>
                                                </div>
                                                <div class="timeline-content">
                                                    <h3>Lorem Ipsum Dolor Sit Amet</h3>
                                                    <p><img src="/uploads/demo/stockphoto/blog_06.jpg" alt="" class="pull-left img-responsive" width="200px">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia, officiis, molestiae, deserunt asperiores architecto ut vel repudiandae dolore inventore nesciunt necessitatibus doloribus ratione facere consectetur suscipit! Quasi, officia, veniam mollitia recusandae iure aperiam totam culpa aut nobis eveniet porro laborum quisquam non.</p>
                                                </div>
                                                <div class="timeline-footer">
                                                    <a href="#" class="btn btn-default btn-sm pull-left">Read Full Story</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="timeline-warning">
                                            <div class="timeline-icon"><i class="fa fa-pencil"></i></div>
                                            <div class="timeline-body">
                                                <div class="timeline-header">
                                                    <span class="author">Posted by <a href="#">David Tennant</a></span>
                                                    <span class="date">Monday, November 21, 2014</span>
                                                </div>
                                                <div class="timeline-content">
                                                    <h3>Consectetur Adipisicing Elit</h3>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia, officiis, molestiae, deserunt asperiores architecto ut vel repudiandae dolore inventore nesciunt necessitatibus doloribus ratione facere consectetur suscipit!</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="timeline-warning">
                                            <div class="timeline-icon"><i class="fa fa-pencil"></i></div>
                                            <div class="timeline-body">
                                                <div class="timeline-header">
                                                    <span class="author">Posted by <a href="#">David Tennant</a></span>
                                                    <span class="date">Monday, November 21, 2014</span>
                                                </div>
                                                <div class="timeline-content">
                                                    <h3>Consectetur Adipisicing Elit</h3>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia, officiis, molestiae, deserunt asperiores architecto ut vel repudiandae dolore inventore nesciunt necessitatibus doloribus ratione facere consectetur suscipit!</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="timeline-warning">
                                            <div class="timeline-icon"><i class="fa fa-pencil"></i></div>
                                            <div class="timeline-body">
                                                <div class="timeline-header">
                                                    <span class="author">Posted by <a href="#">David Tennant</a></span>
                                                    <span class="date">Monday, November 21, 2014</span>
                                                </div>
                                                <div class="timeline-content">
                                                    <h3>Consectetur Adipisicing Elit</h3>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia, officiis, molestiae, deserunt asperiores architecto ut vel repudiandae dolore inventore nesciunt necessitatibus doloribus ratione facere consectetur suscipit!</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="profile1">
                            <div class="table-responsive">
                                <table class="table table-striped mb0">
                                    <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="35%">Project Title</th>
                                        <th width="35%">Due Date</th>
                                        <th width="25%">Progress</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Lorem ipsum</td>
                                        <td>Nov 5, 2013</td>
                                        <td>
                                            <div class="progress progress-striped" style="margin:5px 0 0">
                                                <div class="progress-bar progress-bar-info" style="width: 30%;"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Dignissimos voluptas</td>
                                        <td>Nov 10, 2013</td>
                                        <td>
                                            <div class="progress progress-striped" style="margin:5px 0 0">
                                                <div class="progress-bar progress-bar-danger" style="width: 55%;"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Tenetur ex ea dignissimos</td>
                                        <td>Nov 11, 2013</td>
                                        <td>
                                            <div class="progress progress-striped" style="margin:5px 0 0">
                                                <div class="progress-bar progress-bar-success" style="width: 35%;"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Quo dolorem maxime</td>
                                        <td>Nov 21, 2013</td>
                                        <td>
                                            <div class="progress progress-striped" style="margin:5px 0 0">
                                                <div class="progress-bar progress-bar-primary" style="width: 20%;"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Dsperiores</td>
                                        <td>Nov 17, 2013</td>
                                        <td>
                                            <div class="progress progress-striped" style="margin:5px 0 0">
                                                <div class="progress-bar progress-bar-inverse" style="width: 70%;"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
