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

class TextImageWidget extends Widget
{
    public $image = 'https://cdn.eso.org/images/thumb300y/eso1907a.jpg';
    public $text = 'test';

    public function run()
    {
        return $this->render('text_and_image',['image' =>$this->image, 'text' =>$this->text]);
    }
}