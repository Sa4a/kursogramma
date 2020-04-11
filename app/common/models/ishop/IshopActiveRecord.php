<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 06.04.2020
 * Time: 12:05
 */

namespace common\models\ishop;

use Yii;
use yii\db\ActiveRecord;

class IshopActiveRecord extends ActiveRecord
{
    public static function getDb() {
        return Yii::$app->ishop_db;
    }
}