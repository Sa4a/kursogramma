<?php
/**
 * Класс работы со структурой каталога и товарами
 * @package ishop
 */
class Ishop {
	/**
	 * @var Ishop Экземпляр объекта класса Ishop
	 */
	protected static $instance;

	/**
	 * @var Prodamus Экземпляр объекта класса Prodamus
	 */
	protected static $prodamus;

	/**
	 * @var int Количество товаров на странице
	 * @access private
	 */
	private $products_per_page = 24;

	/**
	 * @var bool Возможные варианты режима отображения карточки товара (спиком - list / плитками - grid)
	 * @access private
	 */
	private $products_compact_mode = 'grid';

	/**
	 * @var string дефолтный режим сортировки
	 * @access private
	 */
	private $products_sort_mode = 'costup';

	/**
	 * @var int ID корневого каталога для выборок
	 * @access private
	 */
	private $base_catalog_id = 0;

	/**
	 * @var int максимальная глубина, о которой каталоги выводятся на сайте
	 * Относительно базового
	 * @access private
	 */
	private $max_catalog_depth = 2;

	 /**
	 * Конструктор
	 * Защищаем от создания через new Ishop
	 * @access private
	 */
	private function __construct(){}

	/**
	 * Клонирование
	 * Защищаем от создания через клонирование
	 * @access private
	 */
	private function __clone()    {}

	/**
	 * unserialize
	 * Защищаем от создания через unserialize
	 * @access private
	 */
	private function __wakeup()   {}

	/**
	 * Возвращает единственный экземпляр класса.
	 * @return Ishop
	 */
	public static function getInstance(Prodamus &$prodamus = null) {
		if (is_null(self::$instance)) {
			self::$instance = new Ishop();
		}
		if (!is_null($prodamus)) {
			self::$prodamus =& $prodamus;
		}
		return self::$instance;
	}

