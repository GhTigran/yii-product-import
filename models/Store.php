<?php


namespace app\models;

use yii\db\ActiveRecord;

class Store extends ActiveRecord
{
    public function getProductImports() {
        return $this->hasMany(ProductImport::class, ['id' => 'store_id']);
    }
}