<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 09.04.2020
 * Time: 14:29
 */

namespace common\repository;

use Yii;

class PageRepository extends ProdamusRepository
{

    /**
     * Получить данные страницы по URL
     *
     * @param int $domain_id
     * @param string $url
     * @return array
     */
    function getPageByUrl($domain_id, $url)
    {
        $domain_id = (int) $domain_id;
        $_url = $url;

        /*  LEFT JOIN `{$this->_cur_db['cache']}`.`{$this->_cache['tbl']['page_product_count']}` cppc
                  ON cppc.`page_id` = dp.`page_id`
                 AND cppc.`expired` > NOW()*/
//       ,cppc.`product_count` as `page_products_count`
        $sql = "
            SELECT dp.*
                ,IF ('{$_url}' = dp.`page_url`, 1, 0) '_is_cur_url_'
            FROM `{$this->domain_page}` dp
                     WHERE dp.`domain_id` = {$domain_id}
              AND dp.`page_is_active` > 0
              AND '{$_url}' LIKE CONCAT(dp.`page_url`, '%')
            ORDER BY dp.`page_url` DESC
            LIMIT 1
        ";

        $row = Yii::$app->ishop_db->createCommand($sql)->queryOne();

        return $row;

    }

    /**
     * Получение хлебных крошек
     *
     * @param string $url
     * @return array
     */
    public function getBreadcrumbs($domain_id, $url)
    {

        $pages = Yii::$app->ishop_db->createCommand("
            SELECT *
            FROM `{$this->domain_page}` t1
            WHERE `domain_id` = {$domain_id}
              AND '{$url}' LIKE CONCAT(t1.`page_url`, '%')
            ORDER BY t1.`page_url` ASC
        ")->queryAll();
        $bread = [];
        if ($pages) {
            foreach ($pages as $page) {
                $bread[] = $this->getPageParameters($page);
            }
        }
        return $bread;
    }

    /**
     * Получить параметры страницы
     * @param $page_param
     * @return array
     */
    public function getPageParameters($page_param)
    {
        $domain_id = $page_param['domain_id'];
        $_urls = preg_split('~/~', $page_param['page_url'], -1, PREG_SPLIT_NO_EMPTY);

        $_ = '/';
        foreach ($_urls as &$v) {
            $_ .= $v . '/';
            $v = ($_);
        }
        unset($v);
        array_unshift($_urls, '/');

        $sql = "   SELECT *, t1.`page_id`, t1.`parameter_id`, t3.`parameter_type_id`, t1.`domain_id` as prm_domain_id
                FROM `{$this->domain_page_param_rel}` t1
                LEFT JOIN `{$this->domain_page}` t2 ON t2.`page_id` = t1.`page_id`
                LEFT JOIN `{$this->domain_page_param}` t3 ON t3.`parameter_id` = t1.`parameter_id`
                LEFT JOIN `{$this->domain_page_param_type}` t4 ON t4.`type_id` = t3.`parameter_type_id`
                WHERE t1.`domain_id` IN ({$domain_id})
                  AND t2.`page_url` IN ('" . implode("','", $_urls) . "')
                ORDER BY t2.`page_url` ASC, t1.`relation_id` ASC
            ";

        if (!$r = Yii::$app->ishop_db->createCommand($sql)->queryAll()) {
            return $r;
        }

        $own = $inherit = array();
        foreach ($r as $k => &$v) {
            $v['is_own_parameter'] = (int) $page_param['page_id'] == $v['page_id'];
            $v['is_domain_own_parameter'] = (int) 0 == $v['prm_domain_id'];
            if ($v['is_domain_own_parameter']) {
                $own[$v['parameter_code']] = $v;
            } else {
                $inherit[$v['parameter_code']] = $v;
            }
        }
        unset($k, $v);
        $data = array_merge($inherit, $own);

        $sindex = $stname = $spname = array();
        foreach ($data as $k => $v) {
            $sindex[] = $v['type_sort'];
            $stname[] = $v['type_name'];
            $spname[] = $v['parameter_name'];
        }

        array_multisort(
            $sindex, SORT_NUMERIC, SORT_DESC,
            $stname, SORT_STRING, SORT_ASC,
            $spname, SORT_STRING, SORT_ASC,
            $data
        );

        return $data;
    }


}