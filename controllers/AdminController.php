<?php

namespace app\controllers;

use Yii;
use yii\imagine\Image;
use yii\web\Controller;
use yii\web\UploadedFile;


class AdminController extends Controller
{
    /**
     * Controller layout
     * @var string
     */
    public $layout = 'admin.php';

    /**
     * Main body class
     * @var string
     */
    public $bodyClass = 'animated_fill-none';

    /**
     * List items count
     * @var string
     */
    public $listCount = '';

    /**
     * Boolean param, fix heading on page or not
     * @var string
     */
    public $fixHeading = 'false';

    /**
     * Displays clients list.
     *
     * @return string
     */
   

    /**
     * Display admin homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Save model
     *
     * @param $model
     *
     * @throws \Exception
     */
    public function saveModel($model)
    {
        if( empty($model) ){
            throw new \Exception('Empty model');
        }

        $model->UPLOAD = UploadedFile::getInstance($model, 'UPLOAD');
        if( $model->UPLOAD ){
            $fileName = $model->UPLOAD->baseName . '.' . $model->UPLOAD->extension;

            $newImgDir = Yii::$app->params['filesUploadUrl'] . $model::tableName() . '/' . substr(md5($fileName), 0, 5) . '/';
            $newFileDir = Yii::getAlias('@webroot') . $newImgDir;
            $newFilePath = $newFileDir . $fileName;

            if( !is_dir($newFileDir) ){
                mkdir($newFileDir, 0777, true);
            }

            if( $model->UPLOAD->saveAs($newFilePath)
                &&  Image::thumbnail($newFilePath, 500, 500)->save($newFilePath) ) {
                $model->IMAGE = $newImgDir . $fileName;
            }
            $model->UPLOAD = null;
        }

        if( $model->validate() ){
            $model->save();
        }
    }
}
