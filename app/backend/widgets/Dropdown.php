<?php
namespace backend\widgets;

use yii\helpers\Html;

class Dropdown extends \yii\bootstrap\Dropdown
{


    /**
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
     */
    public function init()
    {
        $class = isset($this->options['class']) ? $this->options['class'] : 'dropdown-menu';
        Html::addCssClass($this->options, $class);
    }
}