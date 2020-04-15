<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 23.03.2020
 * Time: 10:00
 */

namespace common\services;


use common\widgets\lesson\AudioWidget;
use common\widgets\lesson\ImageWidget;
use common\widgets\lesson\SliderWidget;
use common\widgets\lesson\TextImageWidget;
use common\widgets\lesson\TextWidget;
use common\widgets\lesson\TitleWidget;
use common\widgets\lesson\VideoWidget;

/**
 * Class LessonWidgetsFactory
 * @package common\services
 */
class LessonWidgetsFactory
{
    public static $widgets= [
        'titleWidget' => 'заголовок',
        'textWidget' => 'текст',
        'imageWidget' => 'картинка',
        'textImageWidget' => 'Текст - Картинка',
        'videoWidget' => 'Видео',
        'audioWidget' => 'Аудио',
        'sliderWidget' => 'Слайдер',
    ];

    public static $widgetsIcon= [
        'titleWidget' => 'fa fa-header',
        'textWidget' => 'fa fa-keyboard-o',
        'imageWidget' => 'fa fa-image',
        'textImageWidget' => 'fa fa-address-card',
        'videoWidget' => 'fa fa-file-video',
        'audioWidget' => 'fa fa-file-audio',
        'sliderWidget' => 'fa fa-images',
    ];

    protected $widget;

    /**
     * LessonWidgetsFactory constructor.
     * @param string $widgetName
     * @throws \Exception
     */
    public function __construct(string $widgetName)
    {
        $this->setWidget($widgetName);
    }

    /**
     * @param string $widgetName
     * @return null|string
     * @throws \Exception
     */
    protected function setWidget(string $widgetName)
    {
        switch ($widgetName) {
            case 'titleWidget':
                $this->widget = TitleWidget::widget([]);
                break;
            case 'textWidget':
                $this->widget = TextWidget::widget([]);
                break;
            case 'imageWidget':
                $this->widget = ImageWidget::widget([]);
                break;
            case 'textImageWidget':
                $this->widget = TextImageWidget::widget([]);
                break;
            case 'videoWidget':
                $this->widget = VideoWidget::widget([]);
                break;
            case 'audioWidget':
                $this->widget = AudioWidget::widget([]);
                break;
            case 'sliderWidget':
                $this->widget = SliderWidget::widget([]);
                break;
        }
        return null;
    }

    /**
     * @return mixed
     */
    public function getWidget(){
        return $this->widget;
    }
}