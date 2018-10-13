<?php

use yii\db\Migration;

/**
 * Class m181013_143846_add_rows
 */
class m181013_143846_add_rows extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'photo', $this->integer()->null()->after('email'));

        $this->createIndex('IDX_users_photo', '{{%user}}', 'photo');
        $this->addForeignKey('IDX_users_photo', '{{%user}}', 'photo', '{{%pictures}}', 'id', 'SET NULL', 'RESTRICT');
    }

    public function down()
    {
        $this->dropForeignKey('IDX_users_photo', '{{%user}}');
        $this->dropIndex('IDX_users_photo', '{{%user}}');

        $this->dropColumn('{{%user}}', 'photo');
    }
}
