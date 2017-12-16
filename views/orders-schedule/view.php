<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\OrdersSchedule */

$this->title = $model->NAME;
?>
<div class="orders-schedule-view js-ajax-replaceable white-bg p-sm">

    <h1 class="m-b-lg"><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary js-open-edit-form']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить заказ?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'template' => function($arAttr, $index, $widget){
            if( !empty($arAttr['value']) ) {
                if( in_array($arAttr['attribute'], ['RECEIVING_DATE_START', 'RECEIVING_DATE_END']) ){
                    $obDate = new DateTime();
                    $obDate->setTimestamp(strtotime($arAttr['value']));
                    $arAttr['value'] = $obDate->format('H:i');
                }
                
                return "<tr><th>{$arAttr['label']}</th><td>{$arAttr['value']}</td></tr>";
            }
        },
        'attributes' => [
            'ID',
            'client.NAME',
            'GIFT_RECIPIENT',
            'EVENT',
            'SUM_FORMATTED',
            'PREPAYMENT_FORMATTED',
            'RECEIVING_DATE_START',
            'RECEIVING_DATE_END',
            [
                'attribute' => 'NEED_DELIVERY',
                'label' => $model->getAttributeLabel('NEED_DELIVERY'),
                'value' => $model->NEED_DELIVERY == 1 ? 'Да' : 'Нет',
            ],
            'OPERATOR',
            'STATUS',
        ],
    ]) ?>

</div>
