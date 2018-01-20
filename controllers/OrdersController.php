<?php

namespace app\controllers;

use app\models\CatalogProducts;
use app\models\CatalogSections;
use app\models\Clients;
use app\models\Events;
use app\models\GiftRecipients;
use app\models\MoneyAccounts;
use app\models\Operators;
use app\models\OrdersOperators;
use Faker\Provider\DateTime;
use Yii;
use app\models\Orders;
use app\models\OrdersSearch;
use yii\imagine\Image;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrdersController implements the CRUD actions for Orders model.
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
     * Lists all Orders models.
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


    /**
     * Open sale popup
     * 
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionSale()
    {
        $arReq = \Yii::$app->request->getBodyParams();
        $this->layout = 'empty';
        
        return $this->render('/terminal/sale.php', [
            'arMoneyAccounts' => MoneyAccounts::getFilterValues(['USE_ON_CASHBOX' => 1]),
            'arOperators' => !empty($arReq['OPERATORS']) ? $arReq['OPERATORS'] : [],
            'total' => empty($arReq['TOTAL']) ? 0 : $arReq['TOTAL'],
            'discount' => empty($arReq['DISCOUNT']) ? 0 : $arReq['DISCOUNT'],
            'bonus' => empty($arReq['BONUS']) ? 0 : $arReq['BONUS'],
            'prepayment' => empty($arReq['PREPAYMENT']) ? 0 : $arReq['PREPAYMENT'],
            'clientId' => empty($arReq['CLIENT_ID']) ? 0 : $arReq['CLIENT_ID'],
            'orderId' => empty($arReq['ORDER_ID']) ? '' : $arReq['ORDER_ID'],
            'sum' => empty($arReq['SUM']) ? 0 : $arReq['SUM'],
            
            'obMoneyAccounts' => new MoneyAccounts(),
            'obOrders' => new Orders(),
            'obOrdersOperators' => new OrdersOperators(),
            'obClients' => new Clients(),
        ]);
    }


    public function actionSave()
    {
        $this->layout = 'empty';
        $arReq = \Yii::$app->request->post();
        $obConnection = Yii::$app->db;
        $obTransaction = $obConnection->getTransaction();
        if( empty($this->obTransaction) ){
            $obTransaction = $obConnection->beginTransaction();
        }

        try{
            $obOrders = new Orders();
            if( $obOrders->load($arReq) ){
                
                # Saving order
                if( !empty($obOrders->ID) ){
                    $obOrders = $this->findModel($obOrders->ID);
                }
                else{
                    $obOrders->setAttribute('NAME', 'Заказ ' . date('d.m.Y H:i:s'));
                    $obOrders->setAttribute('TYPE', 'S');
                }
                
                $obOrders->setAttributes([
                    'PAYMENT_STATUS' => !empty($arReq['CLOSE_WITHOUT_PAYMENT']) ? 'W' : 'F',
                    'STATUS' => 'F',
                ]);

                $bOrderSaved = $obOrders->save(true);
                
                
                
                # Saving operators
                $bOperatorsSaved = true;
                $obOrdersOperators = new OrdersOperators();
                if( $obOrdersOperators->load($arReq) ){
                    $arOperators = $obOrdersOperators->getAttribute('OPERATOR_ID');
                    foreach($arOperators as $operatorId){
                        $obOrdersOperators->isNewRecord = true;
                        $obOrdersOperators->ID = NULL;
                        $obOrdersOperators->setAttributes([
                            'ORDER_ID' => $obOrders->ID,
                            'OPERATOR_ID' => $operatorId,
                        ]);

                        if( !$obOrdersOperators->save(false) ){
                            $bOperatorsSaved = false;
                            $obTransaction->rollBack();
                            return;
                        }
                    }
                }
                
                

                # Saving all info only if all operations done
                if( $bOrderSaved && $bOperatorsSaved ){
                    $obTransaction->commit();
                }
                else{
                    $obTransaction->rollBack();
                }
            }
        }
        catch(\Exception $e){
            $obTransaction->rollBack();
            return $this->render('/terminal/orders/_error.php', ['message' => $e->getMessage()]);
        }


    }



    /**
     * Deletes an existing Orders model.
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
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
