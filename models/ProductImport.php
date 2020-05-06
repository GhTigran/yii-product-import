<?php


namespace app\models;

use yii\db\ActiveRecord;

class ProductImport extends ActiveRecord
{
    const STATUS_NEW     = 0b0001;
    const STATUS_PROCESS = 0b0010;
    const STATUS_DONE    = 0b0100;

    const STATUS_NAMES = [
        self::STATUS_NEW     => 'New',
        self::STATUS_PROCESS => 'In Process',
        self::STATUS_DONE    => 'Done',
    ];

    const STATUS_LABEL_COLORS = [
        self::STATUS_NEW     => 'default',
        self::STATUS_PROCESS => 'primary',
        self::STATUS_DONE    => 'success',
    ];

    public function getStore() {
        return $this->hasOne(Store::class, ['id' => 'store_id']);
    }

    public function getProductImportRows() {
        return $this->hasMany(ProductImportRow::class, ['import_id' => 'id']);
    }
}