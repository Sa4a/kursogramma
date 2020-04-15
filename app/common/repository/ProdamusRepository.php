<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 09.04.2020
 * Time: 14:29
 */

namespace common\repository;

use Yii;

class ProdamusRepository
{

    protected $domain_page = 'domain_page';
    protected $domain_page_param_rel = 'domain_page_param_rel';
    protected $domain_page_param = 'domain_page_param';
    protected $domain_page_param_type = 'domain_page_param_type';
    protected $domain_page_module_type = 'domain_page_module_type';
    protected $domain_page_module_param = 'domain_page_module_param';
    protected $domain_page_module_param_type = 'domain_page_module_param_type';
    protected $domain_page_module_param_rel = 'domain_page_module_param_rel';
    protected $domain_page_module = 'domain_page_module';
    protected $domain_page_product = 'domain_page_product';
    protected $domain_page_type = 'domain_page_type';
    protected $domains = 'domains';
    protected $products = 'products';
    protected $provider = 'provider';
    protected $product_balance = 'product_balance';
    protected $products_parameters = 'products_parameters';
    protected $product_preset = 'product_preset';
    protected $products_catalog_relations = 'products_catalog_relations';
    protected $products_catalog = 'products_catalog';
    protected $product_class = 'product_class';
    protected $products_properties_relations = 'products_properties_relations';
    protected $products_properties = 'products_properties';
    protected $products_properties_catalog_relations = 'products_properties_catalog_relations';
    protected $products_properties_catalog = 'products_properties_catalog';
    protected $products_properties_values = 'products_properties_values';
    protected $products_parameters_types = 'products_parameters_types';
    protected $stat_product_profit = 'stat_product_profit';
    protected $stat_order_product = 'stat_order_product';
    protected $rating_product_summary = 'rating_product_summary';

    const WIDGET_MODULE_TYPE_ID  = 2;

    protected $order_params = array(
        'site_id'       => 0,
        'system_site_id'=> 0,
        'order_type'    => '',
        'sale_region'   => '',
    );

}