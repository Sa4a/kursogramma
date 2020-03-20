<?php

use yii\db\Migration;

/**
 * Class m200319_082624_add_start_tables
 */
class m200319_082624_add_start_tables extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        if (Yii::$app->db->getTableSchema("course",true)===null) {
            $this->createTable('{{%course}}', [
                'id' => $this->primaryKey(),
                'name' => $this->string()->notNull()->unique(),
                'created_at' => $this->timestamp(),
                'updated_at' => $this->timestamp(),
            ], $tableOptions);
            $this->createIndex('course_idx', '{{%course}}', 'id');
        }

        if (Yii::$app->db->getTableSchema("module",true)===null) {
            $this->createTable('{{%module}}', [
                'id' => $this->primaryKey(),
                'name' => $this->string()->notNull()->unique(),
                'course_id' => $this->integer()->notNull(),
                'created_at' => $this->timestamp(),
                'updated_at' => $this->timestamp(),
            ], $tableOptions);
            $this->createIndex('module_idx', '{{%module}}', 'id');
            $this->createIndex('module_course_idx', '{{%module}}', 'course_id');
            $this->addForeignKey("course_module", "{{%module}}", "course_id", "{{%course}}", "id", 'CASCADE');
        }

        if (Yii::$app->db->getTableSchema("lesson",true)===null) {
            $this->createTable('{{%lesson}}', [
                'id' => $this->primaryKey(),
                'name' => $this->string()->notNull()->unique(),
                'module_id' => $this->integer()->notNull(),
                'created_at' => $this->timestamp(),
                'updated_at' => $this->timestamp(),
            ], $tableOptions);
            $this->createIndex('lesson_idx', '{{%lesson}}', 'id');
            $this->createIndex('lesson_module_idx', '{{%lesson}}', 'module_id');
            $this->addForeignKey("module_lesson", "{{%lesson}}", "module_id", "module", "id", 'CASCADE');
        }
    }

    public function down()
    {
        $this->dropTable('{{%course}}');
        $this->dropTable('{{%module}}');
        $this->dropTable('{{%lesson}}');
    }

}
