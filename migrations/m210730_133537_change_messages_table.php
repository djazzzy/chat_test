<?php

use yii\db\Migration;

/**
 * Class m210730_133537_change_messages_table
 */
class m210730_133537_change_messages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk-message-user_id',
            'messages',
            'user_id',
            'users',
            'id',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-message-user_id',
            'messages'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210730_133537_change_messages_table cannot be reverted.\n";

        return false;
    }
    */
}
