<?php

namespace app\models;

use budyaga\users\models\User;
use Yii;

/**
 * This is the model class for table "orders_schedule".
 *
 * @property integer $ID
 * @property string $NAME
 * @property integer $CLIENT_ID
 * @property integer $GIFT_RECIPIENT_ID
 * @property integer $EVENT_ID
 * @property double $SUM
 * @property string $RECEIVING_DATE_START
 * @property string $RECEIVING_DATE_END
 * @property integer $NEED_DELIVERY
 * @property integer $OPERATOR_ID
 * @property string $STATUS
 * @property double $PREPAYMENT
 * @property string $COMMENT
 *
 * @property Clients $cLIENT
 * @property Events $eVENT
 * @property GiftRecipients $gIFTRECIPIENT
 * @property User $oPERATOR
 */
class OrdersSchedule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders_schedule';
    }
    
    public $RECEIVING_TIME_START;
    public $RECEIVING_TIME_END;
    public $CLIENT;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NAME', 'CLIENT_ID', ], 'required'],
            [['CLIENT_ID', 'GIFT_RECIPIENT_ID', 'EVENT_ID', 'NEED_DELIVERY', 'OPERATOR_ID'], 'integer'],
            [['SUM', 'PREPAYMENT'], 'number'],
            [['RECEIVING_DATE_START', 'RECEIVING_DATE_END'], 'safe'],
            [['COMMENT', 'RECEIVING_TIME_START', 'RECEIVING_TIME_END'], 'string'],
            [['NAME'], 'string', 'max' => 50],
            [['STATUS'], 'string', 'max' => 30],
            [['CLIENT_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['CLIENT_ID' => 'ID']],
            [['EVENT_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Events::className(), 'targetAttribute' => ['EVENT_ID' => 'ID']],
            [['GIFT_RECIPIENT_ID'], 'exist', 'skipOnError' => true, 'targetClass' => GiftRecipients::className(), 'targetAttribute' => ['GIFT_RECIPIENT_ID' => 'ID']],
//            [['OPERATOR_ID'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['OPERATOR_ID' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'NAME' => 'Название',
            'CLIENT' => 'Клиент (телефон)',
            'CLIENT_ID' => 'Клиент',
            'GIFT_RECIPIENT_ID' => 'Получатель',
            'EVENT_ID' => 'Событие',
            'SUM' => 'Сумма заказа',
            'RECEIVING_DATE_START' => 'Подготовить с',
            'RECEIVING_TIME_START' => 'Подготовить с',
            'RECEIVING_DATE_END' => 'Подготовить до',
            'RECEIVING_TIME_END' => 'Подготовить до',
            'NEED_DELIVERY' => 'Требуется доставка',
            'OPERATOR_ID' => 'Флорист',
            'STATUS' => 'Статус',
            'PREPAYMENT' => 'Предоплата',
            'COMMENT' => 'Комментарий',
        ];
    }


    /**
     * @return bool
     */
    public function beforeValidate()
    {
        $arPost = Yii::$app->request->post();

        # Setting receiving time from clockpicker
        if( $this->load($arPost) ) {
            $obDate = new \DateTime($this->RECEIVING_DATE_START);

            if( !empty($this->RECEIVING_TIME_START) ){
                $arTimeStart = explode(':', $this->RECEIVING_TIME_START);
                $obDate->setTime($arTimeStart[0], $arTimeStart[1]);
                $this->RECEIVING_DATE_START = $obDate->format('Y-m-d H:i:s');
            }
            else{
                $this->RECEIVING_DATE_START = $obDate->format('Y-m-d H:i:s');
            }

            if( !empty($this->RECEIVING_TIME_END) ){
                $arTimeEnd = explode(':', $this->RECEIVING_TIME_END);
                $obDate->setTime($arTimeEnd[0], $arTimeEnd[1]);
                $this->RECEIVING_TIME_END = $obDate->format('Y-m-d H:i:s');
            }
            else{
                $this->RECEIVING_DATE_END = $obDate->format('Y-m-d H:i:s');
            }
        }

        return parent::beforeValidate();
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $arAttrs = $this->getAttributes();
        $arOldAttrs = $this->getOldAttributes();

        # If added new order and filled gift recipient field
        # or old gift recipient id is not equal to new gift recipient id
        # or old event id is not equal to new event id
        # and not empty event id
        # and not gift recipient id
        # then we adding new client event
        if( ($insert && !empty($arAttrs['GIFT_RECIPIENT_ID'])
            || $arOldAttrs['GIFT_RECIPIENT_ID'] != $arAttrs['GIFT_RECIPIENT_ID']
            || $arOldAttrs['EVENT_ID'] != $arAttrs['EVENT_ID']) && !empty($arAttrs['EVENT_ID']) && !empty($arAttrs['GIFT_RECIPIENT_ID']) ){
            $arClientEvent = ClientsEvents::find()->where([
                'CLIENT_ID' => $arAttrs['CLIENT_ID'],
                'EVENT_ID' => $arAttrs['EVENT_ID'],
                'GIFT_RECIPIENT_ID' => $arAttrs['GIFT_RECIPIENT_ID']
            ])->one();
            
            if( empty($arClientEvent) ){
                try{
                    $obCLientEvent = new ClientsEvents();
                    $obCLientEvent->setAttributes([
                        'CLIENT_ID' => $arAttrs['CLIENT_ID'],
                        'EVENT_ID' => $arAttrs['EVENT_ID'],
                        'GIFT_RECIPIENT_ID' => $arAttrs['GIFT_RECIPIENT_ID'],
                        'EVENT_DATE' => date('Y-m-d', strtotime($arAttrs['RECEIVING_DATE_START']))
                    ]);
                    $obCLientEvent->save();
                }
                catch(\Exception $e){
                    Yii::trace($e->getMessage(), 'flower');
                }

            }
        }
    }


    /**
     * Setting correct model fields values
     */
    public function afterFind()
    {
        parent::afterFind();
        $arAttrs = $this->getAttributes();
        
        if( !empty($arAttrs['GIFT_RECIPIENT_ID']) ){
            $this->GIFT_RECIPIENT_ID = $this->getGiftRecipient()->one()['NAME'];
        }

        if( !empty($arAttrs['EVENT_ID']) ){
            $this->EVENT_ID = $this->getEvent()->one()['NAME'];
        }

        if( !empty($arAttrs['OPERATOR_ID']) ){
            $this->OPERATOR_ID = $this->getOperator()->one()['username'];
        }

        if( !empty($arAttrs['SUM']) ){
            $this->SUM .= ' <i class="fa fa-rub"></i>';
        }

        if( !empty($arAttrs['PREPAYMENT']) ){
            $this->PREPAYMENT .= ' <i class="fa fa-rub"></i>';
        }
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Clients::className(), ['ID' => 'CLIENT_ID'])->inverseOf('ordersSchedules');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Events::className(), ['ID' => 'EVENT_ID'])->inverseOf('ordersSchedules');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGiftRecipient()
    {
        return $this->hasOne(GiftRecipients::className(), ['ID' => 'GIFT_RECIPIENT_ID'])->inverseOf('ordersSchedules');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperator()
    {
        return $this->hasOne(User::className(), ['id' => 'OPERATOR_ID'])->inverseOf('ordersSchedules');
    }
}
