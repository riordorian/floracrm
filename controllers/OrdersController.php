<?php

namespace app\controllers;

use app\models\CatalogProducts;
use app\models\CatalogSections;
use app\models\Events;
use app\models\GiftRecipients;
use app\models\Operators;
use Faker\Provider\DateTime;
use Yii;
use app\models\OrdersSchedule;
use app\models\OrdersScheduleSearch;
use yii\imagine\Image;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrdersScheduleController implements the CRUD actions for OrdersSchedule model.
 */
class OrdersController extends Controller
{
    public $viewPath = '/terminal/orders/';

    public $layout = 'terminal';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all OrdersSchedule models.
     * @return mixed
     */
    public function actionIndex()
    {
        if( Yii::$app->user->can('terminalWork') === false ){
            Yii::$app->user->logout();
            $this->redirect('/terminal/login/');
        }

        
        $arCategories = CatalogSections::find()->asArray()->all();
        $arOperstors = Operators::getList();

        return $this->render($this->viewPath . 'index', [
            'arCategories' => $arCategories,
            'arOperators' => $arOperstors
        ]);
    }


    /**
     * Getting products list
     * 
     * @param int    $categoryId
     * @param string $name
     *
     * @return string
     */
    public function actionGoodsList($categoryId = 0, $name = '')
    {
        $this->layout = 'empty';
        $rsGoods = CatalogProducts::find();
        if( !empty($categoryId) ){
            $rsGoods->andWhere(['CATALOG_SECTION_ID' => $categoryId]);
        }
        if( !empty($name) ){
            $rsGoods->andWhere(['like', 'NAME', $name]);
        }

        $arGoods = $rsGoods->asArray()->all();
        
        return $this->render($this->viewPath . 'goods-list', [
            'arGoods' => $arGoods
        ]);
    }


    /**
     * Getting products sections list
     * 
     * @return string
     */
    public function actionSectionsList()
    {
        $this->layout = 'empty';
        $arSections = CatalogSections::find()->asArray()->all();

        return $this->render($this->viewPath . 'sections-list', [
            'arSections' => $arSections
        ]);
    }


    /**
     * Updating good info
     * 
     * @param $goodId
     */
    public function actionUpdateInfo($goodId)
    {
        $this->layout = 'empty';
        if( empty($goodId) ){
            echo json_encode(['STATUS' => false, 'ERROR_MESSAGE' => 'Incorrect params']);
        }
        
        $arGood = CatalogProducts::find()->where(['ID' => $goodId])->asArray()->one();

        echo json_encode($arGood);
    }



    /**
     * Getting client discounts
     *
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    public function actionGetUserDiscounts()
    {
        $arReq = \Yii::$app->getRequest()->getBodyParams();

        if( !empty($arReq['USER_ID']) ){
            $arDiscounts = Clients::getClientDiscounts($arReq['USER_ID']);
        }

        return json_encode($arDiscounts);

    }
    
    public function actionSale()
    {
        $arReq = \Yii::$app->getRequest()->getBodyParams();
        $this->layout = 'empty';

        return $this->render('sale.php', [
            'total' => $arReq['TOTAL'],
            'discount' => $arReq['DISCOUNT'],
        ]);
    }



    /**
     * Deletes an existing OrdersSchedule model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['/terminal/']);
    }

    /**
     * Finds the OrdersSchedule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OrdersSchedule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrdersSchedule::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
