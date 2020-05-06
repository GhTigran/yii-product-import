<?php

namespace app\commands;

use app\models\ProductImport;
use app\models\ProductImportRow;
use app\models\StoreProduct;
use app\services\FileParserFactory;
use app\services\ImporterService;
use \yii\helpers\Console;

class ImportController extends \yii\console\Controller
{
    const MAX_CONCURRENCY = 2;

    const CODE_IMPORT_NOT_FOUND    = 0b1;
    const CODE_IMPORT_STATUS_ISSUE = 0b10;

    public function actionRun() {
        try {
            $importsInProcess = ProductImport::find()->where(['status' => ProductImport::STATUS_PROCESS])->count();

            if ($importsInProcess >= self::MAX_CONCURRENCY) {
                $this->stdout('Maximum import concurrency reached.' . PHP_EOL, Console::FG_YELLOW);
                exit(0);
            }

            $newImports = ProductImport::find()
                ->where(['status' => ProductImport::STATUS_NEW])
                ->limit(self::MAX_CONCURRENCY - $importsInProcess);

            $processableImports = min($newImports->count(), self::MAX_CONCURRENCY - $importsInProcess);

            if (!$processableImports) {
                $this->stdout('There are no pending imports.' . PHP_EOL, Console::FG_GREEN);
                exit(0);
            }

            $this->stdout("Processing {$newImports->count()} imports" . PHP_EOL, Console::FG_GREEN);

            foreach ($newImports->each() as $newImport) {
                // Execute in background
                shell_exec('./yii import/execute ' . $newImport->id . ' 2>/dev/null >/dev/null &');
            }

            exit(0);
        } catch (\Throwable $e) {
            exit(1);
        }
    }

    public function actionExecute(int $importId) {
        $productImport = ProductImport::findOne($importId);

        if (!$productImport) {
            exit(self::CODE_IMPORT_NOT_FOUND);
        }

        if ($productImport->status != ProductImport::STATUS_NEW) {
            $this->stdout("Import $importId was already processed. Reset the status to process again.", Console::FG_RED);
            exit(self::CODE_IMPORT_STATUS_ISSUE);
        }

        $this->stdout("Processing import {$productImport->file}" . PHP_EOL);
        $productImport->status = ProductImport::STATUS_PROCESS;
        $productImport->update();

        $importService = new ImporterService();
        $fileName      = \Yii::getAlias('@app/files/') . $productImport->file;
        $parser        = FileParserFactory::create($fileName);

        if (($handle = fopen($fileName, "r")) !== FALSE) {
            try {
                $row = 1;
                foreach ($parser->parse($handle) as $dataRow) {
                    try {
                        $importService->importRow($importId, $row, $productImport->store_id, $dataRow);
                        $this->stdout('Row successfully imported ' . $row . PHP_EOL, Console::FG_GREEN);
                        $row++;
                    } catch (\RowImportException $e) {
                        $this->stderr($e->getMessage() . PHP_EOL, Console::FG_RED);
                    }
                }

                $productImport->status = ProductImport::STATUS_DONE;
            } catch (\RuntimeException $e) {
                $this->stderr($e->getMessage(), Console::FG_RED);
                exit($e->getCode());
            } catch (\Throwable $e) {
                $this->stderr($e->getMessage(), Console::FG_RED);
                exit(-1);
            } finally {
                fclose($handle);
                $productImport->status = ProductImport::STATUS_DONE;
                $productImport->update();
            }
        }
    }
}