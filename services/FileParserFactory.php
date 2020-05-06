<?php

namespace app\services;

class FileParserFactory
{
    public static function create(string $filename) {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        switch ($extension) {
            case 'csv':
                return new CsvParserService();
            default:
                throw new \RuntimeException('File type not supported');
        }
    }
}