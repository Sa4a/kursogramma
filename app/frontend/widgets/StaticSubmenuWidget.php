<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 23.03.2020
 * Time: 10:04
 */

namespace frontend\widgets;

use common\repository\CatalogRepository;
use Yii;
use yii\base\Widget;

class StaticSubmenuWidget extends Widget
{
    public $string_menu = '';

    public function run()
    {

        $menuElements = explode(PHP_EOL, $this->string_menu);

        foreach ($menuElements as $menuElement) {
            $menuElement = explode('§|§', $menuElement);
            $menuItems[] = ['label' => $menuElement[1], 'url' =>$menuElement[0] ];
        }

        return $this->render('static_submenu', ['menuItems' => $menuItems]);
    }


}