<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%payment}}`.
 */
class m210705_183220_create_payment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%payment}}', [
            'id' => $this->primaryKey(),
            'payment_id' => $this->string(100)->notNull(),
            'email' => $this->string(100)->notNull(),
            'amount' => $this->integer()->unsigned()->notNull(),
            'created_at' => $this->timestamp()->notNull(),
        ]);
        $this->createIndex('payment_id', 'payment', 'payment_id', true);
        $this->createIndex('email', 'payment', 'email');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%payment}}');
        $this->dropIndex('payment_id', 'payment');
        $this->dropIndex('email', 'payment');
    }
}
