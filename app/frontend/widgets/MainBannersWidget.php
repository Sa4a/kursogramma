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

class MainBannersWidget extends Widget
{
    const MODULE_NAME  = 'main_banners';

    public function run()
    {
        $module = Yii::$app->domain->getModuleByCode(self::MODULE_NAME);

        return $this->render('main_banners', ['params'=>$module['_parameter']]);
    }


}