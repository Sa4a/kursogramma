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

class CatalogStructureWidget extends Widget
{
    public $domain_id;
    public $url = '/goods/';
    public $depth = '2';
    public $sort_by_name = false;
    public $skip_empty_catalogs = true;


    protected $catalogRep;

    public function __construct(array $config = [], CatalogRepository $catalogRep)
    {
        $this->catalogRep = $catalogRep;
        parent::__construct($config);
    }

    public function run()
    {
        if (!$this->domain_id) {
            $this->domain_id = Yii::$app->domain->getId();
        }

        $items = $this->catalogRep->getCatalogStructure([
            'domain_id' => $this->domain_id,
            'domain_clone_id' => $this->domain_id,
            'url' => $this->url,
            'depth' => $this->depth
        ]);


        $page_url = (isset($options['url']) && is_scalar($this->url)) ? trim($this->url) : '/goods/';
        $page_url = preg_replace('~/+~s', '/', $page_url . '/');

        $page_url_parts = preg_split('~/~', $page_url, -1, PREG_SPLIT_NO_EMPTY);
        $page_url_parts_count = count($page_url_parts);


        $sort_keys = array();
        $sort = array(
            'depth' => array(),
            'sort' => array(),
            'name' => array(),
            'url' => array(),
        );

        /*if (!$discount_max = \Yii::$app->ishop_db->createCommand("
           SELECT `discount_percent`
           FROM `domain_discounts`
           WHERE `domain_id` = {$domain_id}
           ORDER BY `discount_percent` DESC
           LIMIT 1
       ")) {
           $discount_max = 0;
       }*/
        $discount_max = 0;

        foreach ($items as $key => &$cdata) {
            $product = $this->catalogRep->getCatalogProductsCount($cdata['domain_id'], $cdata['url']);
            $_product_count = $product['product_count'];

            if (!$_product_count && $this->skip_empty_catalogs) {
                unset($items[$key]);
                continue;
            }

            $cdata['_products_count'] = $_product_count;
            $cdata['_products_min_price'] = round($product['products_min_price'] - ($product['products_min_price'] * $discount_max * 0.01), 2);
            //$cdata['_parameter'] = $prodamus->getPageParameters($cdata['id']);

            $cdata['__service__']['products_num'] = $_product_count;
            $cdata['__service__']['urlParts'] = preg_split('~/~', $cdata['url'], -1, PREG_SPLIT_NO_EMPTY);
            $cdata['__service__']['urlPartsCount'] = count($cdata['__service__']['urlParts']);
            $cdata['__service__']['depth'] = $cdata['__service__']['urlPartsCount'] - $page_url_parts_count;
            $cdata['__service__']['parent'] = '/' . implode('/', array_slice($cdata['__service__']['urlParts'], 0, -1, true)) . '/';
            $cdata['_subcatalogs'] = array();

            $sort['depth'][] = $cdata['__service__']['depth'];
            $sort['sort'][] = $cdata['sort'];
            $sort['name'][] = $cdata['name'];
            $sort['url'][] = $cdata['url'];
            $sort_keys[] = $cdata['url'];
        }
        unset($cdata);

        $items = $this->sort($sort, $items);
        $catalog_list = $this->buildStructure($items);

        return $this->render('catalog_structure', ['items' => $catalog_list]);
    }

    /**
     * Строим иерархическую структуру
     * @param array $items
     * @return array
     */
    protected function buildStructure(array $items){
        $catalog_list = $catalog_by_ref = array();
        foreach ($items as &$cdata) {
            $catalog_by_ref[$cdata['url']] =& $cdata;

            // формируем структуру каталога
            if (1 == $cdata['__service__']['depth']) {
                $catalog_list[$cdata['url']] =& $catalog_by_ref[$cdata['url']];
            } // добавляем страницу в структуру каталога, если есть родительская страница и привязанные товары
            elseif (isset($catalog_by_ref[$cdata['__service__']['parent']])) {
                $catalog_by_ref[$cdata['__service__']['parent']]['_subcatalogs'][$cdata['url']] =& $catalog_by_ref[$cdata['url']];
            }

            unset($cdata['__service__']);
        }
        unset($cdata);
        return $catalog_list;
    }

    /**
     * Сортируем массивы
     * @param array $sort
     * @param array $items
     * @return array
     */
    protected function sort(array $sort, array $items)
    {
        if ($this->sort_by_name) {
            array_multisort(
                $sort['depth'], SORT_NUMERIC, SORT_ASC,
                $sort['sort'], SORT_NUMERIC, SORT_DESC,
                $sort['name'], SORT_STRING, SORT_ASC,
                $sort['url'], SORT_STRING, SORT_ASC,
                $items
            );
        } else {
            array_multisort(
                $sort['depth'], SORT_NUMERIC, SORT_ASC,
                $sort['sort'], SORT_NUMERIC, SORT_DESC,
                $sort['url'], SORT_STRING, SORT_ASC,
                $items
            );
        }
        $first = reset($items);
        if (1 != $first['__service__']['depth']) {
            return array();
        }
        return $items;
    }
}