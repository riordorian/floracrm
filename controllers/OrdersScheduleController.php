<?php

namespace app\controllers;

use app\models\Events;
use app\models\GiftRecipients;
use Faker\Provider\DateTime;
use Yii;
use app\models\OrdersSchedule;
use app\models\OrdersScheduleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrdersScheduleController implements the CRUD actions for OrdersSchedule model.
 */
class OrdersScheduleController extends Controller
{
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
        $searchModel = new OrdersScheduleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OrdersSchedule model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout = 'empty.php';
        
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new OrdersSchedule model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'empty.php';
        $model = new OrdersSchedule();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->render('view', [
                'model' => $this->findModel($model->ID)
            ]);
        } else {
            # Getting of the gift recipients array
            $arRecipients = GiftRecipients::getFilterValues();

            # Getting of the gift recipients array
            $arEvents = Events::getFilterValues();

            return $this->render('create', [
                'model' => $model,
                'arRecipients' => $arRecipients,
                'arEvents' => $arEvents
            ]);
        }
    }

    /**
     * Updates an existing OrdersSchedule model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = 'empty.php';
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->render('view', [
                'model' => $this->findModel($model->ID)
            ]);
        } else {
            # Getting of the gift recipients array
            $arRecipients = GiftRecipients::getFilterValues();

            # Getting of the gift recipients array
            $arEvents = Events::getFilterValues();

            return $this->render('update', [
                'model' => $model,
                'arRecipients' => $arRecipients,
                'arEvents' => $arEvents
            ]);
        }
    }


    /**
     * Updating order date by dropping
     */
    public function actionChangeDate()
    {
        if( Yii::$app->user->can('terminalWork') === false ){
            Yii::$app->user->logout();
            $this->redirect('/terminal/login/');
        }

        $arReq = \Yii::$app->getRequest()->get();
        if( !empty($arReq['ID']) && !empty($arReq['START']) ){
            $obOrder = OrdersSchedule::find()->where(['ID' => $arReq['ID']])->one();

            $timeDiff = strtotime($obOrder->RECEIVING_DATE_END) - strtotime($obOrder->RECEIVING_DATE_START);
            $newEndDateTime = date('Y-m-d H:i:s', strtotime($arReq['START']) + $timeDiff);

            try{
                $obOrder->setAttributes([
                    'ID' => $arReq['ID'],
                    'RECEIVING_DATE_START' => $arReq['START'],
                    'RECEIVING_DATE_END' => $newEndDateTime
                ]);
                
                $obOrder->save();
                
                echo json_encode(['STATUS' => true]);
            }
            catch(\Exception $e){
                Yii::trace($e->getMessage(), 'flower');
                echo json_encode(['STATUS' => false, 'ERROR_MESSAGE' => 'Updating order error']);
            }

        }
        else{
            echo json_encode(['STATUS' => false, 'ERROR_MESSAGE' => 'Incorrect params']);
        }


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
