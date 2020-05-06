<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product_import`.
 */
class m200505_110959_create_product_import_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('product_import', [
            'id'       => $this->primaryKey()->unsigned(),
            'store_id' => $this->integer()->notNull()->unsigned(),
            'file'     => $this->string()->notNull(),
            'status'   => $this->tinyInteger()->notNull()->defaultValue(1),
        ]);

        $this->createIndex(
            'idx-product_import-store_id',
            'product_import',
            'store_id'
        );

        $this->addForeignKey(
            'fk-product_import-store_id',
            'product_import',
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
            'fk-product_import-store_id',
            'product_import'
        );

        $this->dropIndex(
            'idx-product_import-store_id',
            'product_import'
        );

        $this->dropTable('product_import');
    }
}
