<?php
/**
 * Nav с поддержкой RBAC и кастомизацией стилей
 */

namespace backend\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\bootstrap\BootstrapAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Nav extends \yii\bootstrap\Nav
{

    public $containerOptions = [
        'class' =>'widget-body',
        'role' => 'navigation'
    ];

    public $itemHasChildClass = 'hasChild';

    /**
     * Initializes the widget.
     */
    public function init()
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
        if ($this->route === null && Yii::$app->controller !== null) {
            $this->route = Yii::$app->controller->getRoute();
        }
        if ($this->params === null) {
            $this->params = Yii::$app->request->getQueryParams();
        }
        $class = isset($this->options['class']) ? $this->options['class'] : 'nav';

        Html::addCssClass($this->options, $class);
    }

    public function run()
    {
        echo Html::tag('nav', $this->renderItems(), $this->containerOptions);
        BootstrapAsset::register($this->getView());
    }

    /**
     * Renders a widget's item.
     * @param string|array $item the item to render.
     * @return string the rendering result.
     * @throws InvalidConfigException
     */
    public function renderItem($item)
    {

        if (is_string($item)) {
            return $item;
        }
        if (!isset($item['label'])) {
            throw new InvalidConfigException("The 'label' option is required.");
        }

        $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
        $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];

        if(isset($item['icon'])) {
            $label = Html::tag('i', '', ['class' => $item['icon']." mr-n"]).Html::tag('span', ' ' . $label);
        }

        if(isset($item['badge'], $item['badge']['value'])) {
            $label = $label . ' ' . Html::tag('span', $item['badge']['value'], ['class' => 'badge ' . @$item['badge']['class']]);
        }

        $options = ArrayHelper::getValue($item, 'options', []);
        $items = ArrayHelper::getValue($item, 'items');
        $url = ArrayHelper::getValue($item, 'url', '#');
        $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);

        if (isset($item['active'])) {
            $active = ArrayHelper::remove($item, 'active', false);
        } else {
            $active = $this->isItemActive($item);
        }

      /*  if ($items !== null) {
            foreach ($items as $i => $item) {
                if (isset($item['url'][0]) && !Yii::$app->user->can($item['url'][0])) {
                    unset($items[$i]);
                }
            }
        }*/

        if ($items) {
            Html::addCssClass($options, $this->itemHasChildClass);
            if (is_array($items)) {
                if ($this->activateItems) {
                    $items = $this->isChildActive($items, $active);
                }
                $items = $this->renderDropdown($items, $item);
            }
        } else {
            $items = null;
        }

        if ($this->activateItems && $active) {
            Html::addCssClass($options, 'active');
        }

        $rc = '';
        if ($url == '#' ) {
            if($items) {
                $rc = Html::tag('li', Html::a($label, $url, $linkOptions) . $items, $options);
            }
        } else {
            $rc = Html::tag('li', Html::a($label, $url, $linkOptions) . $items, $options);
        }


        return $rc;
    }

    /**
     * Renders the given items as a dropdown.
     * This method is called to create sub-menus.
     * @param array $items the given items. Please refer to [[Dropdown::items]] for the array structure.
     * @param array $parentItem the parent item information. Please refer to [[items]] for the structure of this array.
     * @return string the rendering result.
     * @since 2.0.1
     */
    protected function renderDropdown($items, $parentItem)
    {
        return Dropdown::widget([
            'options' => ['class' => 'acc-menu'],
            'items' => $items,
            'encodeLabels' => $this->encodeLabels,
            'clientOptions' => false,
            'view' => $this->getView(),
        ]);
    }
}