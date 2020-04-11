<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 23.03.2020
 * Time: 10:04
 */

namespace common\widgets\lesson;

use yii\base\Widget;
use Yii;

class SliderWidget extends Widget
{
    public $images = ['https://cdn.eso.org/images/thumb300y/eso1907a.jpg'];

    public function run()
    {
        return $this->render('slider',['images' =>$this->images]);
    }
}