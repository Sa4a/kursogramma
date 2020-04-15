<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 08.04.2020
 * Time: 12:15
 */

namespace common\repository;

use Yii;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

class CatalogRepository extends  ProdamusRepository
{

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

        $sql_get_sort_id = "SELECT `parameter_id` FROM `{$this->domain_page_param}` WHERE `parameter_code` = 'sort'";
        $sql_get_sort = "SELECT `relation_value` FROM `{$this->domain_page_param_rel}` WHERE `page_id` = DP.`page_id` AND `domain_id` = {$domain_id} AND `parameter_id` = ({$sql_get_sort_id})";
        $sql_get_sort_clone = "SELECT `relation_value` FROM `{$this->domain_page_param_rel}` WHERE `page_id` = DP.`page_id` AND `domain_id` = {$domain_clone_id} AND `parameter_id` = ({$sql_get_sort_id})";
        $sql_get_name_id = "SELECT `parameter_id` FROM `{$this->domain_page_param}` WHERE `parameter_code` = 'name'";
        $sql_get_name = "SELECT `relation_value` FROM `{$this->domain_page_param_rel}` WHERE `page_id` = DP.`page_id` AND `domain_id` = {$domain_id} AND `parameter_id` = ({$sql_get_name_id})";
        $sql_get_name_clone = "SELECT `relation_value` FROM `{$this->domain_page_param_rel}` WHERE `page_id` = DP.`page_id` AND `domain_id` = {$domain_clone_id} AND `parameter_id` = ({$sql_get_name_id})";
        $sql_get_preview_id = "SELECT `parameter_id` FROM `{$this->domain_page_param}` WHERE `parameter_code` = 'img_preview'";
        $sql_get_preview = "SELECT `relation_value` FROM `{$this->domain_page_param_rel}` WHERE `page_id` = DP.`page_id` AND `domain_id` = {$domain_id} AND `parameter_id` = ({$sql_get_preview_id})";
        $sql_get_preview_clone = "SELECT `relation_value` FROM `{$this->domain_page_param_rel}` WHERE `page_id` = DP.`page_id` AND `domain_id` = {$domain_clone_id} AND `parameter_id` = ({$sql_get_preview_id})";
        $sql_page_url = ($page_url);
        $sql_get_pages_regexp = (1 == $depth) ? "[^/]+/" : "([^/]+/){1,{$depth}}";
        // выбираем только главные по параметру 'main'
        if ($only_main) {
            $sql_get_main_id = "SELECT `parameter_id` FROM `{$this->domain_page_param}` WHERE `parameter_code` = 'main'";
            $sql_join[] = "INNER JOIN `{$this->domain_page_param_rel}` DPPR ON DPPR.`page_id` = DP.`page_id` AND DPPR.`parameter_id` = ({$sql_get_main_id}) AND DPPR.`relation_value` > 0";
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
			FROM {$this->domain_page} DP
			INNER JOIN {$this->domain_page_type} DPT ON DPT.`type_id` = DP.`page_type_id`
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
							,(select if(`parameter_value` is null OR trim(`parameter_value`)='',1,`parameter_value`) from `{$this->products_parameters}` where `product_id`=P.`parent_id` and `parameter_code`='amount_of_packaging')
							,1
						)
						,IF(
							trim(PP.`parameter_value`)=''
							,1
							,PP.`parameter_value`
						)
					)) as products_min_price,
					PP.`parameter_value`
				FROM {$this->domain_page} DP
				INNER JOIN `{$this->domain_page_type}` DPT ON DPT.`type_id` = DP.`page_type_id`
				INNER JOIN `{$this->domain_page_product}` DPP ON DPP.`page_id` = DP.`page_id`
				INNER JOIN `{$this->products}` P ON P.`product_id` = DPP.`product_id`
					AND P.`product_is_deleted` = 0
					AND P.`product_availability` > 0
				LEFT JOIN `{$this->products_parameters}` PP ON PP.`product_id` = P.`product_id` AND PP.`parameter_code` = 'amount_of_packaging'
				LEFT JOIN `{$this->product_balance}` PB ON PB.`product_id` = P.`product_id` AND PB.`store_id` = 0
				LEFT JOIN `{$this->provider}` PRVDR ON PRVDR.`provider_id` = P.`provider_id`
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


    /**
     * Получение товаров
     *
     * @return array массив данных товаров | FALSE
     * @param mixed $products_id=NULL ID товаров (int - ID товара, array - массив ID товаров)
     * @param mixed $catalogs_id=NULL ID разделов каталога (int - ID раздела, array - массив ID разделов)
     * @param mixed $allowed=NULL (NULL | bool)
     * @param array $sort=NULL KEY - table `products` field name; VALUE - (bool) sort type (TRUE - DESC | FALSE - ASC)
     * @param array $options=NULL дополнительные опции
     */
    function getProducts($products_id = NULL, $catalogs_id = NULL, $allowed = NULL, $sort = NULL, array $options = null) {
        $_id = $where = array();

        if (is_null($options)) {
            $options = array();
        }

        // фильтр по активности товара
        if (!is_null($allowed)) {
            $where[] = 't1.`product_is_deleted`' . ($allowed ? '=0' : '>0');
        }
        // фильтр по поставщикам
        if (!empty($options['provider_filter']) && is_array($options['provider_filter'])) {
            $where[] = "(t1.`provider_id` IN (".implode(",", $options['provider_filter'])."))";
        }

        if (!empty($options['product_type_filter']) && is_array($options['product_type_filter'])) {
            $where[] = "(t1.`product_type_id` IN (".implode(",", $options['product_type_filter'])."))";
        }

        if ( !empty($options['product_availability']) ) {
            $where[] = "(t1.`product_availability` =" . $options['product_availability'] . ")";
        }

        // фильтр по ID товара
        if (!is_null($products_id)) {
            $_ = array();

            if (!is_array($products_id)) {
                $products_id = array($products_id);
            }

            foreach ($products_id as &$v) {
                if (!is_numeric($v)) {
                    return false;
                }
                elseif (1 > ($v = intval($v))) {
                    continue;
                }
                $_[] = &$v;
            }

            if ($_) {
                $_id['pid'] = 't1.`product_id` IN (' . implode(", ", $_) . ')';
            }

            unset($v, $_);
        }

        // фильтр по ID каталога
        if (!is_null($catalogs_id)) {
            $_ = array();

            if (!is_array($catalogs_id)) {
                $catalogs_id = array($catalogs_id);
            }

            foreach ($catalogs_id as &$v) {
                if (!is_numeric($v)) {
                    return false;
                }
                elseif (1 > ($v = intval($v))) {
                    continue;
                }
                $_[] = &$v;
            }

            if ($_) {
                $_id['cid'] = "t1.`product_id` IN (SELECT `product_id` FROM `{$this->products_catalog_relations}` st WHERE st.`catalog_id` IN (" . implode(", ", $_) . "))";
            }

            unset($v, $_);
        }

        // фильтр по ID товара или ID каталога
        if ($_id) {
            $where[] = '(' . implode(" OR ", $_id) . ')';
        }

        $where = $where ? ("WHERE " . implode(" AND ", $where)) : '';

        // сортировка выборки
        $table_alias_counter = 6;
        $_sort = $sort_select = array();
        $sort_tables_join = "";
        if (is_array($sort)) {
            foreach ($sort as $k => $v) {
                if ("_profit" == $k) {
                    $_sort[] = "t".$table_alias_counter.".`product_profit` " . ($v ? 'DESC' : 'ASC');
                    $sort_tables_join[] = "INNER JOIN `{$this->stat_product_profit}` t{$table_alias_counter} ON t{$table_alias_counter}.`product_id` = t1.`product_id`";
                    $table_alias_counter++;
                }
                elseif ("_popular" == $k) {
                    $_sort[] = "t".$table_alias_counter.".`product_order_count` " . ($v ? 'DESC' : 'ASC');
                    $_sort[] = "t".$table_alias_counter.".`product_count` " . ($v ? 'DESC' : 'ASC');
                    $sort_tables_join[] = "LEFT JOIN `{$this->stat_order_product}` t{$table_alias_counter} ON t{$table_alias_counter}.`product_id` = t1.`product_id`";
                    $table_alias_counter++;
                }
                elseif ('_fivestar' == $k) {
                    $_sort[] = "rating_value " . ($v ? 'DESC' : 'ASC');
                    $sort_select[] = "IFNULL((SELECT FLOOR(ROUND(2 * `rating_sum` / `voters_count`)) FROM `{$this->rating_product_summary}` WHERE `product_id` = t1.`product_id` AND `domain_id` = 0 AND `rating_code` = 'summary' GROUP BY `product_id`), 1) as rating_value";
                    $table_alias_counter++;
                }
                elseif ('_name' == $k) {
                    $_sort[] = "t{$table_alias_counter}.`parameter_value` " . ($v ? 'DESC' : 'ASC');
                    $sort_tables_join[] = "LEFT JOIN `{$this->products_parameters}` t{$table_alias_counter} ON t{$table_alias_counter}.`product_id` = t1.`product_id` AND t{$table_alias_counter}.`parameter_code` = 'name'";
                    $table_alias_counter++;
                }
                elseif ('catalog_' == substr($k, 0, 8)) {
                    $_sort[] = "t3.`{$k}` " . ($v ? 'DESC' : 'ASC');
                }
                else {
                    $_sort[] = "t1.`{$k}` " . ($v ? 'DESC' : 'ASC');
                }
            }
            $_sort[] = "t1.`product_id` ASC";
        }
        else {
            $sort = false;
        }
        $sort = $_sort ? ("ORDER BY " . implode(", ", $_sort)) : '';
        $sort_tables_join = $sort_tables_join ? (implode(" ", $sort_tables_join)) : '';
        $sort_select = $sort_select ? (", " . implode(", ", $sort_select)) : "";
        unset($table_alias_counter);

        // получение товаров
        $q = "
            SELECT
                t1.*,
                t2.*,
                t3.*,
                t4.*,
                t5.*,
                t1.product_id,
                t1.`provider_id`,
                t1.`product_class_id`,
                blnc.`product_balance`,
                (SELEct count(*) FROM `{$this->product_preset}` WHERE `set_id` = t1.`product_id`) as 'product_preset_count'
                {$sort_select}
            FROM `{$this->products}` t1
            LEFT JOIN `{$this->provider}` t4 ON t4.`provider_id` = t1.`provider_id`
            LEFT JOIN `{$this->products_catalog_relations}` t2 ON t2.`product_id` = t1.`product_id`
            LEFT JOIN `{$this->products_catalog}` t3 ON t3.`catalog_id` = t2.`catalog_id`
            LEFT JOIN `{$this->product_class}` t5 ON t5.`product_class_id` = t1.`product_class_id`
            LEFT JOIN `{$this->product_balance}` blnc ON blnc.`product_id` = t1.`product_id` AND blnc.`store_id` = 0
            {$sort_tables_join}
            {$where}
            {$sort}
        ";

        if (!$p = Yii::$app->ishop_db->createCommand($q)->queryAll()) {
            return $p;
        }
        $p = ArrayHelper::index($p,'product_id');

        if (isset($options['only_base_data']) && (true === $options['only_base_data'])) {
            return $p;
        }

        $options['domain_id'] = isset($options['domain_id']) ? intval($options['domain_id']) : 0;

        // параметры и свойства товаров
        array_walk($p, function(&$p){ $p["_property"] = $p["_parameter"] = array(); });

        $products_keys = $products_keys_inherit = array();
        foreach ($p as &$v) {
            // автоопределение класса товара
           /* if (!$v['product_class_id'] && ($_class = $this->getProductClass($v['product_price_retail'], $v['product_price_partner']))) {
                $v = array_merge($v, $_class);
            }*/

            $products_keys[$v['product_id']] = $v['product_id'];

            if ($v['parent_id']) {
                $products_keys_inherit[$v['product_id']] = $v['parent_id'];
            }
        }
        unset($v);

        // получение свойств товаров
        $q = "
            SELECT *, t1.`property_id`, t3.`catalog_id`
            FROM `{$this->products_properties_relations}` t1
            LEFT JOIN `{$this->products_properties}` t2 ON t2.`property_id` = t1.`property_id`
            LEFT JOIN `{$this->products_properties_catalog_relations}` t3 ON t3.`property_id` = t1.`property_id`
            LEFT JOIN `{$this->products_properties_catalog}` t4 ON t4.`catalog_id` = t3.`catalog_id`
            WHERE t2.`property_is_disabled` = 0 AND t1.`product_id` IN (" . implode(', ', $products_keys) . ")
            ORDER BY t2.`property_id` ASC
        ";
        if (FALSE === $products_props = Yii::$app->ishop_db->createCommand($q)->queryAll()) {
            return FALSE;
        }

        $ppl = array();
        foreach ($products_props as &$v) {
            if (!isset($ppl[$v['property_id']])) {
                $ppl[$v['property_id']] = array(
                    '_value'    => array(),
                    '_parameter'=> array(),
                );
            }
            $v['_value'] =& $ppl[$v['property_id']]['_value'];
            $v['_parameter'] =& $ppl[$v['property_id']]['_parameter'];
        }
        unset($v);
        $keys_pp = implode(', ', array_keys($ppl));

        if ($keys_pp) {
            // получение значений свойств товаров
            $q = "
                SELECT *
                FROM `{$this->products_properties_values}`
                WHERE `property_value_is_disabled` = 0 AND `property_id` IN ($keys_pp)
                ORDER BY `property_value_id` ASC
            ";
            if (FALSE === $ppv = Yii::$app->ishop_db->createCommand($q)->queryAll()) {
                return FALSE;
            }
            array_walk($ppv, function(&$v){ $v["_parameter"] = array(); });
            $keys_ppv = implode(', ', array_keys($ppv));
        }
        else {
            $keys_ppv = '';
            $ppv = array();
        }


        $p_p_where = array();
        if ($products_keys || $products_keys_inherit) {
            $p_p_where[] = "t1.`product_id` IN (" . implode(', ', array_merge($products_keys, array_unique($products_keys_inherit))) . ")";
        }
        if ($keys_pp) {
            $p_p_where[] = "t1.`property_id` IN ($keys_pp)";
        }
        if ($keys_ppv) {
            $p_p_where[] = "t1.`property_value_id` IN ($keys_ppv)";
        }

        // нет элементов, для которых надо получать параметры
        if (!$p_p_where) {
            // переопределение параметров товаров по домену
            throw new Exception("_overwriteProductParameter4Domain");
            //$this->_overwriteProductParameter4Domain($p);
            //return $p;
        }
        // получение параметров товаров
        elseif (FALSE === $p_p = Yii::$app->ishop_db->createCommand("
            SELECT
                 t1.*
                ,t2.`type_code` 'parameter_type'
                ,t2.`type_name` 'parameter_type_name'
            FROM {$this->products_parameters} t1
            LEFT JOIN {$this->products_parameters_types} t2 ON t2.`type_id` = t1.`parameter_type_id`
            WHERE (" . implode(' OR ', $p_p_where) . ") AND  t1.`parameter_active` > 0
            ORDER BY `parameter_type` ASC, `parameter_name` ASC, `parameter_code` ASC
        ")->queryAll()) {
            return FALSE;
        }

        // привязка параметр-товар
        $fOverwriteParameter = function(&$product, &$parameter) {
            // нет параметра
            if (!isset($product['_parameter'][$parameter['parameter_code']])) {
                $product['_parameter'][$parameter['parameter_code']] =& $parameter;
            }
            // это собственный параметр
            elseif ($parameter['product_id'] == $product['product_id']) {
                $product['_parameter'][$parameter['parameter_code']] =& $parameter;
            }
        };

        $prod_params = array();
        foreach ($p_p as $k => &$v) {
            if ($v['product_id']) {
                if (isset($p[$v['product_id']])) {
                    $prod_params[$v['product_id']] = &$p[$v['product_id']]['_parameter'];
                    $fOverwriteParameter($p[$v['product_id']], $v);
                }

                foreach (array_keys($products_keys_inherit, $v['product_id']) as $_) {
                    $prod_params[$_] = &$p[$_]['_parameter'];
                    $fOverwriteParameter($p[$_], $v);
                }
                unset($_);
            }
            elseif ($v['property_id']) {
                $ppl[$v['property_id']]['_parameter'][$v['parameter_code']] = &$v;
                unset($p_p[$k]);
            }
            elseif ($v['property_value_id']) {
                $ppv[$v['property_value_id']]['_parameter'][$v['parameter_code']] = &$v;
                unset($p_p[$k]);
            }
        }
        unset($p_p, $k, $v);


        // распределяем значения по свойствам
        foreach ($ppv as &$v) {
            $ppl[$v['property_id']]['_value'][$v['property_value_id']] = &$v;
        }
        unset($ppl, $ppv, $v);

        // распределяем свойства по товарам
        foreach ($products_props as &$v) {
            if (isset($p[$v['product_id']])) {
                $p[$v['product_id']]['_property'][$v['property_id']] =& $v;
            }
        }
        unset($products_props, $v);

        return $p;
    }


}