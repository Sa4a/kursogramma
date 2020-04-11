<?php

use yii\db\Migration;

/**
 * Class m200331_102723_add_image_and_desc
 */
class m200331_102723_add_image_and_desc extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\Lesson::tableName(),'image', $this->string(255)->null());
        $this->addColumn(\common\models\Lesson::tableName(),'description', $this->text()->null());

        $this->addColumn(\common\models\Course::tableName(),'image', $this->string(255)->null());
        $this->addColumn(\common\models\Course::tableName(),'description', $this->text()->null());

        $this->addColumn(\common\models\Module::tableName(),'image', $this->string(255)->null());
        $this->addColumn(\common\models\Module::tableName(),'description', $this->text()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropColumn(\common\models\Lesson::tableName(),'image');
        $this->dropColumn(\common\models\Lesson::tableName(),'description');

        $this->dropColumn(\common\models\Course::tableName(),'image');
        $this->dropColumn(\common\models\Course::tableName(),'description');

        $this->dropColumn(\common\models\Module::tableName(),'image');
        $this->dropColumn(\common\models\Module::tableName(),'description');

    }

}
