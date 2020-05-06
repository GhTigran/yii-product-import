<?php


namespace app\services;


use app\models\ProductImportRow;
use app\models\StoreProduct;

class ImporterService
{
    const UPC_FIELD = 'upc';

    public function importRow($importId, int $rowNumber, int $storeId, array $dataRow) {
        $importRow = ProductImportRow::findOne([
            'import_id'  => $importId,
            'row_number' => $rowNumber,
        ]);

        if (!$importRow) {
            $importRow             = new ProductImportRow();
            $importRow->import_id  = $importId;
            $importRow->row_number = $rowNumber;
        }

        $importRow->content = implode(',', $dataRow);
        $importRow->status  = ProductImportRow::STATUS_FAIL;

        try {
            if (
                !array_key_exists(self::UPC_FIELD, $dataRow)
                || !$dataRow[self::UPC_FIELD]
            ) {
                throw new \RuntimeException('UPC is required for import row ' . $rowNumber);
            }

            $product = StoreProduct::findOne(['upc' => $dataRow[self::UPC_FIELD]]);
            if (!$product) {
                $product = new StoreProduct();
            }

            $product->store_id = $storeId;

            foreach ($dataRow as $field => $value) {
                $product->$field = $value;
            }

            $product->save();

            $importRow->status = ProductImportRow::STATUS_SUCCESS;
        } catch (\RuntimeException $e) {
            throw new \RowImportException($e->getMessage());
        } catch (\Throwable $e) {
            throw new \RowImportException('Unprocessable Row ' . $rowNumber);
        } finally {
            $importRow->save();
        }
    }
}