	/**
	 * Получить структуру каталога
	 * @return array
	 * @param array $options=array()
	 */
	public function getCatalogStructure(array $options = array()) {
		$prodamus = self::$prodamus;

		// разбираем переданные настройки
		$depth = (isset($options['depth']) && is_scalar($options['depth']) && (1 <= $options['depth'])) ? intval($options['depth']) : 1;
		$only_main = !empty($options['only_main']);
		$sort_by_name = !(isset($options['sort_by_name']) && !$options['sort_by_name']);
		$domain_id = (isset($options['domain_id']) && is_scalar($options['domain_id']) && (1 <= $options['domain_id'])) ? intval($options['domain_id']) : 0;
		$domain_clone_id = (isset($options['domain_clone_id']) && is_scalar($options['domain_clone_id']) && (1 <= $options['domain_clone_id'])) ? intval($options['domain_clone_id']) : $domain_id;
		$page_url = (isset($options['url']) && is_scalar($options['url'])) ? trim($options['url']) : '/goods/';
		$page_url = preg_replace('~/+~s', '/', $page_url . '/');
		$skip_empty_catalogs = (isset($options['skip_empty_catalogs']) && $options['skip_empty_catalogs']);

		// подготовка запросов
		$sql_where = $sql_join = array();
		if ($domain_id) {
			$sql_where[] = "DP.`domain_id` = {$domain_id}";
		}

		$sql_where = $sql_where ? ' AND ' . implode(' AND ', $sql_where) : '';
		$tbl_dppr = $prodamus->getDbTableName('domain_page_param_rel');
		$tbl_dpp = $prodamus->getDbTableName('domain_page_param');
		$tbl_dpt = $prodamus->getDbTableName('domain_page_type');
		$tbl_dpprod = $prodamus->getDbTableName('domain_page_product');
		$tbl_prod = $prodamus->getDbTableName('products');
		$tbl_dp = $prodamus->getDbTableName('domain_page');
		$tbl_pb = $prodamus->getDbTableName('product_balance');
		$tbl_provider = $prodamus->getDbTableName('provider');
		$tbl_pp = $prodamus->getDbTableName('products_prm');
		$sql_get_sort_id = "SELECT `parameter_id` FROM `{$tbl_dpp}` WHERE `parameter_code` = 'sort'";
		$sql_get_sort = "SELECT `relation_value` FROM `{$tbl_dppr}` WHERE `page_id` = DP.`page_id` AND `domain_id` = {$domain_id} AND `parameter_id` = ({$sql_get_sort_id})";
		$sql_get_sort_clone = "SELECT `relation_value` FROM `{$tbl_dppr}` WHERE `page_id` = DP.`page_id` AND `domain_id` = {$domain_clone_id} AND `parameter_id` = ({$sql_get_sort_id})";
		$sql_get_name_id = "SELECT `parameter_id` FROM `{$tbl_dpp}` WHERE `parameter_code` = 'name'";
		$sql_get_name = "SELECT `relation_value` FROM `{$tbl_dppr}` WHERE `page_id` = DP.`page_id` AND `domain_id` = {$domain_id} AND `parameter_id` = ({$sql_get_name_id})";
		$sql_get_name_clone = "SELECT `relation_value` FROM `{$tbl_dppr}` WHERE `page_id` = DP.`page_id` AND `domain_id` = {$domain_clone_id} AND `parameter_id` = ({$sql_get_name_id})";
		$sql_get_preview_id = "SELECT `parameter_id` FROM `{$tbl_dpp}` WHERE `parameter_code` = 'img_preview'";
		$sql_get_preview = "SELECT `relation_value` FROM `{$tbl_dppr}` WHERE `page_id` = DP.`page_id` AND `domain_id` = {$domain_id} AND `parameter_id` = ({$sql_get_preview_id})";
		$sql_get_preview_clone = "SELECT `relation_value` FROM `{$tbl_dppr}` WHERE `page_id` = DP.`page_id` AND `domain_id` = {$domain_clone_id} AND `parameter_id` = ({$sql_get_preview_id})";
		$sql_page_url = mysql_real_escape_string($page_url);
		$sql_get_pages_regexp = (1 == $depth) ? "[^/]+/" : "([^/]+/){1,{$depth}}";
		// выбираем только главные по параметру 'main'
		if ($only_main) {
			$sql_get_main_id = "SELECT `parameter_id` FROM `{$tbl_dpp}` WHERE `parameter_code` = 'main'";
			$sql_join[] = "INNER JOIN `{$tbl_dppr}` DPPR ON DPPR.`page_id` = DP.`page_id` AND DPPR.`parameter_id` = ({$sql_get_main_id}) AND DPPR.`relation_value` > 0";
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
			FROM {$tbl_dp} DP
			INNER JOIN {$tbl_dpt} DPT ON DPT.`type_id` = DP.`page_type_id`
			{$sql_join}
			WHERE DP.`page_is_active` > 0
			  AND DPT.`type_code` = 'catalog'
			  AND DP.`page_url` REGEXP '^{$sql_page_url}{$sql_get_pages_regexp}$'
			  {$sql_where}
		";

		// получение страниц
		if (!$_catalog_list = $prodamus->mysql->getArray($sql_get_pages, 'url')) {
			return array();
		}

		$page_url_parts = preg_split('~/~', $page_url, -1, PREG_SPLIT_NO_EMPTY);
		$page_url_parts_count = count($page_url_parts);

		if(!$discount_max = $prodamus->mysql->getItem("
			SELECT `discount_percent`
			FROM `domain_discounts`
			WHERE `domain_id` = {$domain_id}
			ORDER BY `discount_percent` DESC
			LIMIT 1
		")) {
			$discount_max = 0;
		}

		$sort_keys = array();
		$sort = array(
			'depth' => array(),
			'sort' => array(),
			'name' => array(),
			'url' => array(),
		);

		foreach ($_catalog_list as $key => &$cdata) {
			$sql_get_products = "
				SELECT
					COUNT(P.`product_id`) as product_count,
					MIN(P.`product_price_customer` / IF(
						PP.`parameter_value` is null
						,IF(
							0<P.`parent_id`
							,(select if(`parameter_value` is null OR trim(`parameter_value`)='',1,`parameter_value`) from `{$tbl_pp}` where `product_id`=P.`parent_id` and `parameter_code`='amount_of_packaging')
							,1
						)
						,IF(
							trim(PP.`parameter_value`)=''
							,1
							,PP.`parameter_value`
						)
					)) as products_min_price,
					PP.`parameter_value`
				FROM {$tbl_dp} DP
				INNER JOIN `{$tbl_dpt}` DPT ON DPT.`type_id` = DP.`page_type_id`
				INNER JOIN `{$tbl_dpprod}` DPP ON DPP.`page_id` = DP.`page_id`
				INNER JOIN `{$tbl_prod}` P ON P.`product_id` = DPP.`product_id`
					AND P.`product_is_deleted` = 0
					AND P.`product_availability` > 0
				LEFT JOIN `{$tbl_pp}` PP ON PP.`product_id` = P.`product_id` AND PP.`parameter_code` = 'amount_of_packaging'
				LEFT JOIN `{$tbl_pb}` PB ON PB.`product_id` = P.`product_id` AND PB.`store_id` = 0
				LEFT JOIN `{$tbl_provider}` PRVDR ON PRVDR.`provider_id` = P.`provider_id`
				WHERE DP.`page_is_active` > 0
				   AND DPT.`type_code` = 'catalog'
				   AND DP.`page_url` LIKE '{$cdata['url']}%'
				   AND DP.`domain_id` = {$cdata['domain_id']}
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

			$product = $prodamus->mysql->getRow($sql_get_products);
			$_product_count = $product['product_count'];

			if (!$_product_count && $skip_empty_catalogs) {
				unset($_catalog_list[$key]);
				continue;
			}

			$cdata['_products_count'] = $_product_count;
			$cdata['_products_min_price'] = round($product['products_min_price'] - ($product['products_min_price'] * $discount_max * 0.01),2);
			$cdata['_parameter'] = $prodamus->getPageParameters($cdata['id']);

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

		if ($sort_by_name) {
			array_multisort(
				$sort['depth'], SORT_NUMERIC,   SORT_ASC,
				$sort['sort'],  SORT_NUMERIC,   SORT_DESC,
				$sort['name'],  SORT_STRING,    SORT_ASC,
				$sort['url'],   SORT_STRING,    SORT_ASC,
				$_catalog_list
			);
		}
		else {
			array_multisort(
				$sort['depth'], SORT_NUMERIC,   SORT_ASC,
				$sort['sort'],  SORT_NUMERIC,   SORT_DESC,
				$sort['url'],   SORT_STRING,    SORT_ASC,
				$_catalog_list
			);
		}

		$first = reset($_catalog_list);
		if (1 != $first['__service__']['depth']) {
			return array();
		}

		$catalog_list = $catalog_by_ref = array();
		foreach ($_catalog_list as &$cdata) {
			$catalog_by_ref[$cdata['url']] =& $cdata;

			// формируем структуру каталога
			if (1 == $cdata['__service__']['depth']) {
				$catalog_list[$cdata['url']] =& $catalog_by_ref[$cdata['url']];
			}
			// добавляем страницу в структуру каталога, если есть родительская страница и привязанные товары
			elseif (isset($catalog_by_ref[$cdata['__service__']['parent']])) {
				$catalog_by_ref[$cdata['__service__']['parent']]['_subcatalogs'][$cdata['url']] =& $catalog_by_ref[$cdata['url']];
			}

			unset($cdata['__service__']);
		}
		unset($cdata);

		return $catalog_list;
	}
}