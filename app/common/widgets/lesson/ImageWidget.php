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

class ImageWidget extends Widget
{
    public $image = 'https://cdn.eso.org/images/thumb300y/eso1907a.jpg';

    public function run()
    {
        return $this->render('image',['image' =>$this->image]);
    }
}