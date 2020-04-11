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

class VideoWidget extends Widget
{
    public $video = '---';

    public function run()
    {
        return $this->render('video',['video' =>$this->video]);
    }
}