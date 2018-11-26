<?php

use yii\db\Migration;

/**
 * Class m181109_173118_create_table_templates
 */
class m181109_173118_create_table_templates extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%rubric_templates}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'file' => $this->string(255)->notNull(),
            'count_news' => $this->integer()->defaultValue(10),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%rubric_templates}}');
    }
}
