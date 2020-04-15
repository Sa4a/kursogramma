<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 09.04.2020
 * Time: 14:29
 */

namespace common\repository;

use Yii;

class PageModuleRepository extends ProdamusRepository
{
    /**
     * Получить данные модуля с кодом $module_code для страницы $page_url
     *
     * @param array $module
     * @return bool|array
     */
    function getPageModule(array $module)
    {
        $module['_parameter'] = array();
        $domains = implode(', ', array_unique(array_filter(array(
            ($module['domain_id']),
            ($this->order_params['site_id']),
            ($this->order_params['system_site_id'])
        ))));

        $sql = "
            SELECT *, t1.`parameter_id`
            FROM `{$this->domain_page_module_param_rel}` t1
            LEFT JOIN `{$this->domain_page_module_param}` t2 ON t2.`parameter_id` = t1.`parameter_id`
            WHERE t1.`domain_id` IN ({$domains})
              AND t1.`module_id` = '" . ($module['module_id']) . "'
        ";
        $p = Yii::$app->ishop_db->createCommand($sql)->queryAll();
        if (is_array($p) && count($p) == 0) {
            return false;
        }
        $own = $inherit = array();
        foreach ($p as &$v) {
            $v['__is_own_parameter__'] = (int) ($v['domain_id'] == $this->order_params['site_id']);
            if ($v['__is_own_parameter__']) {
                $own[$v['parameter_code']] = &$v;
            } else {
                $inherit[$v['parameter_code']] = &$v;
            }
        }
        unset($v);
        $module['_parameter'] = ($own + $inherit);

        return $module;
    }

    /**
     * @param $domain_id
     * @param $page_url
     * @param $module_code
     * @return mixed
     */
    public function getModuleByCode($domain_id, $page_url, $module_code)
    {
       $sql = "
            SELECT *, t1.`page_id`, t2.`domain_id`
            FROM `{$this->domain_page_module}` t1
            LEFT JOIN `{$this->domain_page}` t2 ON t2.`page_id` = t1.`page_id`
            LEFT JOIN `{$this->domains}` t3 ON t3.`domain_id` = t2.`domain_id`
            WHERE t1.`module_code` = '" . ($module_code) . "'
              AND t2.`domain_id` = '" . ($domain_id) . "'
              AND '" . ($page_url) . "' LIKE CONCAT(t2.`page_url`, '%')
            ORDER BY t2.`page_url` DESC
        ";
        $module = Yii::$app->ishop_db->createCommand($sql)->queryOne();

        if ($module) {
            return $module;
        }
        return [];
    }
}