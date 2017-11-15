<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\MoneyMovementsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Операции';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="money-movements-index">

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-primary btn-lg btn-circle btn-add  js-widget popup']) ?>
    </p>

    <div class="js-replaceable-container">
        <?php Pjax::begin(); ?>    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'summary' => false,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'NAME',
                'AMOUNT',
                [
                    'attribute' => 'MONEY_ACCOUNT',
                    'value' => 'moneyAccount.NAME'
                ],
                'COMMENT',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['class' => 'text-right column column_actions'],
                    'buttons' => [
                        'update' => function ($url, $model, $key) {
                           return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['class' => 'js-widget popup']);
                        },
                    ]
                ],
            ],
            'tableOptions' => [
                'class' => 'table table-striped'
            ]
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
