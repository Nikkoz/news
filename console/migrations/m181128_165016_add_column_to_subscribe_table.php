<?php

use yii\db\Migration;

/**
 * Class m181128_165016_add_column_to_subscribe_table
 */
class m181128_165016_add_column_to_subscribe_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%subscribe}}', 'last_send', $this->integer()->defaultValue(0)->after('email'));
    }

    public function down()
    {
        $this->dropColumn('{{%subscribe}}', 'last_send');
    }
}
