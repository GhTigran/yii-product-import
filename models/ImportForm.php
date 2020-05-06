<?php


namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class ImportForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $importFile;

    /**
     * @var int
     */
    public $storeId;

    public function rules() {
        return [
            [['importFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv, xlsx', 'maxSize'=>5242880, 'checkExtensionByMimeType' => false],
            [['storeId'], 'integer', 'skipOnEmpty' => false],
        ];
    }

    public function upload() {
        if ($this->validate()) {
            $fileName = $this->sanitize($this->importFile->baseName) . '_' . time() . '.' . $this->importFile->extension;
            $this->importFile->saveAs(\Yii::getAlias('@app/files/') . $fileName);
            return $fileName;
        } else {
            return false;
        }
    }

    private function sanitize(string $fileName) {
        return trim(preg_replace('/[^a-z0-9_]+/', '-', strtolower($fileName)), '-');
    }
}