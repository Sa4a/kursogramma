<?php
/**
 * Created by PhpStorm.
 * User: extead
 * Date: 18.12.14
 * Time: 19:16
 */

use backend\widgets\Nav;
?>

<div class="static-sidebar">
    <div class="sidebar">

        <div class="widget stay-on-collapse">
            <div class="widget-body welcome-box tabular">
                <div class="tabular-row">
                    <div class="tabular-cell welcome-avatar">
                        <a href="#"><?php echo \yii\helpers\Html::img('@web/uploads/demo/avatar/avatar_06.png', ['class' => 'avatar']) ?></a>
                    </div>
                    <div class="tabular-cell welcome-options">
                        <span class="welcome-text">Добро пожаловать,</span>
                        <a href="#" class="name">Пользователь -  <?=Yii::$app->user->identity->id;?></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="widget stay-on-collapse" id="widget-sidebar">
            <span class="widget-heading">Личный кабинет</span>
                <?php echo Nav::widget([
                    'options' => ['class' =>'acc-menu'],
                     'items' => [
                         [
                             'label' => 'Главная',
                             'icon' => 'fa fa-tachometer',
                             'url' => ['site/index'],
                         ],
                         [
                             'label' => 'Курсы',
                             'icon' => 'fa fa-tachometer',
                             'url' => ['/course'],
                         ],
                         [
                             'label' => 'Модули',
                             'icon' => 'fa fa-tachometer',
                             'url' => ['/module'],
                         ],
                         [
                             'label' => 'Уроки',
                             'icon' => 'fa fa-tachometer',
                             'url' => ['/lesson'],
                         ],
                         [
                             'label' => 'Пользователи',
                             'icon' => 'fa fa-tachometer',
                             'url' => ['/users'],
                         ],
                         /*[
                             'label' => 'Словари',
                             'icon' => 'fa fa-book',
                             'items' => [
                                 [
                                     'label' => 'Ветки метро',
                                     'url' => ['dictionary/metro-line-index']
                                 ],

                             ]
                         ],*/


                     ],
                 ]);?>
        </div>

    </div>
</div>

