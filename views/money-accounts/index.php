<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\MoneyAccountsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Счета';
$this->params['breadcrumbs'][] = $this->title;

?><div class="money-accounts-index">
    <? // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-primary btn-lg btn-circle btn-add']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'NAME',
            [
                'attribute' => 'TYPE',
                'value' => function ($dataProvider) {
                    switch($dataProvider->TYPE){
                        case 'CASH':
                            $type = 'Наличные';
                            break;
                        case 'CARD':
                            $type = 'Банковская карта';
                            break;
                        case 'BANK_ACCOUNT':
                            $type = 'Банковский счет';
                            break;
                    }

                    return $type;
                },
            ],
            'BALANCE',
            [
                'attribute' => 'USE_ON_CASHBOX',
                'value' => function ($dataProvider) {
                    return $dataProvider->USE_ON_CASHBOX ? 'Да' : 'Нет';
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['class' => 'text-right column column_actions']
            ],
        ],
        'tableOptions' => [
            'class' => 'table table-striped'
        ]
    ]); ?>
<?php Pjax::end(); ?></div>
