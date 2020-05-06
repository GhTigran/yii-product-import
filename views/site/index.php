<?php

use app\models\ProductImport;
use app\models\ProductImportRow;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Local Express Imports';

?>

<div class="site-index">
    <h1 class="h1">
        Product imports
    </h1>

    <?= \app\widgets\Alert::widget() ?>

    <div class="nav text-right">
        <a href="<?= Url::to(['site/import'])?>" title="Add Import" class="btn btn-primary">
            Add Import
        </a>
    </div>
    <br />
    <?php if (count($imports)) { ?>
    <table class="table table-striped table-responsive">
        <thead>
        <tr>
            <th>
                Shop
            </th>
            <th>
                Import File
            </th>
            <th>
                Imported Products
            </th>
            <th width="100">
                Status
            </th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($imports as $item) { ?>
        <tr>
            <td>
                <?= $item->store->name ?>
            </td>
            <td>
                <?= $item->file ?>
            </td>
            <td>
                <?php if ($count = $item->getProductImportRows()->count()) { ?>
                <?= $item->getProductImportRows()->count() ?>
                (
                <span class="text-success">
                <?= $item->getProductImportRows()->where(['status' => ProductImportRow::STATUS_SUCCESS])->count() ?>
                </span>
                /
                <span class="text-danger">
                    <?= $item->getProductImportRows()->where(['status' => ProductImportRow::STATUS_FAIL])->count() ?>
                </span>
                )
                <?php } else { ?>
                -
                <?php } ?>
            </td>
            <td>
               <span class="label label-<?= ProductImport::STATUS_LABEL_COLORS[$item->status] ?>">
                   <?= ProductImport::STATUS_NAMES[$item->status] ?>
               </span>
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } else { ?>
        <div class="alert alert-warning">
            No imports found
        </div>
    <?php } ?>
</div>
