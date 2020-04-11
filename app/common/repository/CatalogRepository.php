<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 08.04.2020
 * Time: 12:15
 */

namespace common\repository;


class CatalogRepository
{

    protected $tbl_dppr = 'domain_page_param_rel';
    protected $tbl_dpp = 'domain_page_param';
    protected $tbl_dpt = 'domain_page_type';
    protected $tbl_dpprod = 'domain_page_product';
    protected $tbl_prod = 'products';
    protected $tbl_dp = 'domain_page';
    protected $tbl_pb = 'product_balance';
    protected $tbl_provider = 'provider';
    protected $tbl_pp = 'products_parameters';

    /**
     * Получить структуру каталога
     * @return array
     * @param array $options =array()
     */
    public function getCatalogStructure(array $options = array())
    {
        // разбираем переданные настройки
        $depth = (isset($options['depth']) && is_scalar($options['depth']) && (1 <= $options['depth'])) ? intval($options['depth']) : 1;
        $only_main = !empty($options['only_main']);
        $sort_by_name = !(isset($options['sort_by_name']) && !$options['sort_by_name']);
        $domain_id = (isset($options['domain_id']) && is_scalar($options['domain_id']) && (1 <= $options['domain_id'])) ? intval($options['domain_id']) : 0;
        $domain_clone_id = (isset($options['domain_clone_id']) && is_scalar($options['domain_clone_id']) && (1 <= $options['domain_clone_id'])) ? intval($options['domain_clone_id']) : $domain_id;
        $page_url = (isset($options['url']) && is_scalar($options['url'])) ? trim($options['url']) : '/goods/';
        $page_url = preg_replace('~/+~s', '/', $page_url . '/');


        // подготовка запросов
        $sql_where = $sql_join = array();
        if ($domain_id) {
            $sql_where[] = "DP.`domain_id` = {$domain_id}";
        }

        $sql_where = $sql_where ? ' AND ' . implode(' AND ', $sql_where) : '';

        $sql_get_sort_id = "SELECT `parameter_id` FROM `{$this->tbl_dpp}` WHERE `parameter_code` = 'sort'";
        $sql_get_sort = "SELECT `relation_value` FROM `{$this->tbl_dppr}` WHERE `page_id` = DP.`page_id` AND `domain_id` = {$domain_id} AND `parameter_id` = ({$sql_get_sort_id})";
        $sql_get_sort_clone = "SELECT `relation_value` FROM `{$this->tbl_dppr}` WHERE `page_id` = DP.`page_id` AND `domain_id` = {$domain_clone_id} AND `parameter_id` = ({$sql_get_sort_id})";
        $sql_get_name_id = "SELECT `parameter_id` FROM `{$this->tbl_dpp}` WHERE `parameter_code` = 'name'";
        $sql_get_name = "SELECT `relation_value` FROM `{$this->tbl_dppr}` WHERE `page_id` = DP.`page_id` AND `domain_id` = {$domain_id} AND `parameter_id` = ({$sql_get_name_id})";
        $sql_get_name_clone = "SELECT `relation_value` FROM `{$this->tbl_dppr}` WHERE `page_id` = DP.`page_id` AND `domain_id` = {$domain_clone_id} AND `parameter_id` = ({$sql_get_name_id})";
        $sql_get_preview_id = "SELECT `parameter_id` FROM `{$this->tbl_dpp}` WHERE `parameter_code` = 'img_preview'";
        $sql_get_preview = "SELECT `relation_value` FROM `{$this->tbl_dppr}` WHERE `page_id` = DP.`page_id` AND `domain_id` = {$domain_id} AND `parameter_id` = ({$sql_get_preview_id})";
        $sql_get_preview_clone = "SELECT `relation_value` FROM `{$this->tbl_dppr}` WHERE `page_id` = DP.`page_id` AND `domain_id` = {$domain_clone_id} AND `parameter_id` = ({$sql_get_preview_id})";
        $sql_page_url = ($page_url);
        $sql_get_pages_regexp = (1 == $depth) ? "[^/]+/" : "([^/]+/){1,{$depth}}";
        // выбираем только главные по параметру 'main'
        if ($only_main) {
            $sql_get_main_id = "SELECT `parameter_id` FROM `{$this->tbl_dpp}` WHERE `parameter_code` = 'main'";
            $sql_join[] = "INNER JOIN `{$this->tbl_dppr}` DPPR ON DPPR.`page_id` = DP.`page_id` AND DPPR.`parameter_id` = ({$sql_get_main_id}) AND DPPR.`relation_value` > 0";
        }
        $sql_join = $sql_join ? implode(' ', $sql_join) : '';

        $sql_get_pages = "
			SELECT
				DP.`page_id` id,
				DP.`page_url` url,
				DP.`page_description` description,
				DP.`domain_id`,
				IFNULL(({$sql_get_name_clone}), IFNULL(({$sql_get_name}), '')) as name,
				IFNULL(({$sql_get_sort_clone}), IFNULL(({$sql_get_sort}), 0)) as sort,
				IFNULL(({$sql_get_preview_clone}), IFNULL(({$sql_get_preview}), '')) as preview
			FROM {$this->tbl_dp} DP
			INNER JOIN {$this->tbl_dpt} DPT ON DPT.`type_id` = DP.`page_type_id`
			{$sql_join}
			WHERE DP.`page_is_active` > 0
			  AND DPT.`type_code` = 'catalog'
			  AND DP.`page_url` REGEXP '^{$sql_page_url}{$sql_get_pages_regexp}$'
			  {$sql_where}
		";

        // получение страниц
        if (!$_catalog_list = \Yii::$app->ishop_db->createCommand($sql_get_pages)->queryAll()) {
            return array();
        }
        return $_catalog_list;
    }


