<?php

use yii\db\Migration;

/**
 * Handles the creation of table `store_product`.
 */
class m200505_110044_create_store_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('store_product', [
            'id'       => $this->primaryKey()->unsigned(),
            'store_id' => $this->integer()->notNull()->unsigned(),
            'upc'      => $this->string()->notNull(),
            'title'    => $this->string()->notNull(),
            'price'    => $this->decimal(10, 2)->notNull(),
        ]);

        $this->createIndex(
            'idx-store_product-upc',
            'store_product',
            'upc',
            true
        );

        $this->createIndex(
            'idx-store_product-store_id',
            'store_product',
            'store_id'
        );

        $this->addForeignKey(
            'fk-store_product-store_id',
            'store_product',
            'store_id',
            'store',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropForeignKey(
            'fk-store_product-store_id',
            'store_product'
        );

        $this->dropIndex(
            'idx-store_product-store_id',
            'store_product'
        );

        $this->dropIndex(
            'idx-store_product-upc',
            'store_product'
        );

        $this->dropTable('store_product');
    }
}
