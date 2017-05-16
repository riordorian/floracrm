<?

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Клиенты';
$this->params['breadcrumbs'][] = $this->title;
$this->context->bodyClass = 'animated_fill-none';

?><div class="clients-index"><?
    echo $this->render('_search', ['model' => $searchModel]);

    ?><p>
        <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-primary btn-lg btn-circle btn-add']) ?>
    </p><?

    Pjax::begin();
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'summary' => false,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'NAME',
                'TYPE',
                'PHONE',
                [
                    'attribute' => 'CLIENT_GROUP',
                    'value' => 'clientsClientsGroups.GroupName',
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
            'tableOptions' => [
                'class' => 'table table-striped'
            ],
        ]);
    Pjax::end();
?></div>
