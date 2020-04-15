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

class BestSellersWidget extends Widget
{
    const MODULE_NAME  = 'best_seller';
    protected $catalogRep;

    public function __construct(array $config = [], CatalogRepository $catalogRep)
    {
        $this->catalogRep = $catalogRep;
        parent::__construct($config);
    }

    public function run()
    {
        $module = Yii::$app->domain->getModuleByCode(self::MODULE_NAME);

        $name = $module['_parameter']['name']['relation_value'];
        $product_ids = $module['_parameter']['products']['relation_value'];
        $products = $this->catalogRep->getProducts(explode('|',$product_ids));

        return $this->render('best_seller', ['name'=>$name, 'products' => $products]);
    }


}