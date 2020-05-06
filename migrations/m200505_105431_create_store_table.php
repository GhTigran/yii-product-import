<?php

use yii\db\Migration;

/**
 * Handles the creation of table `store`.
 */
class m200505_105431_create_store_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('store', [
            'id'   => $this->primaryKey()->unsigned(),
            'name' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('store');
    }
}
