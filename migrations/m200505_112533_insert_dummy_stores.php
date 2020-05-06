<?php

use yii\db\Migration;

/**
 * Class m200505_112533_insert_dummy_stores
 */
class m200505_112533_insert_dummy_stores extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->insert('store', [
            'id'   => '1',
            'name' => 'Nike',
        ]);
        $this->insert('store', [
            'id'   => '2',
            'name' => 'Adidas',
        ]);
        $this->insert('store', [
            'id'   => '3',
            'name' => 'Puma',
        ]);
        $this->insert('store', [
            'id'   => '4',
            'name' => 'Under Armour',
        ]);
        $this->insert('store', [
            'id'   => '5',
            'name' => 'New Balance',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->delete('store', ['id' => [1, 2, 3, 4, 5]]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200505_112533_insert_dummy_stores cannot be reverted.\n";

        return false;
    }
    */
}
