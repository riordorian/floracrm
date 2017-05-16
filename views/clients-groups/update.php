<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ClientsGroups */

$this->title = 'Update Clients Groups: ' . $model->NAME;
$this->params['breadcrumbs'][] = ['label' => 'Clients Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->NAME, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="clients-groups-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
