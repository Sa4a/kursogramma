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

class TitleWidget extends Widget
{
    public $title = 'Баш текст';
    public $title_footer = 'Какаято подпись';

    public function run()
    {
        return $this->render('title',['title' =>$this->title, 'title_footer'=>$this->title_footer ]);
    }
}