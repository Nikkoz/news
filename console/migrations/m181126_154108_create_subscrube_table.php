<?php

use yii\db\Migration;

/**
 * Handles the creation of table `subscribe`.
 */
class m181126_154108_create_subscrube_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%news}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string(255)->notNull(),
            'created_at' => $this->integer()
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%news}}');
    }
}
