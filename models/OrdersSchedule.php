<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders_schedule".
 *
 * @property integer $ID
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CLIENT_ID', 'GIFT_RECIPIENT_ID', 'EVENT_ID', 'SUM', 'RECEIVING_DATE_START', 'RECEIVING_DATE_END', 'NEED_DELIVERY', 'OPERATOR_ID', 'STATUS', 'PREPAYMENT'], 'required'],
            [['CLIENT_ID', 'GIFT_RECIPIENT_ID', 'EVENT_ID', 'NEED_DELIVERY', 'OPERATOR_ID'], 'integer'],
            [['SUM', 'PREPAYMENT'], 'number'],
            [['RECEIVING_DATE_START', 'RECEIVING_DATE_END'], 'safe'],
            [['STATUS'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'CLIENT_ID' => 'Клиент',
            'GIFT_RECIPIENT_ID' => 'Получатель',
            'EVENT_ID' => 'Событие',
            'SUM' => 'Сумма заказа',
            'RECEIVING_DATE_START' => 'Подготовить с',
            'RECEIVING_DATE_END' => 'Подготовить до',
            'NEED_DELIVERY' => 'Требуется доставка',
            'OPERATOR_ID' => 'Флорист',
            'STATUS' => 'Статус',
            'PREPAYMENT' => 'Предоплата',
        ];
    }
}