    /**
     * @param $domain_id
     * @param $url
     * @return mixed
     */
    public function getCatalogProductsCount($domain_id, $url)
    {
        $sql_get_products = "
				SELECT
					COUNT(P.`product_id`) as product_count,
					MIN(P.`product_price_customer` / IF(
						PP.`parameter_value` is null
						,IF(
							0<P.`parent_id`
							,(select if(`parameter_value` is null OR trim(`parameter_value`)='',1,`parameter_value`) from `{$this->tbl_pp}` where `product_id`=P.`parent_id` and `parameter_code`='amount_of_packaging')
							,1
						)
						,IF(
							trim(PP.`parameter_value`)=''
							,1
							,PP.`parameter_value`
						)
					)) as products_min_price,
					PP.`parameter_value`
				FROM {$this->tbl_dp} DP
				INNER JOIN `{$this->tbl_dpt}` DPT ON DPT.`type_id` = DP.`page_type_id`
				INNER JOIN `{$this->tbl_dpprod}` DPP ON DPP.`page_id` = DP.`page_id`
				INNER JOIN `{$this->tbl_prod}` P ON P.`product_id` = DPP.`product_id`
					AND P.`product_is_deleted` = 0
					AND P.`product_availability` > 0
				LEFT JOIN `{$this->tbl_pp}` PP ON PP.`product_id` = P.`product_id` AND PP.`parameter_code` = 'amount_of_packaging'
				LEFT JOIN `{$this->tbl_pb}` PB ON PB.`product_id` = P.`product_id` AND PB.`store_id` = 0
				LEFT JOIN `{$this->tbl_provider}` PRVDR ON PRVDR.`provider_id` = P.`provider_id`
				WHERE DP.`page_is_active` > 0
				   AND DPT.`type_code` = 'catalog'
				   AND DP.`page_url` LIKE '{$url}%'
				   AND DP.`domain_id` = {$domain_id}
				   AND (
						-- остаток товара
						PB.`product_balance` is null                                    -- не указан
						OR concat('',PB.`product_balance` * 1) != PB.`product_balance`  -- не число
						OR PB.`product_balance` > 0                                     -- положителен
						-- обновляемость остатков поставщика
						OR PRVDR.`provider_renewable` is null                           -- не указана
						OR PRVDR.`provider_renewable` > 0                               -- обновляемые
				   )
			";

        return \Yii::$app->ishop_db->createCommand($sql_get_products)->queryOne();
    }
}