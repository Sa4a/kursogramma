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

class TextWidget extends Widget
{
    public $text = 'Баш текст';

    public function run()
    {
        return $this->render('text',['text' =>$this->text]);
    }
}