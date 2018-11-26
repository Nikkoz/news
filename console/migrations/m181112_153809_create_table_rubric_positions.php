<?php

use yii\db\Migration;

/**
 * Class m181112_153809_create_table_rubric_positions
 */
class m181112_153809_create_table_rubric_positions extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%rubric_positions}}', [
            'id' => $this->primaryKey(),
            'rubric_id' => $this->integer()->notNull(),
            'template_id' => $this->integer()->notNull(),
            'position' => $this->integer()->defaultValue(100),
        ], $tableOptions);

        $this->createIndex('IDX_rs_rubric_id', '{{%rubric_positions}}', 'rubric_id');
        $this->addForeignKey('IDX_rs_rubric_id', '{{%rubric_positions}}', 'rubric_id', '{{%rubrics}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createIndex('IDX_rs_template_id', '{{%rubric_positions}}', 'template_id');
        $this->addForeignKey('IDX_rs_template_id', '{{%rubric_positions}}', 'template_id', '{{%rubric_templates}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropForeignKey('IDX_rs_rubric_id', '{{%rubric_positions}}');
        $this->dropIndex('IDX_rs_rubric_id', '{{%rubric_positions}}');

        $this->dropForeignKey('IDX_rs_template_id', '{{%rubric_positions}}');
        $this->dropIndex('IDX_rs_template_id', '{{%rubric_positions}}');

        $this->dropTable('{{%rubric_positions}}');
    }
}
