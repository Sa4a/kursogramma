<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 06.04.2020
 * Time: 17:13
 */

namespace common\components;


use common\models\ishop\Domains;
use common\models\ishop\DomainsParams;
use common\repository\PageModuleRepository;
use common\repository\PageRepository;
use Yii;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class LoaderDomainOptions extends BaseObject
{
    protected $domain;
    protected $params;
    protected $params_by_code = [];
    protected $page;
    protected $page_param;
    protected $breadcrumbs;
    protected $pageModuleRep;

    /**
     * LoaderDomainOptions constructor.
     * @param array $config
     */
    public function __construct($config = [], PageRepository $pageRep, PageModuleRepository $pageModuleRep)
    {
        $this->pageModuleRep = $pageModuleRep;
        $this->domain = Domains::findOne(Yii::$app->params['domain_id']);
        if (!$this->domain) {
            throw new \DomainException("Не найден домен");
        }
        $this->params = DomainsParams::find()->where(['domain_id' => $this->domain->domain_id])->all();

        if (!$this->params) {
            throw new \DomainException("Не найдены параметры домена");
        }

        $this->page = $pageRep->getPageByUrl($this->domain->domain_id, Yii::$app->request->url);
        $this->page_param = $pageRep->getPageParameters($this->page);
        $this->breadcrumbs = $pageRep->getBreadcrumbs($this->domain->domain_id, Yii::$app->request->url);


        parent::__construct($config);
    }

    /**
     * @param string $code
     * @return string|null
     */
    public function getParamByCode(string $code)
    {
        if (empty($this->params_by_code)) {
            $this->params_by_code = ArrayHelper::index(ArrayHelper::toArray($this->params), 'param_code');
        }

        if (isset($this->params_by_code[$code])) {
            return $this->params_by_code[$code]['param_value'];
        }

        return null;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->domain->domain_id;
    }

    /**
     * @return mixed
     */
    public function getPageId()
    {
        return $this->page['page_id'];
    }


    /**
     * получаем значение параметра
     *
     * @param string $code
     * @return mixed
     */
    public function getPageParamByCode(string $code)
    {
        return $this->page_param[$code]['relation_value'];
    }

    /**
     * @return array
     */
    public function getBreadcrumbs($type = 'static')
    {
        $return = [];
        foreach ($this->breadcrumbs as $row) {
            if (isset($row['title']['page_url']) && $row['title']['page_url'] == '/') {
                continue;
            } else {
                if ($type == 'static') {
                    $return[] = [
                        'label' => $row['title']['relation_value'],
                        'url' => Url::to($row['title']['page_url'])
                    ];
                } else {
                    $return[] = [
                        'label' => $row['name']['relation_value'],
                        'url' => Url::to($row['title']['page_url'])
                    ];
                }

            }
        }
        return $return;
    }

    /**
     * @param string $code
     * @return mixed
     */
    public function getModuleByCode(string $code)
    {
        try {
            return $this->pageModuleRep->getPageModule(
                $this->pageModuleRep->getModuleByCode($this->domain->domain_id, Yii::$app->request->url, $code)
            );
        } catch (\TypeError $e) {
            return $e->getMessage();
        }
    }
}