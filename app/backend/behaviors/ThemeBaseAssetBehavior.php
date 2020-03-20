<?php
namespace backend\behaviors;

use yii;
use yii\base\Behavior;

/**
 * Работа с ресурсами темы
 * Class ThemeBaseAssetUrlBehavior
 * @package common\behaviors
 */
class ThemeBaseAssetBehavior extends Behavior
{
    /**
     * @var string
     */
    public $assetBundle;

    /**
     * Возвращает url для ресурсов базового бандла темы
     * @return string
     */
    public function getThemeBaseAssetUrl() {
        return Yii::$app->assetManager->bundles[$this->assetBundle]->baseUrl;
    }

}
