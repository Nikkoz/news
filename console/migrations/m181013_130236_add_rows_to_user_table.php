<?php

use yii\db\Migration;

/**
 * Class m181013_130236_add_rows_to_user_table
 */
class m181013_130236_add_rows_to_user_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'name', $this->string(255)->after('username'));
        $this->addColumn('{{%user}}', 'lastname', $this->string(255)->after('name'));
        $this->addColumn('{{%user}}', 'last_auth', $this->integer()->after('status'));
        $this->addColumn('{{%user}}', 'photo', $this->integer()->null()->after('email'));

        $this->createIndex('IDX_users_photo', '{{%user}}', 'photo');
        $this->addForeignKey('IDX_users_photo', '{{%user}}', 'photo', '{{%pictures}}', 'id', 'SET NULL', 'RESTRICT');
    }

    public function down()
    {
        $this->dropForeignKey('IDX_users_photo', '{{%user}}');
        $this->dropIndex('IDX_users_photo', '{{%user}}');

        $this->dropColumn('{{%user}}', 'name');
        $this->dropColumn('{{%user}}', 'lastname');
        $this->dropColumn('{{%user}}', 'last_auth');
        $this->dropColumn('{{%user}}', 'photo');
    }
}
