<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use backend\assets\AppAsset;
use backend\widgets\Alert;
use backend\widgets\Notification;
use backend\widgets\RecentActivity;
/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);

\backend\assets\AvalonTheme\Plugin_WijetsAsset::register($this);
$this->registerJs('$.wijets().make();', \yii\web\View::POS_END);

\backend\assets\AvalonTheme\Plugin_BootboxAsset::register($this);
\backend\assets\AvalonTheme\Plugin_AjaxProgressAsset::register($this);
\backend\assets\AvalonTheme\Plugin_SkyLoaderAsset::register($this);
\backend\assets\AvalonTheme\Plugin_LightboxAsset::register($this);

$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no']);
$this->registerMetaTag(['name' => 'apple-mobile-web-app-capable', 'content' => 'yes']);
$this->registerMetaTag(['name' => 'apple-touch-fullscreen', 'content' => 'yes']);
$this->registerMetaTag(['name' => 'description', 'content' => 'Avalon Admin Theme']);
$this->registerMetaTag(['name' => 'author', 'content' => 'The Red Team']);
$this->registerMetaTag(['http-equiv' => 'X-UA-Compatible', 'content' => 'IE=edge,chrome=1']);?>

<?php $this->beginPage() ?>

    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <?php if(Yii::$app->has('faye')): ?>
            <script type = "text/javascript" src = "<?=Yii::$app->faye->fayeServerUrl?>/client.js" ></script >
            <script type = "text/javascript" >
                var sub_client = new Faye.Client('<?=Yii::$app->faye->fayeServerUrl?>');
            </script >
        <?php endif;?>
        <?= Html::csrfMetaTags() ?>
    </head>

    <body class="infobar-offcanvas">
    <?php $this->beginBody() ?>
    <div id="headerbar">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-6 col-sm-2">
                    <a href="#" class="shortcut-tiles tiles-brown">
                        <div class="tiles-body">
                            <div class="pull-left"><i class="fa fa-pencil"></i></div>
                        </div>
                        <div class="tiles-footer">
                            Create Post
                        </div>
                    </a>
                </div>
                <div class="col-xs-6 col-sm-2">
                    <a href="#" class="shortcut-tiles tiles-grape">
                        <div class="tiles-body">
                            <div class="pull-left"><i class="fa fa-group"></i></div>
                            <div class="pull-right"><span class="badge">2</span></div>
                        </div>
                        <div class="tiles-footer">
                            Contacts
                        </div>
                    </a>
                </div>
                <div class="col-xs-6 col-sm-2">
                    <a href="#" class="shortcut-tiles tiles-primary">
                        <div class="tiles-body">
                            <div class="pull-left"><i class="fa fa-envelope-o"></i></div>
                            <div class="pull-right"><span class="badge">10</span></div>
                        </div>
                        <div class="tiles-footer">
                            Messages
                        </div>
                    </a>
                </div>
                <div class="col-xs-6 col-sm-2">
                    <a href="#" class="shortcut-tiles tiles-inverse">
                        <div class="tiles-body">
                            <div class="pull-left"><i class="fa fa-camera"></i></div>
                            <div class="pull-right"><span class="badge">3</span></div>
                        </div>
                        <div class="tiles-footer">
                            Gallery
                        </div>
                    </a>
                </div>

                <div class="col-xs-6 col-sm-2">
                    <a href="#" class="shortcut-tiles tiles-midnightblue">
                        <div class="tiles-body">
                            <div class="pull-left"><i class="fa fa-cog"></i></div>
                        </div>
                        <div class="tiles-footer">
                            Settings
                        </div>
                    </a>
                </div>
                <div class="col-xs-6 col-sm-2">
                    <a href="#" class="shortcut-tiles tiles-orange">
                        <div class="tiles-body">
                            <div class="pull-left"><i class="fa fa-wrench"></i></div>
                        </div>
                        <div class="tiles-footer">
                            Plugins
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <header id="topnav" class="navbar navbar-default clearfix" role="banner">


        <a id="leftmenu-trigger" class="" data-toggle="tooltip" data-placement="right" title="Toggle Sidebar"></a>
        <a class="navbar-brand" href="index.html">Avalon</a>
        <a id="rightmenu-trigger" class="" data-toggle="tooltip" data-placement="left" title="Toggle Infobar"></a>


        <div class="yamm navbar-left navbar-collapse collapse in">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Mega Menu<span class="caret"></span></a>
                    <ul class="dropdown-menu" style="width: 900px;">
                        <li>
                            <div class="yamm-content container-sm-height">
                                <div class="row row-sm-height yamm-col-bordered">
                                    <div class="col-sm-3 col-sm-height yamm-col">

                                        <h3 class="yamm-category">Sidebar</h3>
                                        <ul class="list-unstyled mb20">
                                            <li><a href="layout-fixed-sidebars.html">Stretch Sidebars</a></li>
                                            <li><a href="layout-sidebar-scroll.html">Scroll Sidebar</a></li>
                                            <li><a href="layout-static-leftbar.html">Static Sidebar</a></li>
                                            <li><a href="layout-leftbar-widgets.html">Sidebar Widgets</a></li>
                                        </ul>

                                        <h3 class="yamm-category">Infobar</h3>
                                        <ul class="list-unstyled">
                                            <li><a href="layout-infobar-offcanvas.html">Offcanvas Infobar</a></li>
                                            <li><a href="layout-infobar-overlay.html">Overlay Infobar</a></li>
                                            <li><a href="layout-chatbar-overlay.html">Chatbar</a></li>
                                            <li><a href="layout-rightbar-widgets.html">Infobar Widgets</a></li>
                                        </ul>

                                    </div>
                                    <div class="col-sm-3 col-sm-height yamm-col">

                                        <h3 class="yamm-category">Page Content</h3>
                                        <ul class="list-unstyled mb20">
                                            <li><a href="layout-breadcrumb-top.html">Breadcrumbs on Top</a></li>
                                            <li><a href="layout-page-tabs.html">Page Tabs</a></li>
                                            <li><a href="layout-fullheight-panel.html">Full-Height Panel</a></li>
                                            <li><a href="layout-fullheight-content.html">Full-Height Content</a></li>
                                        </ul>

                                        <h3 class="yamm-category">Misc</h3>
                                        <ul class="list-unstyled">
                                            <li><a href="layout-topnav-options.html">Topnav Options</a></li>
                                            <li><a href="layout-horizontal-small.html">Horizontal Small</a></li>
                                            <li><a href="layout-horizontal-large.html">Horizontal Large</a></li>
                                            <li><a href="layout-boxed.html">Boxed</a></li>
                                        </ul>

                                    </div>
                                    <div class="col-sm-3 col-sm-height yamm-col">

                                        <h3 class="yamm-category">Analytics</h3>
                                        <ul class="list-unstyled mb20">
                                            <li><a href="charts-flot.html">Flot</a></li>
                                            <li><a href="charts-sparklines.html">Sparklines</a></li>
                                            <li><a href="charts-morris.html">Morris</a></li>
                                            <li><a href="charts-easypiechart.html">Easy Pie Charts</a></li>
                                        </ul>

                                        <h3 class="yamm-category">Components</h3>
                                        <ul class="list-unstyled">
                                            <li><a href="ui-tiles.html">Tiles</a></li>
                                            <li><a href="custom-knob.html">jQuery Knob</a></li>
                                            <li><a href="custom-jqueryui.html">jQuery Slider</a></li>
                                            <li><a href="custom-ionrange.html">Ion Range Slider</a></li>
                                        </ul>

                                    </div>
                                    <div class="col-sm-3 col-sm-height yamm-col">
                                        <h3 class="yamm-category">Rem</h3>
                                        <img src="/uploads/demo/stockphoto/communication_12_carousel.jpg" class="mb20 img-responsive" style="width: 100%;">
                                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium. totam rem aperiam eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="dropdown" id="widget-classicmenu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                        <li class="divider"></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li>
                <li><a href="frontend/index.html" target="_blank"><strong>Frontend</strong></a></li>
                <li><a href="landing/index.html" target="_blank"><strong>Landing Page</strong></a></li>
            </ul>
        </div>

        <ul class="nav navbar-nav toolbar pull-right">
            <li class="dropdown">
                <a href="#" id="navbar-links-toggle" data-toggle="collapse" data-target="header>.navbar-collapse">&nbsp;</a>
            </li>

            <li class="toolbar-icon-bg demo-headerdrop-hidden">
                <a href="#" id="headerbardropdown"><span class="icon-bg"><i class="fa fa-fw fa-level-down"></i></span></i></a>
            </li>



            <li class="dropdown toolbar-icon-bg demo-search-hidden mr5">
                <a href="#" class="dropdown-toggle tooltips" data-toggle="dropdown"><span class="icon-bg"><i class="fa fa-fw fa-search"></i></span></a>

                <div class="dropdown-menu arrow search dropdown-menu-form">
                    <div class="dd-header">
                        <span>Search</span>
                        <span><a href="#">Advanced search</a></span>
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="">

					<span class="input-group-btn">

						<a class="btn btn-primary" href="#">Search</a>
					</span>
                    </div>
                </div>
            </li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle username" data-toggle="dropdown">
                    <span class="hidden-xs">Имя<? //=Yii::$app->user->identity->name;?></span>
                    <?php echo \yii\helpers\Html::img('@web/uploads/demo/avatar/avatar_06.png', ['class' => 'img-circle']) ?>
                </a>
                <ul class="dropdown-menu userinfo">
                    <li><a href="<?=Url::toRoute('user/settings')?>"><span class="pull-left">Настройки профиля</span> <i class="pull-right fa fa-cogs"></i></a></li>
                    <li class="divider"></li>
                    <li><a href="<?=Url::toRoute('site/logout')?>"><span class="pull-left">Выйти</span> <i class="pull-right fa fa-sign-out"></i></a></li>
                </ul>
            </li>

        </ul>

    </header>

    <div id="wrapper">
        <div id="layout-static">
            <div class="static-sidebar-wrapper sidebar-inverse">
                <?=$this->render("_left_sidebar");?>
            </div>
            <div class="static-content-wrapper">
                <div class="static-content">
                    <div class="page-content">
                        <div class="page-heading">
                            <h1><?= Html::encode($this->title) ?></h1>
                        </div>
                        <?= Breadcrumbs::widget([
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        ]) ?>
                        <?= Alert::widget() ?>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <?= $content ?>
                                </div>
                            </div>
                        </div>
                    </div> <!-- #page-content -->
                </div>
                <footer role="contentinfo">
                    <div class="clearfix">
                        <ul class="list-unstyled list-inline pull-left">
                            <li><h6 style="margin: 0;"> &copy; 2014 Avalon</h6></li>
                        </ul>
                        <button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i class="fa fa-arrow-up"></i></button>
                    </div>
                </footer>
            </div>
        </div>
    </div>


    <div class="infobar-wrapper">
        <div class="infobar">

            <div class="infobar-options">
                <h2>Infobar</h2>
            </div>

            <div id="widgetarea">


                <div class="widget" id="widget-sparkline">
                    <div class="widget-heading">
                        <a href="javascript:;" data-toggle="collapse" data-target="#sparklinestats"><h4>Sparkline Stats</h4></a>
                    </div>
                    <div class="widget-body collapse in" id="sparklinestats">
                        <ul class="sparklinestats">
                            <li>
                                <div class="pull-left">
                                    <h5 class="title">Total Revenue</h5>
                                    <h3>$241,750 <span class="badge badge-success">+13.6%</span></h3>
                                </div>
                                <div class="pull-right">
                                    <div class="sparkline" id="infobar-revenuestats"></div>
                                </div>
                            </li>
                            <li>
                                <div class="pull-left">
                                    <h5 class="title">Products Sold</h5>
                                    <h3>11,562 <span class="badge badge-success">+19.2%</span></h3>
                                </div>
                                <div class="pull-right">
                                    <div class="sparkline" id="infobar-unitssold"></div>
                                </div>
                            </li>
                            <li>
                                <div class="pull-left">
                                    <h5 class="title">Total Orders</h5>
                                    <h3>1,249 <span class="badge badge-danger">-10.5%</span></h3>
                                </div>
                                <div class="pull-right">
                                    <div class="sparkline" id="infobar-orders"></div>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>     
            </div>
        </div>
    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>