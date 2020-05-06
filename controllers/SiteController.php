<?php

namespace app\controllers;

use app\models\ProductImport;
use app\models\ImportForm;
use app\models\Store;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error'   => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        $imports = ProductImport::find()
            ->joinWith('store')
            ->orderBy('id')
            ->all();

        return $this->render('index', ['imports' => $imports]);
    }

    public function actionImport() {
        $importForm  = new ImportForm();
        $importModel = new ProductImport();
        $stores      = Store::find()->all();

        if (Yii::$app->request->isPost) {
            $importForm->load(Yii::$app->request->post());
            $importForm->importFile = UploadedFile::getInstance($importForm, 'importFile');

            if ($fileName = $importForm->upload()) {
                $importModel->file     = $fileName;
                $importModel->store_id = $importForm->storeId;
                $importModel->save();

                Yii::$app->session->setFlash('success', "Import file successfully uploaded.");

                return $this->redirect('index');
            } else {
                Yii::$app->session->setFlash('error', "Invalid file.");
            }
        }

        return $this->render('import', [
            'model'  => $importForm,
            'stores' => $stores,
        ]);
    }
}
