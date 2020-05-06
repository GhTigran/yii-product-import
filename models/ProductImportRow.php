<?php


namespace app\models;

use yii\db\ActiveRecord;

class ProductImportRow extends ActiveRecord
{
    const STATUS_SUCCESS = 0b01;
    const STATUS_FAIL    = 0b10;

    public function getProductImport() {
        return $this->hasOne(ProductImport::class, ['id' => 'import_id']);
    }
}