<?php


namespace app\services;


class CsvParserService
{
    public function parse($fileHandle) {
        $header = fgetcsv($fileHandle, 1000, ",");
        $header = array_map(function ($item) {
            return strtolower($item);
        }, $header);

        while (($data = fgetcsv($fileHandle, 1000, ",")) !== FALSE) {
            $dataRow = [];
            foreach ($header as $key => $field) {
                $dataRow[$field] = $data[$key] ?? "";
            }

            yield $dataRow;
        }
    }
}