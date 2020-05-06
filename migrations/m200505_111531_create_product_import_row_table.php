<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product_import_row`.
 */
class m200505_111531_create_product_import_row_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('product_import_row', [
            'id'         => $this->primaryKey()->unsigned(),
            'import_id'  => $this->integer()->notNull()->unsigned(),
            'row_number' => $this->integer()->notNull()->unsigned(),
            'status'     => $this->tinyInteger()->notNull()->defaultValue(1),
            'content'    => $this->text(),
        ]);

        $this->createIndex(
            'idx-product_import_row-import_id',
            'product_import_row',
            'import_id'
        );

        $this->addForeignKey(
            'fk-product_import_row-import_id',
            'product_import_row',
            'import_id',
            'product_import',
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
            'fk-product_import_row-import_id',
            'product_import_row'
        );

        $this->dropIndex(
            'idx-product_import_row-import_id',
            'product_import_row'
        );

        $this->dropTable('product_import_row');
    }
}
