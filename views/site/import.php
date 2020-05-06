<?php

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */

$this->title = 'Local Express Imports';

$storesDropdown = yii\helpers\ArrayHelper::map($stores, 'id', 'name');

?>
<h1 class="h1">
    Import Products
</h1>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'storeId')->dropDownList(
        $storesDropdown,
        ['prompt' => 'Select Store...']
    ); ?>
    <?= $form->field($model, 'importFile')->fileInput() ?>

    <button class="btn btn-primary">Submit</button>

<?php ActiveForm::end() ?>