<?

use budyaga\users\models\User;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Флористы';
$this->params['breadcrumbs'][] = $this->title;
$this->context->bodyClass = 'animated_fill-none';

?><div class="clients-index"><?
//    echo $this->render('_search', ['model' => $searchModel]);

    ?><p>
        <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-primary btn-lg btn-circle btn-add']) ?>
    </p>

    <div class="js-replaceable-container"><?
        Pjax::begin();
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'summary' => false,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'username',
                'pay',
                [
                    'attribute' => 'TERMINAL_PASSWORD',
                    'value' => function($data) {
                        return str_pad($data->id, 4, '0', STR_PAD_LEFT);
                    }
                ],
                [
                    'attribute' => 'status',
                    'value' => function($data) {
                        return User::getStatusArray()[$data->status];
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['class' => 'text-right column column_actions']
                ],
            ],
            'tableOptions' => [
                'class' => 'table table-striped'
            ],
        ]);
        Pjax::end();
    ?></div>

</div>
